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

    {{-- Continuous polling trigger for countdown validations --}}
    <div wire:poll.10s="verifyTimerStatus"></div>

    <div class="ed_detail_head" style="padding: 10px; background: #f7f9fb;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7">
                    <h2 class="ed_title">{{ $test->title }}</h2>
                </div>
                <div class="col-lg-4 text-end">
                    <h3 style="color: red"><b>Time Left - <span id="timer-display">00:00:00</span></b></h3>
                </div>
            </div>
        </div>
    </div>

    <section class="pt-2">
        <div class="container">
            {{-- Section Headers --}}
            <div class="col-md-12 mb-3">
                <ul class="nav nav-tabs b-0" style="border-bottom: 1px solid #ddd;">
                    @foreach ($sections as $i => $section)
                        <li class="nav-item">
                            <a class="nav-link {{ $currentSectionIndex == $i ? 'active' : '' }}" 
                               wire:click="selectQuestion({{ $i }}, 0)">
                               {{ $section['section_subject']['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="row">
                {{-- Main Question Display --}}
                <div class="col-lg-8 col-md-12">
                    <div class="edu_wraper p-4 mb-3 border bg-white" style="border-radius:8px;">
                        @if ($currentQuestion)
                            <h4 class="edu_title" style="color: red;">
                                Question {{ $currentQuestionIndex + 1 }} of {{ count($questionsList[$currentSectionIndex] ?? []) }}
                            </h4>
                            <div class="d-flex mb-3">
                                <div class="fs-5">{!! $currentQuestion->question !!}</div>
                            </div>

                            <ul class="no-ul-list">
                                @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                    @php $optKey = 'ans_' . $k; @endphp
                                    <li wire:key="option-{{ $currentQuestion->id }}-{{ $optKey }}" class="mb-2 p-2 border rounded" style="background: {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? '#e6f4ea' : 'transparent' }}">
                                        <input class="checkbox-custom" 
                                               id="answer_{{ $currentQuestion->id }}_{{ $k }}" 
                                               type="radio" 
                                               name="question_{{ $currentQuestion->id }}"
                                               value="{{ $optKey }}"
                                               wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                               {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }}>
                                        <label class="checkbox-custom-label ms-2" for="answer_{{ $currentQuestion->id }}_{{ $k }}">
                                            {!! $currentQuestion->$optKey !!}
                                        </label>
                                    </li>
                                @endfor
                            </ul>

                            <hr>

                            <div class="d-flex gap-2">
                                <button class="btn btn-warning text-white" wire:click="toggleMarkForReview({{ $currentQuestion->id }})">
                                    <i class="ti-hand-open"></i> 
                                    {{ in_array($currentQuestion->id, $markedQuestions) ? 'Unmark Review' : 'Mark for Review' }}
                                </button>
                                <button class="btn btn-secondary" wire:click="clearResponse({{ $currentQuestion->id }})">
                                    Clear Response
                                </button>
                                <button class="btn btn-success ms-auto" wire:click="saveAndNext">
                                    Save & Next <i class="ti-angle-right"></i>
                                </button>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <h5>You have answered all questions.</h5>
                                <p class="text-muted">Click the button below to submit and finish your test.</p>
                                <button class="btn btn-danger mt-3" wire:click="submitTest">Submit Test</button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Sidebar Control Panel --}}
                <div class="col-lg-4 col-md-12">
                    <div class="border bg-white p-3" style="border-radius:8px;">
                        <div class="row mb-3 align-items-center">
                            <div class="col-3">
                                <img class="student_image rounded-circle border" src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" alt="">
                            </div>
                            <div class="col-9">
                                <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                                <small class="text-muted">{{ $sections[$currentSectionIndex]['section_subject']['name'] ?? 'Exam' }}</small>
                            </div>
                        </div>

                        <hr>

                        <div class="question-grid mb-3">
                            @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                                @php
                                    $hasAnswer = isset($answers[$qId]);
                                    $isMarked = in_array($qId, $markedQuestions);
                                    $isVisited = in_array($qId, $visitedQuestions);
                                    
                                    $colorClass = 'bg-unvisited';
                                    // Mark for Review takes highest priority
                                    if ($isMarked) $colorClass = 'bg-marked';
                                    elseif ($hasAnswer) $colorClass = 'bg-answered';
                                    elseif ($isVisited) $colorClass = 'bg-visited';
                                @endphp
                                <span class="numberlist {{ $colorClass }} pointer position-relative d-flex align-items-center justify-content-center" 
                                      wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                                      style="cursor: pointer; font-weight: bold; width: 30px; height: 30px; text-align: center;">
                                    @if ($isMarked)
                                        <i class="ti-eye text-white position-absolute" style="font-size: 8px; top: -5px; right: -5px; background: red; border-radius: 50%; padding: 2px;"></i>
                                    @endif
                                    {{ $qIndex + 1 }}
                                </span>
                            @endforeach
                        </div>

                        <ul class="list-unstyled small">
                            <li><span class="d-inline-block p-1 bg-answered rounded-circle me-1" style="width:12px; height:12px;"></span> Answered</li>
                            <li><span class="d-inline-block p-1 bg-marked rounded-circle me-1" style="width:12px; height:12px;"></span> Marked for review</li>
                            <li><span class="d-inline-block p-1 bg-visited rounded-circle me-1" style="width:12px; height:12px;"></span> Not Answered (Visited)</li>
                            <li><span class="d-inline-block p-1 bg-unvisited rounded-circle me-1" style="width:12px; height:12px;"></span> Not Visited</li>
                        </ul>

                        <hr>

                        <button class="btn btn-danger w-100" type="button" 
                                onclick="if(confirm('Are you sure you want to Submit your test?')) { @this.submitTest() }">
                            Review & Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 🔒 Anti-coop Offline Guard --}}
    <div wire:offline class="position-fixed top-0 start-0 w-100 p-3 text-center bg-danger text-white fs-5" style="z-index: 9999;">
        <i class="ti-alert"></i> Connection Intermittent. Please do not close this window, responses will sync when reconnected.
    </div>

    @section('js')
        <script>
            // absolute timestamp end Calculation to prevent tab-sleep lags
            let endTime = Date.now() + ({{ $timeLeft }} * 1000);
            const timerDisplay = document.getElementById('timer-display');

            function updateTimer() {
                let now = Date.now();
                let diff = Math.max(0, Math.floor((endTime - now) / 1000));

                if (diff <= 0) {
                    clearInterval(timerInterval);
                    @this.submitTest();
                    return;
                }

                const hours = Math.floor(diff / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = Math.floor(diff % 60);

                timerDisplay.innerHTML = 
                    (hours < 10 ? '0' + hours : hours) + ":" +
                    (minutes < 10 ? '0' + minutes : minutes) + ":" +
                    (seconds < 10 ? '0' + seconds : seconds);
            }

            const timerInterval = setInterval(updateTimer, 1000);

            // 🔒 Guard rails against tab crashes or reloads
            window.onbeforeunload = function() {
                return "Are you sure you want to leave the test? Your progress is saved, but time continues ticking!";
            };

            // 🔒 Disable Browser Back Button Lock override
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            };
        </script>
    @endsection
</div>
