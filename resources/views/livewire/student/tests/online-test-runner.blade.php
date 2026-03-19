<div>
    @section('css')
        <style>
            .number-que-list { display: flex; flex-wrap: wrap; flex-direction: row; align-content: space-between; justify-content: space-around; }
            .numberlist { height: 25px; width: 25px; border: solid 1px grey; border-radius: 50%; display: block; text-align: center; }
            .numberlist:hover { background-color: #03b97c; color: #fff; }
            .question-grid { display: grid; grid-template-columns: repeat(5, 1fr); justify-items: center; gap: 8px; }
            
            /* Status Colors synced with wire state */
            .bg-answered { background-color: #03b97c !important; color: #fff !important; }
            .bg-marked { background-color: #e8741c !important; color: #fff !important; }
            .bg-visited { background-color: #700404 !important; color: #fff !important; }
            .bg-unvisited { background-color: #B4B1AD !important; color: #fff !important; }

            .counter { display: flex; color: #fff; }
            .ed_title { color: #03b97c; }
            .nav-link { padding: 4px 20px; font-size: 16px; color: #03b97c; cursor: pointer; }
            .nav-link.active { background: #03b97c; color: white; }
            .student_image { width: 80px; height: 80px; object-fit: cover; }
            .studen_name { margin: 0; background: #8fcea8; flex: 1; display: flex; justify-content: center; align-items: center; }
            .test_name { margin: 0; background: #04ba65; flex: 1; display: flex; justify-content: center; align-items: center; color: white; }
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
        {{-- ============================ SCREENSHOT 2: CONDUCT TEST ============================ --}}
        <div class="ed_detail_head" style="padding: 10px; background: #fff; border-bottom: 2px solid #04ba65;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h3 style="color: #04ba65; font-weight: bold; margin:0;">{{ $test->title }}</h3>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 style="color: red; font-weight: bold; margin:0;">
                             @if ($currentQuestion) Question No {{ $currentQuestionIndex + 1 }} @endif
                        </h4>
                    </div>
                    <div class="col-md-4 text-end d-flex align-items-center justify-content-end gap-3">
                        <h5 style="color: red; margin:0; font-weight: bold;">Time Left : <span id="timer-display">00:00:00</span></h5>
                        <h5 style="color: #333; margin:0; font-weight: bold;">Qs: {{ $totalQuestions }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <section class="pt-2">
            <div class="container">
                {{-- Section Subject Tabs --}}
                <div class="col-md-12 mb-3">
                    <ul class="nav nav-pills b-0 gap-2">
                        @foreach ($sections as $i => $section)
                            <li class="nav-item">
                                <a class="nav-link rounded {{ $currentSectionIndex == $i ? 'active' : '' }}" 
                                   wire:click="selectQuestion({{ $i }}, 0)"
                                   style="background: {{ $currentSectionIndex == $i ? '#04ba65' : '#e9ecef' }}; color: {{ $currentSectionIndex == $i ? '#fff' : '#495057' }}; font-weight:bold;">
                                   {{ $section['section_subject']['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="row">
                    {{-- Main Question Display Area --}}
                    <div class="col-lg-8 col-md-12">
                        <div class="edu_wraper p-4 mb-3 border bg-white" style="border-radius:8px;">
                            @if ($currentQuestion)
                                <div class="d-flex mb-3">
                                    <div class="fs-5" style="line-height: 1.6;">{!! $currentQuestion->question !!}</div>
                                </div>

                                <ul class="no-ul-list list-unstyled">
                                    @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                        @php $optKey = 'ans_' . $k; @endphp
                                        <li wire:key="option-{{ $currentQuestion->id }}-{{ $optKey }}" 
                                            wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                            class="mb-2 p-3 border rounded d-flex align-items-center" 
                                            style="background: {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? '#e6f4ea' : '#f8f9fa' }}; cursor:pointer;">
                                            
                                            <input class="form-check-input" 
                                                   id="answer_{{ $currentQuestion->id }}_{{ $k }}" 
                                                   type="radio" 
                                                   name="question_{{ $currentQuestion->id }}"
                                                   value="{{ $optKey }}"
                                                   {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }}
                                                   style="transform: scale(1.2); cursor:pointer;">
                                            <label class="form-check-label ms-3 mb-0 w-100" for="answer_{{ $currentQuestion->id }}_{{ $k }}" style="cursor:pointer;">
                                                {!! $currentQuestion->$optKey !!}
                                            </label>
                                        </li>
                                    @endfor
                                </ul>

                                <hr>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-warning text-white d-flex align-items-center gap-1" wire:click="toggleMarkForReview({{ $currentQuestion->id }})" style="background: #e8741c; border:none; padding:8px 16px;">
                                        <i class="ti-hand-open"></i> 
                                        {{ in_array($currentQuestion->id, $markedQuestions) ? 'Unmark Review' : 'Mark for Review' }}
                                    </button>
                                    <button class="btn btn-secondary d-flex align-items-center gap-1" wire:click="clearResponse({{ $currentQuestion->id }})" style="background:#555; padding:8px 16px;">
                                        <i class="ti-reload"></i> Clear Response
                                    </button>
                                    <button class="btn btn-success ms-auto d-flex align-items-center gap-1" wire:click="saveAndNext" style="background:#04ba65; padding:8px 20px; font-weight:bold;">
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

                    {{-- Sidebar Control Panel Card --}}
                    <div class="col-lg-4 col-md-12">
                        <div class="border bg-white p-0" style="border-radius:8px; overflow:hidden;">
                            <div class="row m-0 align-items-center" style="background: #e9ecef; padding: 12px;">
                                <div class="col-3 p-0">
                                    <img class="student_image rounded-circle border bg-white" src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" alt="" style="width:50px; height:50px; object-fit:cover;">
                                </div>
                                <div class="col-9">
                                    <h6 class="mb-0 font-weight-bold">{{ auth()->user()->name }}</h6>
                                    <small class="text-muted" style="background:#04ba65; color:#fff !important; padding:2px 6px; border-radius:4px; font-size:11px;">
                                         {{ $sections[$currentSectionIndex]['section_subject']['name'] ?? 'Exam' }}
                                    </small>
                                </div>
                            </div>

                            <div class="p-3">
                                <div class="question-grid mb-3">
                                    @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                                        @php
                                            $hasAnswer = isset($answers[$qId]);
                                            $isMarked = in_array($qId, $markedQuestions);
                                            $isVisited = in_array($qId, $visitedQuestions);
                                            
                                            $colorClass = 'bg-unvisited';
                                            if ($isMarked) $colorClass = 'bg-marked';
                                            elseif ($hasAnswer) $colorClass = 'bg-answered';
                                            elseif ($isVisited) $colorClass = 'bg-visited';
                                        @endphp
                                        <span class="numberlist {{ $colorClass }} pointer position-relative d-flex align-items-center justify-content-center" 
                                              wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                                              style="cursor: pointer; font-weight: bold; width: 32px; height: 32px; font-size:14px; text-align: center;">
                                            @if ($isMarked)
                                                <i class="ti-hand-open text-white position-absolute" style="font-size: 7px; top: -4px; right: -4px; background: #e8741c; border-radius: 50%; padding: 2px;"></i>
                                            @endif
                                            {{ $qIndex + 1 }}
                                        </span>
                                    @endforeach
                                </div>

                                <ul class="list-unstyled small mb-3" style="line-height: 1.6;">
                                    <li><span class="d-inline-block bg-answered rounded-circle me-1" style="width:10px; height:10px; background-color:#03b97c !important;"></span> Answered</li>
                                    <li><span class="d-inline-block bg-marked rounded-circle me-1" style="width:10px; height:10px; background-color:#e8741c !important;"></span> Marked for review</li>
                                    <li><span class="d-inline-block bg-visited rounded-circle me-1" style="width:10px; height:10px; background-color:#700404 !important;"></span> Visited (Not Answered)</li>
                                    <li><span class="d-inline-block bg-unvisited rounded-circle me-1" style="width:10px; height:10px; background-color:#B4B1AD !important;"></span> Not Visited</li>
                                </ul>

                                <hr>

                                <button class="btn btn-success w-100" type="button" wire:click="goToReview" style="background:#04ba65; border:none; padding:10px; font-weight:bold; font-size:16px;">
                                    Review & Submit
                                </button>
                            </div>
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
                                $isVisited = in_array($qId, $visitedQuestions);
                                
                                $colorClass = 'bg-unvisited';
                                if ($isMarked) $colorClass = 'bg-marked';
                                elseif ($hasAnswer) $colorClass = 'bg-answered';
                                elseif ($isVisited) $colorClass = 'bg-visited';
                            @endphp
                            <span class="numberlist {{ $colorClass }} pointer position-relative d-flex align-items-center justify-content-center" 
                                  wire:click="selectQuestion({{ $secIndex }}, {{ $loop->index }}); @this.set('currentView', 'testing');"
                                  style="cursor: pointer; font-weight: bold; width: 35px; height: 35px; text-align: center;">
                                @if ($isMarked)
                                    <i class="ti-hand-open text-white position-absolute" style="font-size: 8px; top: -5px; right: -5px; background: #e8741c; border-radius: 50%; padding: 2px;"></i>
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
