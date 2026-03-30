<div>
    {{-- Stable Bridge for JS Countdown --}}
    <div id="countdown-bridge" data-time-left="{{ $timeLeft }}" data-end-timestamp="{{ $endTimestamp }}" class="hidden"></div>
    @if ($currentView == 'instructions')
        {{-- ============================ SCREENSHOT 1: INSTRUCTIONS ============================ --}}
        <div class="max-w-7xl mx-auto py-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                {{-- MAIN CONTENT --}}
                <div class="lg:col-span-3">
                    <x-card class="shadow-sm">
                        <div class="mb-6">
                            <h2 class="text-3xl font-bold text-base-content mb-2">{{ $test->title }}</h2>
                            <div class="flex flex-wrap gap-4 text-sm text-base-content/70 items-center">
                                <x-badge value="{{ count($sections) }} Sections" class="badge-neutral" />
                                <span><x-icon name="o-clock" class="w-4 h-4 inline" /> Duration: {{ $test->time_to_complete ?? 60 }} mins</span>
                                <span><x-icon name="o-document-text" class="w-4 h-4 inline" /> Questions: {{ $totalQuestions }}</span>
                                <span class="text-primary font-bold"><x-icon name="o-play-circle" class="w-4 h-4 inline" /> Live Test</span>
                                <span>{{ date('d F Y') }}</span>
                            </div>
                        </div>

                        <x-header title="Instructions" size="text-xl" separator progress-indicator />

                        {{-- LEGEND --}}
                        <div class="flex flex-wrap gap-6 my-6 bg-base-200 p-4 rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="w-4 h-4 rounded-full bg-success inline-block"></span>
                                <span class="font-medium text-sm">Attempted</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-4 h-4 rounded-full bg-neutral inline-block"></span>
                                <span class="font-medium text-sm">Not Attempted</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="relative inline-block">
                                    <span class="w-4 h-4 rounded-full bg-neutral inline-block"></span>
                                    <x-icon name="s-star" class="w-3 h-3 text-warning absolute -top-1 -right-1" />
                                </span>
                                <span class="font-medium text-sm">Mark for Review</span>
                            </div>
                        </div>

                        {{-- TERMS --}}
                        <div class="prose max-w-none text-base-content/80 space-y-2 mb-8">
                            <p>• 0.25% marks will be deducted for each wrong answer.</p>
                            <p>• 2 marks will be provided for each correct answer.</p>
                            <p>• Total time will be allotted / count for whole test, time will not be calculated for each question.</p>
                            <p>• Time for test is set according to the server.</p>
                        </div>

                        <x-checkbox id="instruction-check" label="I agree to all instructions and terms." checked class="checkbox-primary mb-6" />

                        <x-button label="Start Test" icon="o-play" wire:click="startTest" class="btn-primary w-full sm:w-auto px-10" />
                    </x-card>
                </div>

                {{-- SIDEBAR PROFILE --}}
                <div class="lg:col-span-1">
                    <x-card class="bg-primary/10 border-primary/20 text-center shadow-sm">
                        <div class="flex flex-col items-center justify-center py-4">
                            <div class="avatar mb-4">
                                <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                    <img src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" alt="Profile" />
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-base-content">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-base-content/60 mt-1">City Competition Classes</p>
                        </div>
                    </x-card>
                </div>

            </div>
        </div>

    @elseif ($currentView == 'testing')
        {{-- ============================ SCREENSHOT 2: CONDUCT TEST (CUSTOM CSS LAYOUT) ============================ --}}
        {{-- Sticky Header --}}
        <div class="sticky top-0 z-50 bg-base-100 border-b-2 border-primary shadow-sm mb-4">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <h3 class="text-xl md:text-2xl font-bold text-primary truncate max-w-[50%]">{{ $test->title }}</h3>
                <div class="flex items-center gap-4 md:gap-8">
                    <div class="text-error font-bold text-lg md:text-xl flex items-center gap-2">
                        <x-icon name="o-clock" class="w-6 h-6" />
                        <span id="timer-display" wire:ignore>--:--:--</span>
                    </div>
                    <div class="font-bold text-lg hidden md:block">
                        Qs: {{ $totalQuestions }}
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 pb-8">
            <div class="text-error font-bold text-xl mb-4">
                @if ($currentQuestion) Question No {{ $currentQuestionIndex + 1 }} @endif
            </div>

            {{-- Subject Tabs --}}
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach ($sections as $i => $section)
                    <button class="btn btn-sm {{ $currentSectionIndex == $i ? 'btn-primary text-white' : 'btn-outline border-base-300' }}" wire:click="selectQuestion({{ $i }}, 0)">
                        {{ $section['section_subject']['name'] }}
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Question Panel --}}
                <div class="lg:col-span-3">
                    <x-card class="h-full shadow-sm bg-base-100">
                        @if ($currentQuestion)
                            <div class="prose max-w-none text-lg mb-8 text-base-content" style="line-height: 1.6;">
                                {!! $currentQuestion->question !!}
                            </div>

                            <div class="space-y-3 mb-8">
                                @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                    @php $optKey = 'ans_' . $k; @endphp
                                    <label class="flex items-start gap-3 p-3 rounded-lg border border-base-200 hover:border-primary/50 cursor-pointer transition-colors {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'bg-primary/5 border-primary' : '' }}" wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')">
                                        <input id="answer_{{ $currentQuestion->id }}_{{ $k }}" class="radio radio-primary radio-sm mt-1" type="radio" name="question_{{ $currentQuestion->id }}" value="{{ $optKey }}" {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} />
                                        <div class="prose max-w-none m-0 text-base-content">
                                            {!! $currentQuestion->$optKey !!}
                                        </div>
                                    </label>
                                @endfor
                            </div>

                            {{-- Action Bar --}}
                            <div class="flex flex-wrap items-center justify-between gap-3 pt-6 border-t border-base-200">
                                <div class="flex gap-2">
                                    <x-button class="btn-warning btn-sm" wire:click="toggleMarkForReview({{ $currentQuestion->id }})">
                                        <x-icon name="{{ in_array($currentQuestion->id, $markedQuestions) ? 's-star' : 'o-star' }}" class="w-4 h-4" />
                                        {{ in_array($currentQuestion->id, $markedQuestions) ? 'Unmark Review' : 'Mark for Review' }}
                                    </x-button>
                                    
                                    <x-button class="btn-ghost btn-sm text-error" wire:click="clearResponse({{ $currentQuestion->id }})" icon="o-arrow-path">
                                        Clear
                                    </x-button>
                                </div>
                                
                                <x-button class="btn-success btn-sm text-white" wire:click="saveAndNext">
                                    Save & Next <x-icon name="o-chevron-right" class="w-4 h-4 ml-1" />
                                </x-button>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <x-icon name="o-check-circle" class="w-16 h-16 text-success mx-auto mb-4" />
                                <h3 class="text-2xl font-bold mb-2">Review Sections complete.</h3>
                                <p class="text-base-content/70 mb-6">Click the button below to review your answers before final submission.</p>
                                <x-button class="btn-error text-white btn-lg" wire:click="goToReview">Review Choices</x-button>
                            </div>
                        @endif
                    </x-card>
                </div>

                {{-- Sidebar Grid --}}
                <div class="lg:col-span-1 border-2 border-primary bg-base-100 rounded-lg overflow-hidden flex flex-col">
                    <div class="bg-primary/10 p-4 border-b border-primary/20 flex gap-4 items-center">
                        <x-avatar image="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="w-12! h-12! border bg-base-100" />
                        <div>
                            <div class="font-bold text-sm">{{ auth()->user()->name }}</div>
                            <div class="badge badge-primary badge-sm mt-1">{{ $sections[$currentSectionIndex]['section_subject']['name'] ?? 'Exam' }}</div>
                        </div>
                    </div>

                    <div class="p-4 flex-1 overflow-y-auto">
                        <div class="grid grid-cols-5 gap-2 mb-6 cursor-pointer">
                            @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                                @php
                                    $hasAnswer = isset($answers[$qId]);
                                    $isMarked = in_array($qId, $markedQuestions);
                                    
                                    $colorClass = 'bg-base-300 text-base-content border-transparent'; 
                                    if ($hasAnswer) {
                                        $colorClass = 'bg-success text-white border-success';
                                    }
                                    if ($isMarked) {
                                        $colorClass .= ' ring-2 ring-warning ring-offset-1';
                                    }
                                @endphp
                                <button class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border hover:opacity-80 transition hover:scale-105 relative {{ $colorClass }}" wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})">
                                    {{ $qIndex + 1 }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="p-3 border-t border-base-200">
                        <x-button class="btn-success w-full text-white" wire:click="goToReview">Review & Submit</x-button>
                    </div>
                </div>
            </div>
        </div>

    @elseif ($currentView == 'review')
        {{-- ============================ SCREENSHOT 3: REVIEW BEFORE SUBMIT ============================ --}}
        <div class="bg-base-100 border-b-2 border-primary mb-6 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="font-bold text-lg">Qs: {{ $totalQuestions }}</div>
                <h3 class="text-2xl font-bold text-primary text-center truncate">{{ $test->title }}</h3>
                <div class="text-error font-bold text-xl">Time Left : <span id="timer-display-review" wire:ignore>--:--:--</span></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 pb-8">
            <x-card class="bg-base-100 shadow-sm border border-base-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-center">
                    <div class="p-4 border border-base-300 rounded-xl shadow-sm flex items-center justify-between bg-base-50">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-success inline-block"></span>
                            <span class="font-bold">Attempted</span>
                        </div>
                        <span class="font-bold text-lg bg-base-200 px-4 py-1 rounded-md">{{ $attemptedCount }}</span>
                    </div>
                    <div class="p-4 border border-base-300 rounded-xl shadow-sm flex items-center justify-between bg-base-50">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-neutral inline-block"></span>
                            <span class="font-bold">Not Attempted</span>
                        </div>
                        <span class="font-bold text-lg bg-base-200 px-4 py-1 rounded-md">{{ $notAttemptedCount }}</span>
                    </div>
                    <div class="p-4 border border-base-300 rounded-xl shadow-sm flex items-center justify-between bg-base-50">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded-full bg-warning inline-block"></span>
                            <span class="font-bold">For Review</span>
                        </div>
                        <span class="font-bold text-lg bg-base-200 px-4 py-1 rounded-md">{{ $reviewCount }}</span>
                    </div>
                </div>

                <div class="divider">Questions Overview</div>

                <div class="flex flex-wrap gap-3 justify-center mb-8 p-4 bg-base-200/50 rounded-xl border border-base-200">
                    @php $globalIndex = 1; @endphp
                    @foreach ($questionsList as $secIndex => $qIds)
                        @foreach($qIds as $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                
                                $colorClass = 'bg-base-300 text-base-content';
                                if ($hasAnswer) {
                                    $colorClass = 'bg-success text-white border-success';
                                }
                                if ($isMarked) {
                                    $colorClass .= ' ring-2 ring-warning ring-offset-1';
                                }
                            @endphp
                            <button class="w-10 h-10 rounded-full flex items-center justify-center font-bold border border-base-300 hover:scale-110 transition shadow-sm relative {{ $colorClass }}" 
                                  wire:click="selectQuestion({{ $secIndex }}, {{ $loop->index }}); $set('currentView', 'testing');">
                                {{ $globalIndex++ }}
                            </button>
                        @endforeach
                    @endforeach
                </div>

                <div class="text-center max-w-md mx-auto">
                    <x-button label="Final Submit" class="btn-success text-white w-full btn-lg font-bold shadow-lg" wire:click="submitTest" />
                    <p class="text-xs text-base-content/50 mt-3">By clicking Submit, your responses will be locked and graded.</p>
                </div>
            </x-card>
        </div>
    @endif

    {{-- 🔒 Anti-coop Offline Guard --}}
    <div wire:offline class="position-fixed top-0 inset-s-0 w-100 p-3 text-center bg-danger text-white fs-5" style="z-index: 9999;">
        <i class="ti-alert"></i> Connection Intermittent. Please do not close this window, responses will sync when reconnected.
    </div>

    @push('scripts')
        <script>
            if (window.timerInterval) {
                clearInterval(window.timerInterval);
            }

            const bridge = document.getElementById('countdown-bridge');
            
            function syncWithBridge() {
                if (!bridge) return;
                
                let endTs = parseInt(bridge.getAttribute('data-end-timestamp'));
                if (endTs) {
                    window.testEndTime = endTs;
                    return;
                }

                let currentBridgeVal = parseInt(bridge.getAttribute('data-time-left')) || 0;
                let expectedEndTime = Date.now() + (currentBridgeVal * 1000);

                if (!window.testEndTime || Math.abs(window.testEndTime - expectedEndTime) > 3000) {
                    window.testEndTime = expectedEndTime;
                }
            }

            syncWithBridge(); // Initial sync

            const timerDisplay = document.getElementById('timer-display');
            const timerDisplayReview = document.getElementById('timer-display-review');

            function updateTimer() {
                if (!bridge) return;
                
                let now = Date.now();
                let diff = Math.max(0, Math.floor((window.testEndTime - now) / 1000));

                if (diff <= 0) {
                    // Hybrid Safety: check with server before final submit
                    @this.verifyTimerStatus().then(() => {
                         let finalBridgeVal = parseInt(bridge.getAttribute('data-time-left')) || 0;
                         if (finalBridgeVal <= 0) {
                               @this.submitTest();
                         } else {
                               syncWithBridge();
                         }
                    });
                    // Don't clearInterval yet, let verifyTimerStatus decide if it's really the end
                }

                const hours = Math.floor(diff / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = Math.floor(diff % 60);

                let hms = (hours < 10 ? '0' + hours : hours) + ":" +
                          (minutes < 10 ? '0' + minutes : minutes) + ":" +
                          (seconds < 10 ? '0' + seconds : seconds);

                if (timerDisplay) timerDisplay.innerHTML = hms;
                if (timerDisplayReview) timerDisplayReview.innerHTML = hms;
            }

            window.timerInterval = setInterval(updateTimer, 1000);
            updateTimer(); 

            // Livewire hook to re-sync after any update
            document.addEventListener('livewire:init', () => {
                Livewire.hook('request', ({ succeed }) => {
                    succeed(() => {
                        setTimeout(() => {
                            syncWithBridge();
                            updateTimer();
                        }, 50);
                    });
                });
            });
            
            window.onbeforeunload = function() {
                return "Are you sure you want to leave the test? Your progress is saved, but time continues ticking!";
            };

            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            };
        </script>
    @endpush
</div>
