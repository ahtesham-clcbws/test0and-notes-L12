<div class="min-h-screen bg-white flex flex-col font-sans p-12" wire:ignore.self>
    
    {{-- Header (Matches Screenshot Parity) --}}
    <div class="flex justify-between items-start mb-12 border-b border-gray-100 pb-8">
        <div>
            <div class="text-error font-black text-xl uppercase tracking-widest mb-2">QS: {{ $total_question }}</div>
            <h1 class="text-5xl font-black text-success uppercase tracking-tighter">{{ $test->title }}</h1>
        </div>
        <div class="text-right">
            <h2 class="text-7xl font-black text-gray-900 leading-none uppercase tracking-tighter opacity-80">Result</h2>
        </div>
    </div>

    {{-- Main Container Box --}}
    <div class="border border-gray-100 rounded-[5rem] p-20 shadow-sm bg-white flex-1 flex flex-col items-center">
        
        {{-- Summary Stats (Bubbles Row) --}}
        <div class="flex flex-wrap justify-center gap-12 mb-20 w-full">
            {{-- Right Answer --}}
            <div class="flex items-center gap-6 bg-gray-50/50 px-12 py-8 rounded-[2.5rem] border border-gray-100 shadow-sm min-w-[350px]">
                <span class="w-10 h-10 rounded-full bg-success"></span>
                <div class="flex items-center gap-4">
                    <span class="font-black text-gray-500 uppercase text-sm tracking-widest">Right Answer {{ $correct_answer }}</span>
                    <span class="text-4xl font-black text-success">Marks - {{ number_format($out_of_marks, 1) }}</span>
                </div>
            </div>

            {{-- Wrong Answer --}}
            <div class="flex items-center gap-6 bg-gray-50/50 px-12 py-8 rounded-[2.5rem] border border-gray-100 shadow-sm min-w-[350px]">
                <span class="w-10 h-10 rounded-full bg-error"></span>
                <div class="flex items-center gap-4">
                    <span class="font-black text-gray-500 uppercase text-sm tracking-widest">Wrong Answer {{ $incorrect_answer }}</span>
                    <span class="text-4xl font-black text-error">Marks = -{{ number_format($negative_marks, 1) }}</span>
                </div>
            </div>

            {{-- Not Attempted --}}
            <div class="flex items-center gap-6 bg-gray-50/50 px-12 py-8 rounded-[2.5rem] border border-gray-100 shadow-sm min-w-[350px]">
                <span class="w-10 h-10 rounded-full bg-gray-300"></span>
                <div class="flex-1 flex justify-between items-center">
                    <span class="font-black text-gray-500 uppercase text-sm tracking-widest">Not Attempted</span>
                    <span class="text-4xl font-black text-gray-400">{{ $not_attempted }}</span>
                </div>
            </div>
        </div>

        {{-- Question Palette --}}
        @if($test->show_answer == 1)
            <div class="flex flex-wrap gap-6 justify-center mb-24 max-w-4xl mx-auto">
                @php 
                    $globalIndex = 1;
                    $responses = \App\Models\Gn_Test_Response::where('student_id', $studentId)
                        ->where('test_id', $testId)
                        ->get()
                        ->keyBy('question_id');
                    $allQuestions = $test->getQuestions()->distinct()->get();
                @endphp

                @foreach ($allQuestions as $index => $question)
                    @php
                        $resp = $responses->get($question->id);
                        $isCorrect = $resp && $resp->answer === $question->mcq_answer;
                        $isUnattempted = !$resp || $resp->answer === null || $resp->answer === '';
                        
                        $bgColor = 'bg-gray-100 text-gray-400 border-gray-200';
                        if (!$isUnattempted) {
                            $bgColor = $isCorrect ? 'bg-success text-white border-success' : 'bg-error text-white border-error';
                        }
                    @endphp
                    <button 
                        wire:click="viewSolution({{ $question->id }})"
                        class="w-16 h-16 rounded-full flex items-center justify-center font-black text-xl border-2 transition-all hover:scale-110 shadow-sm {{ $bgColor }}"
                    >
                        {{ $globalIndex++ }}
                    </button>
                @endforeach
            </div>

            {{-- Total Marks Display (Matches Screenshot) --}}
            <div class="text-center">
                <div class="text-7xl font-black text-success uppercase tracking-tighter mb-4">
                    TOTAL MARKS = {{ number_format($final_marks, 1) }} / {{ $total_marks }}
                </div>
                <div class="text-gray-400 font-black uppercase tracking-widest text-lg">Review your answers below</div>
            </div>
        @else
            <div class="py-20 text-center">
                <x-icon name="o-lock-closed" class="w-24 h-24 text-gray-100 mx-auto mb-6" />
                <h3 class="text-3xl font-black text-gray-400 uppercase tracking-widest">Review Locked</h3>
            </div>
        @endif
    </div>

    {{-- Dashboard Link --}}
    <div class="mt-20 flex justify-center">
        <a href="{{ route('student.dashboard') }}" class="bg-gray-900 text-white px-16 py-6 rounded-3xl font-black text-2xl shadow-2xl hover:bg-black transition-all uppercase tracking-tighter">
            Back to Home
        </a>
    </div>

    {{-- SOLUTION MODAL --}}
    @if($showSolutionModal && $selectedQuestionId)
        @php $q = \App\Models\QuestionBankModel::find($selectedQuestionId); @endphp
        <x-modal wire:model="showSolutionModal" class="backdrop-blur-2xl">
            <div class="space-y-10 p-10">
                <div class="text-error font-black text-sm uppercase tracking-widest border-b-4 border-error/10 pb-4 inline-block">Question Detail</div>
                <div class="prose prose-2xl max-w-none text-gray-900 font-black leading-tight tracking-tight">
                    {!! $q->question !!}
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @for ($k = 1; $k <= $q->mcq_options; $k++)
                        @php 
                            $optKey = 'ans_' . $k;
                            $resp = \App\Models\Gn_Test_Response::where('student_id', $studentId)->where('test_id', $testId)->where('question_id', $q->id)->first();
                            $isCorrectOpt = $q->mcq_answer === $optKey;
                            $isStudentOpt = $resp && $resp->answer === $optKey;
                            
                            $optClass = 'border-gray-50 bg-gray-50/50 text-gray-400 opacity-60';
                            if ($isCorrectOpt) $optClass = 'border-success bg-success/5 text-success opacity-100 shadow-md';
                            elseif ($isStudentOpt) $optClass = 'border-error bg-error/5 text-error opacity-100 shadow-md';
                        @endphp
                        <div class="p-8 rounded-3xl border-4 font-black text-2xl flex gap-8 transition-all {{ $optClass }}">
                            <span class="opacity-20">({{ chr(64 + $k) }})</span>
                            <div class="flex-1">{!! $q->$optKey !!}</div>
                            @if($isCorrectOpt) <x-icon name="s-check-circle" class="w-10 h-10" /> @endif
                            @if($isStudentOpt && !$isCorrectOpt) <x-icon name="s-x-circle" class="w-10 h-10" /> @endif
                        </div>
                    @endfor
                </div>

                @if($test->show_solution == 1 && ($q->solution || $q->explanation))
                    <div class="bg-gray-50 rounded-[3rem] p-12 border border-gray-100">
                        <h4 class="font-black text-gray-900 uppercase text-xs tracking-widest mb-8 flex items-center gap-4">
                            <x-icon name="o-light-bulb" class="w-6 h-6 text-warning" /> Detailed Solution
                        </h4>
                        <div class="prose prose-xl max-w-none text-gray-600 font-bold">
                            @if($q->solution) {!! $q->solution !!} @endif
                            @if($q->explanation) <div class="mt-8 pt-8 border-t border-gray-200">{!! $q->explanation !!}</div> @endif
                        </div>
                    </div>
                @endif

                <x-button label="Close Review" wire:click="$set('showSolutionModal', false)" class="w-full btn-ghost font-black text-2xl uppercase tracking-tighter py-8" />
            </div>
        </x-modal>
    @endif

</div>
