<div class="min-h-screen bg-white flex flex-col font-sans p-8 md:p-12">
    
    {{-- Header Section --}}
    <div class="flex justify-between items-end mb-16 border-b border-gray-100 pb-10">
        <div class="flex-1">
            <div class="text-error font-black text-lg uppercase tracking-widest mb-3">QS: {{ $total_question }}</div>
            <h1 class="text-5xl font-black text-success uppercase tracking-tighter leading-tight">{{ $test->title }}</h1>
        </div>
        <div class="text-right">
            <h2 class="text-7xl font-black text-gray-900 leading-none uppercase tracking-tighter">Result</h2>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="border border-gray-100 rounded-[4rem] p-12 md:p-20 shadow-sm bg-white flex-1">
        
        {{-- Summary Stats (Bubbles) --}}
        <div class="flex flex-wrap justify-center gap-10 mb-20">
            <div class="flex items-center gap-6 bg-gray-50/30 px-10 py-6 rounded-3xl border border-gray-100 shadow-sm">
                <span class="w-10 h-10 rounded-full bg-success"></span>
                <div class="flex items-center gap-4">
                    <span class="font-black text-gray-500 uppercase text-sm tracking-widest">Right Answer {{ $correct_answer }}</span>
                    <span class="text-3xl font-black text-success">Marks - {{ number_format($out_of_marks, 1) }}</span>
                </div>
            </div>

            <div class="flex items-center gap-6 bg-gray-50/30 px-10 py-6 rounded-3xl border border-gray-100 shadow-sm">
                <span class="w-10 h-10 rounded-full bg-error"></span>
                <div class="flex items-center gap-4">
                    <span class="font-black text-gray-500 uppercase text-sm tracking-widest">Wrong Answer {{ $incorrect_answer }}</span>
                    <span class="text-3xl font-black text-error">Marks = -{{ number_format($negative_marks, 1) }}</span>
                </div>
            </div>

            <div class="flex items-center gap-6 bg-gray-50/30 px-10 py-6 rounded-3xl border border-gray-100 shadow-sm">
                <span class="w-10 h-10 rounded-full bg-gray-300"></span>
                <div class="flex items-center gap-4">
                    <span class="font-black text-gray-500 uppercase text-sm tracking-widest">Not Attempted</span>
                    <span class="text-3xl font-black text-gray-400">{{ $not_attempted }}</span>
                </div>
            </div>
        </div>

        {{-- Question Grid --}}
        @if($test->show_answer == 1)
            <div class="flex flex-wrap gap-6 justify-center mb-24 max-w-5xl mx-auto">
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
                        
                        $bgColor = 'bg-gray-100 text-gray-400 border-gray-200'; // Not attempted
                        if (!$isUnattempted) {
                            $bgColor = $isCorrect ? 'bg-success text-white border-success shadow-lg shadow-success/10' : 'bg-error text-white border-error shadow-lg shadow-error/10';
                        }
                    @endphp
                    <button 
                        wire:click="viewSolution({{ $question->id }})"
                        class="w-16 h-16 rounded-full flex items-center justify-center font-black text-lg border-2 transition-all hover:scale-110 {{ $bgColor }}"
                    >
                        {{ $globalIndex++ }}
                    </button>
                @endforeach
            </div>

            <div class="text-center">
                <div class="text-6xl font-black text-success uppercase tracking-tighter mb-4">
                    Total Marks = {{ number_format($final_marks, 1) }} / {{ $total_marks }}
                </div>
                <div class="text-gray-400 font-black uppercase tracking-widest text-sm">Review your answers below</div>
            </div>
        @else
            <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <x-icon name="o-lock-closed" class="w-20 h-20 text-gray-200 mx-auto mb-6" />
                <h3 class="text-2xl font-black text-gray-900 mb-2 uppercase">Results Locked</h3>
                <p class="text-gray-500 font-bold">Review of individual answers is disabled for this test.</p>
            </div>
        @endif
    </div>

    {{-- Final Back Button --}}
    <div class="mt-16 flex justify-center">
        <a href="{{ route('student.dashboard') }}" class="bg-gray-900 text-white px-12 py-5 rounded-2xl font-black text-xl shadow-xl hover:bg-gray-800 transition-all uppercase tracking-tight">
            Back to Dashboard
        </a>
    </div>

    {{-- SOLUTION MODAL --}}
    @if($showSolutionModal && $selectedQuestionId)
        @php $q = \App\Models\QuestionBankModel::find($selectedQuestionId); @endphp
        <x-modal wire:model="showSolutionModal" class="backdrop-blur-xl">
            <div class="space-y-8 p-6">
                <div class="text-error font-black text-sm uppercase tracking-widest border-b border-gray-100 pb-2">Question Detail</div>
                <div class="prose prose-2xl max-w-none text-gray-900 font-black leading-tight">
                    {!! $q->question !!}
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @for ($k = 1; $k <= $q->mcq_options; $k++)
                        @php 
                            $optKey = 'ans_' . $k;
                            $resp = \App\Models\Gn_Test_Response::where('student_id', $studentId)->where('test_id', $testId)->where('question_id', $q->id)->first();
                            $isCorrectOpt = $q->mcq_answer === $optKey;
                            $isStudentOpt = $resp && $resp->answer === $optKey;
                            
                            $optClass = 'border-gray-50 bg-gray-50/30 text-gray-500';
                            if ($isCorrectOpt) $optClass = 'border-success bg-success/5 text-success';
                            elseif ($isStudentOpt) $optClass = 'border-error bg-error/5 text-error';
                        @endphp
                        <div class="p-6 rounded-2xl border-2 font-black text-xl flex gap-6 {{ $optClass }}">
                            <span class="opacity-30">({{ chr(64 + $k) }})</span>
                            <div class="flex-1">{!! $q->$optKey !!}</div>
                            @if($isCorrectOpt) <x-icon name="s-check-circle" class="w-8 h-8" /> @endif
                            @if($isStudentOpt && !$isCorrectOpt) <x-icon name="s-x-circle" class="w-8 h-8" /> @endif
                        </div>
                    @endfor
                </div>

                @if($test->show_solution == 1 && ($q->solution || $q->explanation))
                    <div class="bg-gray-50 rounded-3xl p-10 border border-gray-100 shadow-inner">
                        <h4 class="font-black text-gray-900 uppercase text-sm tracking-widest mb-6 flex items-center gap-3">
                            <x-icon name="o-light-bulb" class="w-6 h-6 text-warning" /> Solution & Explanation
                        </h4>
                        <div class="prose prose-lg max-w-none text-gray-600 font-medium">
                            @if($q->solution) {!! $q->solution !!} @endif
                            @if($q->explanation) <div class="mt-6 pt-6 border-t border-gray-200">{!! $q->explanation !!}</div> @endif
                        </div>
                    </div>
                @endif

                <x-button label="Close Review" wire:click="$set('showSolutionModal', false)" class="w-full btn-ghost font-black text-xl uppercase tracking-tighter" />
            </div>
        </x-modal>
    @endif

</div>
