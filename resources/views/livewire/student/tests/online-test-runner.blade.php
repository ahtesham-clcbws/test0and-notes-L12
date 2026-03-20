<div>
    @section('css')
        <style>
            .number-que-list { display: flex; flex-wrap: wrap; flex-direction: row; align-content: space-between; justify-content: space-around; }
            .numberlist { height: 25px; width: 25px; border: solid 1px grey; border-radius: 50%; display: block; text-align: center; }
            .numberlist:hover { background-color: #03b97c; color: #fff; }
            .question-grid { display: grid; grid-template-columns: repeat(10, 1fr); justify-items: center; gap: 6px; }
            
            /* Status Colors synced with wire state */
            .bg-answered { background-color: #04ba65 !important; color: #fff !important; }
            .bg-unvisited { background-color: #adb5bd !important; color: #000 !important; }

            /* 🟢 Custom Styles for Online Test (No Bootstrap Conflicts) */
            .ot-header { display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #fff; border-bottom: 2px solid #04ba65; margin-bottom: 10px; }
            .ot-header-title { color: #04ba65; font-weight: bold; font-size: 24px; margin: 0; }
            .ot-header-stats { display: flex; gap: 30px; align-items: center; }
            .ot-timer { color: red; font-weight: bold; font-size: 20px; margin: 0; }
            .ot-questions-count { color: #000; font-weight: bold; font-size: 20px; margin: 0; }
            .ot-question-number { color: red; font-weight: bold; font-size: 20px; margin-bottom: 15px; }
            .ot-subject-tabs { display: flex; gap: 8px; margin-bottom: 20px; }
            .ot-tab { background: #dcebd2; color: #000; padding: 8px 16px; font-weight: bold; text-decoration: none; cursor: pointer; border: none; }
            .ot-tab.active { background: #04ba65; color: #fff; }
            .ot-container { display: flex; gap: 20px; align-items: flex-start; }
            .ot-question-panel { flex: 1; background: #fff; border: 1px solid #ddd; border-radius: 4px; padding: 25px; box-shadow: 0px 2px 4px rgba(0,0,0,0.03); }
            .ot-question-box { padding-bottom: 0px; margin-bottom: 0px; }
            .ot-question-text { font-size: 18px; line-height: 1.5; margin-bottom: 25px; color: #333; }
            .ot-options-list { list-style: none; padding: 0; margin: 0 0 40px 0; }
            .ot-option-item { display: flex; align-items: flex-start; margin-bottom: 15px; }
            .ot-option-label { display: flex; align-items: flex-start; gap: 12px; cursor: pointer; font-size: 16px; width: 100%; }
            .ot-option-input { width: 18px; height: 18px; cursor: pointer; opacity: 1 !important; position: static !important; -webkit-appearance: auto !important; appearance: auto !important; margin-top: 3px; }
            .ot-action-bar { display: flex; gap: 10px; border-top: 1px solid #ddd; padding-top: 20px; }
            .ot-btn { padding: 8px 16px; font-weight: bold; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 16px; }
            .ot-btn-success { background: #04ba65; color: #fff; }
            .ot-btn-clear { background: #ffffda; color: red; border: 1px solid #ccc !important; }
            .ot-btn-next { background: #04ba65; color: #fff; margin-left: auto; }
            .ot-sidebar { width: 320px; border: 2px solid #04ba65; background: #fff; }
            .ot-profile { display: flex; background: #e1e9d9; align-items: stretch; border-bottom: 1px solid #ccc; }
            .ot-profile-img-wrap { background: #fff; padding: 8px; border-right: 1px solid #ccc; }
            .ot-profile-img { width: 60px; height: 60px; object-fit: cover; }
            .ot-profile-info { flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
            .ot-profile-name { padding-top: 10px; font-weight: bold; color: #000; text-align: center; font-size: 16px; }
            .ot-profile-subject { background: #04ba65; color: #fff; text-align: center; padding: 4px; font-weight: bold; font-size: 14px; }
            .ot-sidebar-content { padding: 15px; }
            .ot-grid { display: grid; grid-template-columns: repeat(10, 1fr); gap: 6px; margin-bottom: 20px; }
            .ot-node { width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px; cursor: pointer; border: 1px solid #888; text-decoration: none; color: #000; }
            .ot-node-answered { background: #04ba65 !important; color: #fff !important; border-color: #04ba65 !important; }
            .ot-node-unvisited { background: #adb5bd !important; color: #000 !important; }
            .ot-star-badge { position: absolute; top: -6px; left: 50%; transform: translateX(-50%); font-size: 16px; color: gold; text-shadow: 0px 0px 2px #000; }
            .ot-sidebar-links { display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 15px; }
            .ot-sidebar-link { color: #04ba65; font-weight: bold; text-decoration: none; }
            .ot-submit-btn { display: block; width: 100%; background: #04ba65; color: #fff; text-align: center; padding: 12px; font-weight: bold; border: none; font-size: 18px; cursor: pointer; }
        </style>
    @endsection

    {{-- Continuous polling trigger for countdown validations (30s intervals hybrid) --}}
    <div wire:poll.30s="verifyTimerStatus"></div>
    <div id="countdown-bridge" data-time-left="{{ $timeLeft }}" style="display:none;"></div>

    @if ($currentView == 'instructions')
        {{-- ============================ SCREENSHOT 1: INSTRUCTIONS ============================ --}}
        <div class="container py-4">
            <div class="row">
                <div class="col-md-9 bg-white p-4 border rounded" style="border-radius:8px;">
                    <h2 class="mb-1" style="font-weight: bold; color: #333;">{{ $test->title }} <span class="fs-6 text-muted">({{ count($sections) }} Sections) • Duration: {{ $test->time_to_complete ?? 60 }} Minutes • Questions: {{ $totalQuestions }}</span></h2>
                    <p class="small text-muted mb-4">{{ date('d F Y') }} <span style="color:magenta; font-weight:bold; margin-left: 10px;">Live Test</span></p>
                    
                    <h4 style="border-bottom: 2px solid #333; display:inline-block; padding-bottom:4px; font-weight:bold;">Instruction</h4>
                    
                    <div class="d-flex gap-4 my-4 align-items-center">
                        <div><span class="d-inline-block bg-success rounded-circle me-1" style="width:16px; height:16px; background-color:#03b97c !important;"></span> Attempted</div>
                        <div><span class="d-inline-block bg-secondary rounded-circle me-1" style="width:16px; height:16px; background-color:#B4B1AD !important;"></span> Not Attempted</div>
                        <div class="d-flex align-items-center">
                             <span class="position-relative d-inline-block me-1">
                                <span class="d-inline-block bg-secondary rounded-circle" style="width:12px; height:12px; background:#B4B1AD !important;"></span>
                                <i class="ti-hand-open position-absolute" style="font-size: 8px; top: -4px; right: -4px; color: gold;"></i>
                             </span>
                             Mark for Review
                        </div>
                    </div>

                    <div class="terms-text mb-4" style="line-height: 1.8;">
                          <p class="m-0">0.25% marks will be deducted for each wrong answer</p>
                          <p class="m-0">2 marks will be provided for each correct answer.</p>
                          <p class="m-0">Total time will be allotted / count for whole test, time will not be calculated for each question</p>
                          <p class="m-0">Time for test is set to according to the server.</p>
                    </div>

                    <div class="form-check mb-2">
                         <input class="form-check-input" type="checkbox" id="check1" checked>
                         <label class="form-check-label ms-2" for="check1">I agree to all instructions and terms.</label>
                    </div>

                    <button class="btn btn-success mt-3" wire:click="startTest" style="background:#04ba65; border:none; padding:10px 40px; font-weight:bold; font-size:16px; border-radius:4px;">Start Test</button>
                </div>

                <div class="col-md-3">
                    <div class="p-3 border rounded text-center h-100" style="background: #daf1e4; border-radius:8px;">
                         <div class="bg-white p-4 rounded h-100 d-flex flex-column align-items-center justify-content-center" style="border-radius:8px;">
                              <img class="student_image rounded-circle border mb-3" src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" alt="" style="width:90px; height:90px;">
                              <h5 class="mb-1"><b>{{ auth()->user()->name }}</b></h5>
                              <p class="text-muted small m-0">City Competition Classes</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif ($currentView == 'testing')
        {{-- ============================ SCREENSHOT 2: CONDUCT TEST (CUSTOM CSS LAYOUT) ============================ --}}
        <div class="ot-header">
            <h3 class="ot-header-title">{{ $test->title }}</h3>
            <div class="ot-header-stats">
                <h5 class="ot-timer">Time Left : <span id="timer-display">00:00:00</span></h5>
                <h5 class="ot-questions-count">Qs: {{ $totalQuestions }}</h5>
            </div>
        </div>

        <section class="p-0">
            <div style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 15px;">
                <div class="ot-question-number">
                    @if ($currentQuestion) Question No {{ $currentQuestionIndex + 1 }} @endif
                </div>

                <div class="ot-subject-tabs">
                    @foreach ($sections as $i => $section)
                        <button class="ot-tab {{ $currentSectionIndex == $i ? 'active' : '' }}" wire:click="selectQuestion({{ $i }}, 0)">
                            {{ $section['section_subject']['name'] }}
                        </button>
                    @endforeach
                </div>

                <div class="ot-container">
                    <div class="ot-question-panel">
                        <div class="ot-question-box">
                            @if ($currentQuestion)
                                <div class="ot-question-text">{!! $currentQuestion->question !!}</div>

                                <ul class="ot-options-list">
                                    @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                        @php $optKey = 'ans_' . $k; @endphp
                                        <li wire:key.live="option-{{ $currentQuestion->id }}-{{ $optKey }}" class="ot-option-item">
                                            <label class="ot-option-label" wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')">
                                                <input id="answer_{{ $currentQuestion->id }}_{{ $k }}" wire:key="input-{{ $currentQuestion->id }}-{{ $k }}-{{ isset($answers[$currentQuestion->id]) ? 'filled' : 'empty' }}" class="ot-option-input" type="radio" name="question_{{ $currentQuestion->id }}" value="{{ $optKey }}" {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} />
                                                <span>{!! $currentQuestion->$optKey !!}</span>
                                            </label>
                                        </li>
                                    @endfor
                                </ul>

                                <div class="ot-action-bar">
                                    <button class="ot-btn ot-btn-success" wire:click="toggleMarkForReview({{ $currentQuestion->id }})">
                                        <i class="ti-star"></i> {{ in_array($currentQuestion->id, $markedQuestions) ? 'Unmark Review' : 'Mark for Review' }}
                                    </button>
                                    <button class="ot-btn ot-btn-clear" wire:click="clearResponse({{ $currentQuestion->id }})">
                                        <i class="ti-reload"></i> Clear Response
                                    </button>
                                    <button class="ot-btn ot-btn-next" wire:click="saveAndNext">
                                        Save & Next <i class="ti-angle-right"></i>
                                    </button>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <h5 style="color: #555;">Review Sections complete.</h5>
                                    <p class="text-muted">Click the button below to review your answers profile dashboard list before submit completed.</p>
                                    <button class="btn btn-danger btn-lg mt-3" wire:click="goToReview" style="background:#dc3545; font-weight:bold;">Review Choices</button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="ot-sidebar">
                        <div class="ot-profile">
                            <div class="ot-profile-img-wrap">
                                <img src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="ot-profile-img" />
                            </div>
                            <div class="ot-profile-info">
                                <div class="ot-profile-name">{{ auth()->user()->name }}</div>
                                <div class="ot-profile-subject">
                                     {{ $sections[$currentSectionIndex]['section_subject']['name'] ?? 'Exam' }}
                                </div>
                            </div>
                        </div>

                        <div class="ot-sidebar-content">
                            <div class="ot-grid">
                                @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                                    @php
                                        $hasAnswer = isset($answers[$qId]);
                                        $isMarked = in_array($qId, $markedQuestions);
                                        
                                        $colorClass = 'ot-node-unvisited'; 
                                        if ($hasAnswer) {
                                            $colorClass = 'ot-node-answered';
                                        }
                                    @endphp
                                    <span class="ot-node {{ $colorClass }} position-relative" wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})">
                                        @if ($isMarked)
                                            <span class="ot-star-badge">★</span>
                                        @endif
                                        {{ $qIndex + 1 }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="ot-sidebar-links">
                                <a href="#" class="ot-sidebar-link">Questions List</a>
                                <a href="#" class="ot-sidebar-link">Instructions</a>
                            </div>

                            <button class="ot-submit-btn" type="button" wire:click="goToReview">Review & Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @elseif ($currentView == 'review')
        {{-- ============================ SCREENSHOT 3: REVIEW BEFORE SUBMIT ============================ --}}
        <div class="ed_detail_head mb-3" style="padding: 10px; background: #fff; border-bottom: 2px solid #04ba65;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                         <h5 style="color: #333; margin:0; font-weight: bold;">Qs: {{ $totalQuestions }}</h5>
                    </div>
                    <div class="col-md-4 text-center">
                        <h3 style="color: #04ba65; font-weight: bold; margin:0;">{{ $test->title }}</h3>
                    </div>
                    <div class="col-md-4 text-end">
                        <h5 style="color: red; margin:0; font-weight: bold;">Time Left : <span id="timer-display-review">00:00:00</span></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="edu_wraper p-4 mb-3 border bg-white" style="border-radius:8px;">
                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="p-3 border rounded shadow-sm d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="d-inline-block bg-success rounded-circle me-2" style="width:18px; height:18px; background-color:#03b97c !important;"></span>
                                <span style="font-weight:bold;">Attempted Questions</span>
                            </div>
                            <h4 class="m-0" style="font-weight:bold; background: #e9ecef; padding: 4px 12px; border-radius: 4px; border:1px solid #ccc;">{{ $attemptedCount }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded shadow-sm d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="d-inline-block bg-secondary rounded-circle me-2" style="width:18px; height:18px; background-color:#B4B1AD !important;"></span>
                                <span style="font-weight:bold;">Not Attempted Questions</span>
                            </div>
                            <h4 class="m-0" style="font-weight:bold; background: #e9ecef; padding: 4px 12px; border-radius: 4px; border:1px solid #ccc;">{{ $notAttemptedCount }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded shadow-sm d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="d-inline-block bg-warning rounded-circle me-2" style="width:18px; height:18px; background-color:#e8741c !important;"></span>
                                <span style="font-weight:bold;">Questions for Review</span>
                            </div>
                            <h4 class="m-0" style="font-weight:bold; background: #e9ecef; padding: 4px 12px; border-radius: 4px; border:1px solid #ccc;">{{ $reviewCount }}</h4>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="question-grid mb-4">
                    @php $globalIndex = 1; @endphp
                    @foreach ($questionsList as $secIndex => $qIds)
                        @foreach($qIds as $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                
                                $colorClass = '';
                                if ($hasAnswer) {
                                    $colorClass = 'bg-answered';
                                }
                            @endphp
                            <span class="numberlist {{ $colorClass }} pointer position-relative d-flex align-items-center justify-content-center" 
                                  wire:click="selectQuestion({{ $secIndex }}, {{ $loop->index }}); @this.set('currentView', 'testing');"
                                  style="cursor: pointer; font-weight: bold; width: 35px; height: 35px; text-align: center;">
                                @if ($isMarked)
                                    <i class="ti-eye text-white position-absolute" style="font-size: 8px; top: -5px; right: -5px; background: #e8741c; border-radius: 50%; padding: 2px;"></i>
                                @endif
                                {{ $globalIndex++ }}
                            </span>
                        @endforeach
                    @endforeach
                </div>

                <button class="btn btn-success btn-lg w-100 mt-2" wire:click="submitTest" style="background:#04ba65; border:none; padding:14px; font-weight:bold; font-size:18px; border-radius:4px;">Final Submit</button>
            </div>
        </div>
    @endif

    {{-- 🔒 Anti-coop Offline Guard --}}
    <div wire:offline class="position-fixed top-0 start-0 w-100 p-3 text-center bg-danger text-white fs-5" style="z-index: 9999;">
        <i class="ti-alert"></i> Connection Intermittent. Please do not close this window, responses will sync when reconnected.
    </div>

    @section('js')
        <script>
            if (window.timerInterval) {
                clearInterval(window.timerInterval);
            }

            const bridge = document.getElementById('countdown-bridge');
            
            function syncWithBridge() {
                if (!bridge) return;
                let currentBridgeVal = parseInt(bridge.getAttribute('data-time-left')) || 0;
                let expectedEndTime = Date.now() + (currentBridgeVal * 1000);

                if (!window.testEndTime || Math.abs(window.testEndTime - expectedEndTime) > 3000) {
                    window.testEndTime = expectedEndTime;
                    window.lastSyncedBridgeVal = currentBridgeVal;
                }
            }

            syncWithBridge(); // Initial sync

            const timerDisplay = document.getElementById('timer-display');
            const timerDisplayReview = document.getElementById('timer-display-review');

            function updateTimer() {
                if (!bridge) return;
                
                // Peek if Livewire pushed a new value during 30s background poll triggers
                let currentBridgeVal = parseInt(bridge.getAttribute('data-time-left')) || 0;
                if (window.lastSyncedBridgeVal !== undefined && currentBridgeVal !== window.lastSyncedBridgeVal) {
                    syncWithBridge();
                }

                let now = Date.now();
                let diff = Math.max(0, Math.floor((window.testEndTime - now) / 1000));

                if (diff <= 0) {
                    clearInterval(window.timerInterval);
                    // 🛡️ Hybrid Safety: Double check absolute DB on local zero before submit triggers
                    @this.verifyTimerStatus().then(() => {
                         let finalBridgeVal = parseInt(bridge.getAttribute('data-time-left')) || 0;
                         if (finalBridgeVal <= 0) {
                              @this.submitTest();
                         } else {
                              // DB confirms time is still remaining, re-initialise local loop tick from pulled DB bridge value
                              syncWithBridge();
                              window.timerInterval = setInterval(updateTimer, 1000);
                         }
                    });
                    return;
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
            updateTimer(); // Direct trigger immediately on mount re-hydration!
            
            window.onbeforeunload = function() {
                return "Are you sure you want to leave the test? Your progress is saved, but time continues ticking!";
            };

            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            };
        </script>
    @endsection
</div>
