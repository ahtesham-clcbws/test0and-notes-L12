<div x-data="{ 
        timeLeft: {{ $timeLeft }}, 
        timer: '--:--:--', 
        init() {
            this.updateTimer();
            setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                    this.updateTimer();
                } else {
                    $wire.submitTest();
                }
            }, 1000);
        },
        updateTimer() {
            let h = Math.floor(this.timeLeft / 3600);
            let m = Math.floor((this.timeLeft % 3600) / 60);
            let s = this.timeLeft % 60;
            this.timer = (h < 10 ? '0' + h : h) + ':' + (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
        }
    }">
    
    {{-- Sticky Header --}}
    <div class="sticky top-0 z-50 bg-white border-b-2 border-primary shadow-md mb-6">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h3 class="text-xl md:text-2xl font-black text-gray-900 truncate max-w-[50%]">{{ $test->title }}</h3>
            <div class="flex items-center gap-4 md:gap-8">
                <div class="text-error font-black text-xl md:text-2xl flex items-center gap-2 bg-error/5 px-4 py-2 rounded-xl border border-error/10">
                    <x-icon name="o-clock" class="w-6 h-6" />
                    <span x-text="timer">--:--:--</span>
                </div>
                <div class="font-bold text-lg hidden md:block text-gray-400">
                    Qs: {{ $totalQuestions }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 pb-12">
        <div class="text-error font-black text-xl mb-6 uppercase tracking-widest">
            @if ($currentQuestion) Question No {{ $currentQuestionIndex + 1 }} @endif
        </div>

        {{-- Subject Tabs (Section Navigation) --}}
        <div class="flex flex-wrap gap-2 mb-8">
            @foreach ($sections as $i => $section)
                <button 
                    class="btn btn-sm rounded-xl font-bold transition-all {{ $currentSectionIndex == $i ? 'btn-primary text-white shadow-lg shadow-primary-100' : 'btn-outline border-gray-200 text-gray-500 hover:bg-gray-50' }}" 
                    wire:click="selectQuestion({{ $i }}, 0)"
                >
                    {{ $section['section_subject']['name'] }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Question Panel --}}
            <div class="lg:col-span-3">
                <x-card class="h-full shadow-sm bg-white border-gray-100" shadow>
                    @if ($currentQuestion)
                        <div class="prose prose-lg max-w-none text-gray-800 mb-10 leading-relaxed font-medium">
                            {!! $currentQuestion->question !!}
                        </div>

                        <div class="space-y-4 mb-10">
                            @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                @php $optKey = 'ans_' . $k; @endphp
                                <label class="flex items-start gap-4 p-4 rounded-2xl border-2 transition-all cursor-pointer {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'bg-primary-50 border-primary ring-4 ring-primary-50' : 'border-gray-50 bg-gray-50/30 hover:border-gray-100' }}" wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')">
                                    <input 
                                        type="radio" 
                                        name="question_{{ $currentQuestion->id }}" 
                                        value="{{ $optKey }}" 
                                        {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} 
                                        class="radio radio-primary radio-sm mt-1" 
                                    />
                                    <div class="prose max-w-none text-gray-700 font-semibold">
                                        {!! $currentQuestion->$optKey !!}
                                    </div>
                                </label>
                            @endfor
                        </div>

                        {{-- Action Bar --}}
                        <div class="flex flex-wrap items-center justify-between gap-4 pt-8 border-t border-gray-50">
                            <div class="flex gap-3">
                                <x-button 
                                    class="rounded-xl font-bold {{ in_array($currentQuestion->id, $markedQuestions) ? 'btn-warning text-white' : 'btn-outline border-gray-200' }}" 
                                    wire:click="toggleMarkForReview({{ $currentQuestion->id }})"
                                    icon="{{ in_array($currentQuestion->id, $markedQuestions) ? 's-star' : 'o-star' }}"
                                    label="{{ in_array($currentQuestion->id, $markedQuestions) ? 'Marked' : 'Review' }}"
                                    sm
                                />
                                
                                <x-button 
                                    class="btn-ghost text-red-400 font-bold" 
                                    wire:click="clearResponse({{ $currentQuestion->id }})" 
                                    icon="o-trash"
                                    label="Clear"
                                    sm
                                />
                            </div>
                            
                            <x-button 
                                class="btn-primary rounded-xl font-black px-8 shadow-lg shadow-primary-50" 
                                wire:click="saveAndNext"
                                label="Save & Next"
                                icon-right="o-chevron-right"
                            />
                        </div>
                    @else
                        <div class="text-center py-20">
                            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <x-icon name="o-check-badge" class="w-10 h-10" />
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 mb-3">All sections complete!</h3>
                            <p class="text-gray-500 font-medium mb-8 max-w-sm mx-auto">Please review your answers before final submission.</p>
                            <x-button class="btn-error text-white btn-lg rounded-2xl font-black px-12 shadow-xl shadow-error-200" wire:click="goToReview">Review & Submit</x-button>
                        </div>
                    @endif
                </x-card>
            </div>

            {{-- Sidebar Status Grid --}}
            <div class="lg:col-span-1 bg-white border border-gray-100 rounded-2xl overflow-hidden flex flex-col shadow-sm">
                <div class="bg-primary/5 p-5 border-b border-primary/10 flex gap-4 items-center">
                    <x-avatar image="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="w-12! h-12! border-2 border-white shadow-sm" />
                    <div>
                        <div class="font-black text-gray-900 leading-none">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] font-bold text-primary-600 uppercase tracking-widest mt-1">{{ $sections[$currentSectionIndex]['section_subject']['name'] ?? 'Section' }}</div>
                    </div>
                </div>

                <div class="p-5 flex-1 overflow-y-auto">
                    {{-- Status Legend --}}
                    <div class="flex gap-4 justify-center mb-6 text-[10px] font-black uppercase tracking-tighter">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-success"></span> Ans</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-200"></span> Skip</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-warning"></span> Review</div>
                    </div>

                    <div class="grid grid-cols-5 gap-3">
                        @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                $isCurrent = ($currentQuestion && $currentQuestion->id == $qId);
                                
                                $class = 'bg-gray-50 text-gray-400 border-gray-100'; 
                                if ($hasAnswer) {
                                    $class = 'bg-success text-white border-success shadow-md shadow-success-100';
                                }
                                if ($isMarked) {
                                    $class = 'bg-warning text-white border-warning shadow-md shadow-warning-100';
                                }
                                if ($isCurrent) {
                                    $class .= ' ring-4 ring-primary ring-offset-2';
                                }
                            @endphp
                            <button 
                                class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-black border transition-all hover:scale-110 active:scale-95 {{ $class }}" 
                                wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                            >
                                {{ $qIndex + 1 }}
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <div class="p-4 bg-gray-50/50">
                    <x-button class="btn-error w-full text-white rounded-xl font-bold shadow-lg shadow-error-100" wire:click="goToReview" label="Submit Test" />
                </div>
            </div>
        </div>
    </div>

    {{-- 🔒 Summary Modal (Represents loc-Modal for 1:1 Parity) --}}
    <x-modal wire:model="showSummaryModal" title="Test Submission Summary" class="backdrop-blur">
        <div class="space-y-8">
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="p-4 rounded-2xl bg-success/5 border border-success/10">
                    <div class="text-2xl font-black text-green-600">{{ $attemptedCount }}</div>
                    <div class="text-[10px] font-bold text-green-600 uppercase">Attempted</div>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <div class="text-2xl font-black text-gray-400">{{ $notAttemptedCount }}</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase">Skipped</div>
                </div>
                <div class="p-4 rounded-2xl bg-warning/5 border border-warning/10">
                    <div class="text-2xl font-black text-amber-600">{{ $reviewCount }}</div>
                    <div class="text-[10px] font-bold text-amber-600 uppercase">Review</div>
                </div>
            </div>

            <div class="space-y-4">
                <h4 class="font-black text-gray-900 flex items-center gap-2">
                    <x-icon name="o-list-bullet" class="w-5 h-5" />
                    Questions Overview
                </h4>
                <div class="max-h-75 overflow-y-auto p-4 bg-gray-50/50 rounded-2xl border border-gray-100">
                    <div class="flex flex-wrap gap-2 justify-center">
                        @php $globalIndex = 1; @endphp
                        @foreach ($questionsList as $secIndex => $qIds)
                            @foreach($qIds as $qId)
                                @php
                                    $hasAnswer = isset($answers[$qId]);
                                    $isMarked = in_array($qId, $markedQuestions);
                                    
                                    $colorClass = 'bg-white text-gray-300 border-gray-100';
                                    if ($hasAnswer) { $colorClass = 'bg-success text-white border-success'; }
                                    if ($isMarked) { $colorClass = 'bg-warning text-white border-warning'; }
                                @endphp
                                <button 
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-black border {{ $colorClass }}" 
                                    wire:click="selectQuestion({{ $secIndex }}, {{ $loop->index }}); toggleSummaryModal()"
                                >
                                    {{ $globalIndex++ }}
                                </button>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex gap-4">
                <x-button label="Continue Test" wire:click="toggleSummaryModal" class="btn-ghost grow font-bold" />
                <x-button label="Final Submit" wire:click="submitTest" class="btn-success text-white grow font-black shadow-lg shadow-success-100" />
            </div>
        </div>
    </x-modal>

    {{-- Anti-cheat / Nav Guards --}}
    @script
    <script>
        window.onbeforeunload = function() {
            return "Are you sure you want to leave? Your progress is saved!";
        };
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
    @endscript

</div>
