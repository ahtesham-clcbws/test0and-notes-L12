<div class="max-w-7xl mx-auto p-6 md:p-12 bg-white min-h-screen">
    
    {{-- Header Section (Mock style) --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b-2 border-gray-100 pb-8">
        <div>
            <div class="text-error font-bold text-sm uppercase tracking-widest mb-2">Qs: {{ $total_question }}</div>
            <h1 class="text-4xl font-bold text-success uppercase tracking-tighter">{{ $test->title }}</h1>
        </div>
        <div class="text-right">
            <h2 class="text-5xl font-bold text-gray-900 leading-none">Result</h2>
        </div>
    </div>

    {{-- Main Container (Mock Screenshot 4 Style) --}}
    <div class="border-2 border-gray-100 rounded-[3rem] p-8 md:p-16 shadow-2xl shadow-gray-200/50 bg-white">
        
        {{-- Summary Stats Bars --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="flex items-center gap-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                <span class="w-8 h-8 rounded-full bg-success shrink-0"></span>
                <div class="flex-1 flex items-center justify-between">
                    <span class="font-bold text-gray-700 uppercase text-xs tracking-widest">Right Answer</span>
                    <span class="text-2xl font-bold text-success">{{ $correct_answer }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                <span class="w-8 h-8 rounded-full bg-error shrink-0"></span>
                <div class="flex-1 flex items-center justify-between">
                    <span class="font-bold text-gray-700 uppercase text-xs tracking-widest">Wrong Answer</span>
                    <span class="text-2xl font-bold text-error">{{ $incorrect_answer }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                <span class="w-8 h-8 rounded-full bg-gray-300 shrink-0"></span>
                <div class="flex-1 flex items-center justify-between">
                    <span class="font-bold text-gray-700 uppercase text-xs tracking-widest">Not Attempted</span>
                    <span class="text-2xl font-bold text-gray-400">{{ $not_attempted }}</span>
                </div>
            </div>
        </div>

        {{-- Question Grid --}}
        @if($test->show_answer == 1)
            <div class="flex flex-wrap gap-4 justify-center mb-16 px-4">
                @php 
                    $globalIndex = 1;
                    $responses = \App\Models\Gn_Test_Response::where('student_id', $studentId)
                        ->where('test_id', $testId)
                        ->get()
                        ->keyBy('question_id');
                    $allQuestions = $test->getQuestions()->get();
                @endphp

                @foreach ($allQuestions as $index => $question)
                    @php
                        $resp = $responses->get($question->id);
                        $isCorrect = $resp && $resp->answer === $question->mcq_answer;
                        $isUnattempted = !$resp || $resp->answer === null || $resp->answer === '';
                        
                        $bgColor = 'bg-gray-100 text-gray-400 border-gray-100'; // Not attempted
                        if (!$isUnattempted) {
                            $bgColor = $isCorrect ? 'bg-success text-white border-success shadow-lg shadow-success/20' : 'bg-error text-white border-error shadow-lg shadow-error/20';
                        }
                    @endphp
                    <button 
                        wire:click="viewSolution({{ $question->id }})"
                        class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-sm border transition-all hover:scale-110 active:scale-95 {{ $bgColor }}"
                    >
                        {{ $globalIndex++ }}
                    </button>
                @endforeach
            </div>

            <div class="text-center">
                <p class="text-gray-400 font-bold mb-8 uppercase tracking-widest text-xs">Click on each question for right answer & solutions</p>
                <div class="text-4xl font-bold text-primary uppercase tracking-tighter">
                    Total Marks : {{ $total_marks }}/{{ $final_marks }}
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <x-icon name="o-lock-closed" class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                <h3 class="text-xl font-bold text-gray-900 mb-2">Detailed Results Locked</h3>
                <p class="text-gray-500 font-medium">Administrator has disabled individual question review for this test.</p>
            </div>
        @endif
    </div>

    {{-- SOLUTION MODAL --}}
    @if($showSolutionModal && $selectedQuestionId)
        @php $q = \App\Models\QuestionBankModel::find($selectedQuestionId); @endphp
        <x-modal wire:model="showSolutionModal" class="backdrop-blur">
            <div class="space-y-6">
                <div class="text-error font-bold text-xs uppercase tracking-widest">Question Details</div>
                <div class="prose prose-lg max-w-none text-gray-900 font-bold">
                    {!! $q->question !!}
                </div>

                <div class="grid grid-cols-1 gap-3">
                    @for ($k = 1; $k <= $q->mcq_options; $k++)
                        @php 
                            $optKey = 'ans_' . $k;
                            $resp = \App\Models\Gn_Test_Response::where('student_id', $studentId)->where('test_id', $testId)->where('question_id', $q->id)->first();
                            $isCorrectOpt = $q->mcq_answer === $optKey;
                            $isStudentOpt = $resp && $resp->answer === $optKey;
                            
                            $optClass = 'border-gray-100 bg-gray-50/50';
                            if ($isCorrectOpt) $optClass = 'border-success bg-success/5 text-success';
                            elseif ($isStudentOpt) $optClass = 'border-error bg-error/5 text-error';
                        @endphp
                        <div class="p-4 rounded-xl border-2 font-bold flex gap-4 {{ $optClass }}">
                            <span class="opacity-50">({{ chr(64 + $k) }})</span>
                            <div class="flex-1">{!! $q->$optKey !!}</div>
                            @if($isCorrectOpt) <x-icon name="s-check-circle" class="w-5 h-5" /> @endif
                            @if($isStudentOpt && !$isCorrectOpt) <x-icon name="s-x-circle" class="w-5 h-5" /> @endif
                        </div>
                    @endfor
                </div>

                @if($test->show_solution == 1 && ($q->solution || $q->explanation))
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <h4 class="font-bold text-gray-900 uppercase text-xs tracking-widest mb-4 flex items-center gap-2">
                            <x-icon name="o-light-bulb" class="w-4 h-4 text-warning" /> Solution & Explanation
                        </h4>
                        <div class="prose prose-sm max-w-none text-gray-600">
                            @if($q->solution) {!! $q->solution !!} @endif
                            @if($q->explanation) <div class="mt-4 pt-4 border-t border-gray-100">{!! $q->explanation !!}</div> @endif
                        </div>
                    </div>
                @endif

                <x-button label="Close" wire:click="$set('showSolutionModal', false)" class="w-full btn-ghost font-bold" />
            </div>
        </x-modal>
    @endif

</div>
