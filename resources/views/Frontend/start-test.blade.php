@extends('Layouts.frontend')

@section('css')
    <style>
        .number-que-list {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            align-content: space-between;
            justify-content: space-around;
        }

        .numberlist {
            height: 25px;
            width: 25px;
            border: solid 1px grey;
            border-radius: 50%;
            display: block;
            text-align: center;
        }

        .numberlist:hover {
            background-color: #03b97c;
            color: #fff;
        }

        .number-que-list>.active1>span {
            background-color: #03b97c;
            color: #fff;
        }

        .number-que-list>.inactive>span {
            background-color: #700404;
            color: #fff;
        }

        .number-que-list>.incomplete>span {
            background-color: #B4B1AD;
            color: #fff;
        }

        .number-que-list>.mark-review>span {
            background-color: #e8741c;
            color: #fff;
        }

        .counter {
            display: flex;
            color: #fff;
        }

        .counter>div {
            padding: 10px;
            border-radius: 3px;
            display: inline-block;
        }

        .counter>div>span {
            padding: 9px;
            font-size: 20px;
            width: 45px;
            border-radius: 3px;
            background: #03b97c;
            display: inline-block;
        }

        .fa-star {
            position: absolute;
            visibility: hidden;
            left: 7px;
            top: -4px;
            color: orange;
        }

        /* The Modal (background) */
        .modal-loc {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modalloc-content {
            background-color: #fefefe;
            margin: auto;
            padding: 30px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
            flex-direction: row;
            align-content: stretch;

        }

        /* The Close Button */
        .close-modal {
            color: #aaaaaa;
            display: table-row;
            font-size: 28px;
            font-weight: bold;
        }

        .close-modal:hover,
        .close-modal:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .img {
            width: 40%;
            height: 40%;
            max-width: 300px;
            cursor: pointer;
        }

        /* .modal-container>p{
                            text-align:center;
                        }
                        .modal-container>img{
                        align-content:center;
                        } */
        .modal-container {
            float: none;
            width: 30%;
            display: block;
            align-content: center;
            text-align: center;
        }

        .ed_title {
            color: #03b97c;
        }

        .nav-link {
            padding: 2px 30px 4px 30px;
            border-radius: 0px;
            font-size: 20px;
            color: #03b97c;
        }

        .student_image {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .studen_name {
            margin: 0;
            background: #8fcea8;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .test_name {
            margin: 0;
            background: #04ba65;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .question-grid {
            display: grid;
            grid-template-columns: repeat(5, 2fr 2fr);
            justify-items: center;
        }
    </style>
@endsection
@section('main')
    <!-- ============================ Page Title Start================================== -->
    <div class="ed_detail_head" style="padding: 10px;">
        <div class="container">
            <div class="row align-items-center" style="flex-wrap: nowrap;display: flex;flex-direction: row;">
                <div class="col-lg-8 col-md-7">
                    <div class="ed_detail_wrap">
                        <!-- <div class="crs_cates cl_1"><span>Design</span></div><div class="crs_cates cl_3"><span>Design</span></div> -->
                        <div class="ed_header_caption">
                            <h2 class="ed_title">{{ $data['test_start']->title }}</h2>
                            <!-- <ul>
                                                <li><i class="ti-calendar"></i>10 - 20 weeks</li>
                                                <li><i class="ti-control-forward"></i>102 Lectures</li>
                                                <li><i class="ti-user"></i>502 Student Enrolled</li>
                                            </ul> -->
                        </div>
                        <!-- <div class="ed_header_short">
                                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore. veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                        </div> -->

                        <!-- <div class="ed_rate_info">
                                                <div class="star_info">
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <div class="review_counter">
                                                    <strong class="high">4.7</strong> 3572 Reviews
                                                </div>
                                            </div> -->

                    </div>
                </div>
                <div class="counter col-lg-4 position-relative">
                    <div class="d-flex justify-content-between">
                    <h3 style="color: red"><b>Time Left - <span id="timer">00:00:00</span></b></h3>
                    <h3 clas="" style="position: absolute; right: 0">Total Qs - {{$data['test_start']['total_questions']}}</h3>
                </div>
                </div>
                <!-- <div class="counter">
                                    <h2><b>Time Left - <span id="timer" style="color: red">00:00:00</span></b></h2><br>
                                    <p id="demo"></p>
                                </div> -->
                <!-- <div class="counter" id="clockdiv">
                                    <div>
                                        <span class="days"></span>
                                    </div>
                                    <div>
                                        <span class="hours"></span>
                                    </div>
                                    <div>
                                        <span class="minutes"></span>
                                    </div>
                                    <div>
                                        <span class="seconds"></span>
                                    </div>
                                </div> -->
            </div>
        </div>
    </div>
    <!-- ============================ Page Title End ================================== -->
    <!-- ============================ Course Detail ================================== -->

    <section class="pt-0">
        <div class="container">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="custom-tab customize-tab tabs_creative">
                    <ul class="nav nav-tabs pb-2 b-0" id="myTab" role="tablist">
                        @foreach ($data['test_start']->getSection as $i => $section)
                            @if ($i == 0)
                                <li class="nav-item">
                                    <a class="nav-link active test-tab-{{ $i }}" data-id="{{ $i }}"
                                        id="{{ $section->sectionSubject->name }}_{{ $i }}-tab" data-toggle="tab"
                                        href="#{{ $section->sectionSubject->name }}_{{ $i }}" role="tab"
                                        aria-controls="{{ $section->sectionSubject->name }}_{{ $i }}"
                                        aria-selected="true">{{ $section->sectionSubject->name }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link test-tab-{{ $i }}" data-id="{{ $i }}"
                                        id="{{ $section->sectionSubject->name }}_{{ $i }}-tab"
                                        data-toggle="tab" href="#{{ $section->sectionSubject->name }}_{{ $i }}"
                                        role="tab"
                                        aria-controls="{{ $section->sectionSubject->name }}_{{ $i }}"
                                        aria-selected="false">{{ $section->sectionSubject->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <form action="{{ url('end-test/' . $data['test_start']->id) }}" method="post" id="test_submit_form">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-12 order-lg-first">
                        <!-- Overview -->
                        <input type="hidden" name="show_result" value="0" id="show_result">
                        <?php $questions_count = 0; ?>
                        @foreach ($data['test_start']->getSection as $i => $section)
                            @foreach ($section->getQuestions()->wherePivot('deleted_at', '=', null)->get() as $j => $questions)
                                <div class="px-1 py-0 edu_wraper test-questions test-questions_{{ $j += 1 }}"
                                    key="{{ $questions->id }}" data-id="{{ $i }}"
                                    id="question_{{ $questions->id }}">
                                    <h3 class="edu_title" style="color: red;">Question Number {{ $questions_count += 1 }}
                                    </h3>
                                    <div class="d-flex">
                                        <p style="flex:none;"> Qs {{ $questions_count }} - &nbsp;</p>
                                        {!! $questions->question !!}
                                    </div>
                                    {{-- <hr>
                                    <h3 class="edu_title">Options</h3> --}}
                                    <ul class="no-ul-list img-ls-src">
                                        @for ($k = 1; $k <= $questions->mcq_options; $k++)
                                            <li>
                                                <input
                                                    id="answer_{{ $i }}_{{ $j }}_{{ $k }}"
                                                    class="checkbox-custom" name="question[{{ $questions->id }}]"
                                                    value="ans_{{ $k }}" type="radio">
                                                <label
                                                    for="answer_{{ $i }}_{{ $j }}_{{ $k }}"
                                                    class="checkbox-custom-label">{!! $questions['ans_' . $k] !!}</label>
                                            </li>
                                        @endfor
                                    </ul>
                                    <input type="hidden" name="clear_questions[{{ $questions->id }}]" value="0">
                                    <input type="hidden" key="{{ $questions->id }}"
                                        name="mark_for_review_questions[{{ $questions->id }}]" value="0">
                                    <input type="hidden" key="{{ $questions->id }}"
                                        name="attemted_questions[{{ $questions->id }}]" value="0">
                                </div>
                            @endforeach
                        @endforeach

                        <!-- <div class="edu_wraper">
                                            <h3 class="edu_title">Question Number</h3>
                                            <p>Question</p>
                                            <h6>Requirements</h6>
                                            <ul class="no-ul-list">
                                                <li>
                                                    <input id="a-p1" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p1" class="checkbox-custom-label">Option 1</label>
                                                </li>

                                                <li>
                                                    <input id="a-p2" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p2" class="checkbox-custom-label">Option 2</label>
                                                </li>
                                                <li>
                                                    <input id="a-p3" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p3" class="checkbox-custom-label">Option 3</label>
                                                </li>
                                                <li>
                                                    <input id="a-p4" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p4" class="checkbox-custom-label">Option 4</label>
                                                </li>
                                            </ul>
                                        </div> -->
                        <button type="button" class="btn btn-outline-theme" id="mark-for-review"
                            onclick="starShow(0)">Mark for Review <i class="ti-hand-open"></i></button>
                        <button type="button" class="btn btn-outline-theme" id="clear-response">Clear Response <i
                                class="ti-brush-alt"></i></button>
                        <button type="button" class="btn btn-outline-theme" id="submit-answer">Save & Next<i
                                class="ti-angle-right"></i></button>


                        <!-- <div class="edu_wraper">
                                            <h3 class="edu_title">Question Number 1</h3>
                                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>		 -->
                        <!-- <h6>Requirements</h6> -->
                        <!-- <ul class="no-ul-list">
                                                <li>
                                                    <input id="a-p" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p" class="checkbox-custom-label">Option 1</label>
                                                </li>
                                                <li>
                                                    <input id="a-p" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p" class="checkbox-custom-label">Option 2</label>
                                                </li>
                                                <li>
                                                    <input id="a-p" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p" class="checkbox-custom-label">Option 3</label>
                                                </li>
                                                <li>
                                                    <input id="a-p" class="checkbox-custom" name="a-p" type="radio">
                                                    <label for="a-p" class="checkbox-custom-label">Option 4</label>
                                                </li>
                                            </ul>
                                        </div> -->
                        <!-- <button type="submit" class="btn btn-outline-theme">Clear Response</button>
                                        <button type="submit" class="btn btn-outline-theme">Save & Next</button>
                                        <button type="submit" class="btn btn-outline-theme"  onclick="starShow(0)">Mark for Review</button> -->

                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 col-md-12 order-lg-last p-0">
                        <div class="ed_view_box style_2  border border-2 border-success rounded-0">
                            <?php $questions_count = 0; ?>
                            <div class="tab-content" id="myTabContent">
                                @foreach ($data['test_start']->getSection as $i => $section)
                                    @if ($i == 0)
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{ '/storage/app/' . auth()->user()->user_details->photo_url }}"
                                                    class="student_image" alt="">
                                            </div>
                                            <div class="col-9 text-center d-flex flex-column justify-content-center"
                                                style="padding-left: 0;">
                                                <h3
                                                    class="studen_name border border-top-0 border-end-0 border-start-0 border-light border-2">
                                                    {{ auth()->user()->name }}</h3>
                                                <h3 class="test_name" id="test_name">{{ $section->sectionSubject->name }}
                                                </h3>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="tab-pane pb-3 gray fade {{ $i == 0 ? 'show active ' : '' }} test-tab-content-{{ $i }}"
                                        data-id="{{ $i }}"
                                        id="{{ $section->sectionSubject->name }}_{{ $i }}" role="tabpanel"
                                        aria-labelledby="{{ $section->sectionSubject->name }}_{{ $i }}-tab">
                                        <div class="eld mb-3">
                                            {{-- <h5 class="font-medium">{{ $section->sectionSubject->name }}</h5> --}}
                                            <ul class="question-grid">
                                                @foreach ($section->getQuestions()->wherePivot('deleted_at', '=', null)->get() as $key => $questions)
                                                    <li class="col" id="question_li_{{ $questions->id }}"
                                                        data-id="{{ $i }}" key="{{ $questions->id }}"><i
                                                            class="fa fa-eye" id="question_i_{{ $questions->id }}"
                                                            style="visibility:hidden"></i><span class="numberlist"
                                                            style="cursor: pointer">{{ $questions_count += 1 }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="ed_view_features px-2">
                                <!-- @foreach ($data['test_start']->getSection as $key => $section)
    <div class="eld mb-3">
                                                        <h5 class="font-medium">{{ $section->sectionSubject->name }}</h5>
                                                        <ul class="number-que-list">
                                                            @foreach ($section->getQuestions()->wherePivot('deleted_at', '=', null)->get() as $key => $questions)
    <li class="question-list" id="question_li_{{ $questions->id }}" key="{{ $questions->id }}"><span class="numberlist">{{ $key += 1 }}</span></li>
    @endforeach
                                                        </ul>
                                                    </div>
    @endforeach -->

                                <!-- <div class="eld mb-3">
                                                    <h5 class="font-medium">Section: Domain</h5>
                                                </div>
                                                <div class="eld mb-3">
                                                    <h5 class="font-medium">Section: Domain</h5>
                                                </div> -->

                                <!-- <ul class="number-que-list">
                                                <li class="active"><span class="numberlist">1</span></li>
                                                <li><span class="numberlist">2</span></li>
                                                <li><span class="numberlist">3</span></li>
                                                <li><span class="numberlist">4</span></li>
                                                <li><span class="numberlist">5</span></li>
                                                <li><span class="numberlist">6</span></li>
                                                <li><span class="numberlist">7</span></li>
                                                <li><span class="numberlist">8</span></li>
                                                <li><span class="numberlist">9</span></li>
                                                <li><span class="numberlist">10</span></li>
                                            </ul>
                                            <ul class="number-que-list">
                                                <li><span class="numberlist">11</span></li>
                                                <li><span class="numberlist">12</span></li>
                                                <li><span class="numberlist">13</span></li>
                                                <li><span class="numberlist">14</span></li>
                                                <li><span class="numberlist">15</span></li>
                                                <li><span class="numberlist">16</span></li>
                                                <li><span class="numberlist">17</span></li>
                                                <li><span class="numberlist">18</span></li>
                                                <li><span class="numberlist">19</span></li>
                                                <li><span class="numberlist">20</span></li>
                                            </ul>
                                            <ul class="number-que-list">
                                                <li><span class="numberlist">21</span></li>
                                                <li><span class="numberlist">22</span></li>
                                                <li><span class="numberlist">23</span></li>
                                                <li><span class="numberlist">24</span></li>
                                                <li><span class="numberlist">25</span></li>
                                                <li><span class="numberlist">26</span></li>
                                                <li><span class="numberlist">27</span></li>
                                                <li><span class="numberlist">28</span></li>
                                                <li><span class="numberlist">29</span></li>
                                                <li><span class="numberlist">30</span></li>
                                            </ul> -->
                                <div class="d-flex justify-content-between pt-3">
                                    <div><a href="{{ route('question_paper', [$data['test_start']->id]) }}"
                                            class="underline d-flex align-items-center">Question Paper<i
                                                class="ti-angle-right"></i></a></div>
                                    <div></div>
                                </div>
                                <div class="ed_view_link">
                                    <button type="button" id="myBtnl" class="btn theme-bg enroll-btn"
                                        onclick="alert('Test submitted succesfully....')">Review & Submit<i
                                            class="ti-angle-right"></i></button>
                                    <!-- <a href="#" class="btn theme-bg enroll-btn">Submit Test<i class="ti-angle-right"></i></a> -->
                                </div>

                                <!-- <button type="button" class="btn btn-outline-theme" >Save & Next</button> -->

                            </div>

                            <div id="loc-Modal" class="modal-loc">
                                <div class="modalloc-content">
                                    <span class="close-modal">&times</span>

                                    <div class="col-md-12">
                                        <div class="ed_view_box style_2">
                                            <div class="">
                                                <h2>Time Left - <span id="timer1" style="color: red">00:00:00</span>
                                                </h2><br>
                                            </div>
                                            <div class="ed_author" style="">
                                                <div>
                                                    <h4 class="">Attempted Question: </h4><b><span
                                                            id="attempt_count">0</span></b>
                                                </div>
                                                <div>
                                                    <h4 class="">Not-Attempted Question: </h4><b><span
                                                            id="not_attempt">0</span></b>
                                                </div>
                                                <div>
                                                    <h4 class="">Marked for Review: </h4><b><span
                                                            id="marked_review">0</span></b>
                                                </div>
                                            </div>

                                            <div class="">
                                                <?php $questions_count = 0; ?>
                                                @foreach ($data['test_start']->getSection as $i => $section)
                                                    <!-- <div class="tab-pane fade" id="{{ $section->sectionSubject->name }}_{{ $section->id }}" role="tabpanel" aria-labelledby="home-tab"> -->
                                                    <div class="eld mb-3">
                                                        <h5 class="font-medium">{{ $section->sectionSubject->name }}</h5>
                                                        <ul class="number-que-list">
                                                            @foreach ($section->getQuestions()->wherePivot('deleted_at', '=', null)->get() as $key => $questions)
                                                                <li class="question-list"
                                                                    id="modal_question_li_{{ $questions->id }}"
                                                                    data-id="{{ $i }}"
                                                                    key="{{ $questions->id }}"><i class="fa fa-eye"
                                                                        id="modal_question_span_{{ $questions->id }}"
                                                                        style="visibility:hidden"></i><span
                                                                        class="numberlist">{{ $questions_count += 1 }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <!-- </div> -->
                                                @endforeach
                                            </div>
                                            <div class="ed_view_features">
                                                <div class="ed_view_link">
                                                    <!-- <a href="{{ route('question_paper', [$data['test_start']->id]) }}" class="btn theme-light enroll-btn">Question Paper<i class="ti-angle-right"></i></a> -->
                                                    <button type="button" class="btn theme-bg enroll-btn"
                                                        id="submit_test">Submit Test<i
                                                            class="ti-angle-right"></i></button>
                                                    <!-- <a href="#" class="btn theme-bg enroll-btn">Submit Test<i class="ti-angle-right"></i></a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </section>
    <!-- ============================ Course Detail ================================== -->
@endsection

@section('js')
    <script src="{{ asset('/skillup/js/popper.min.js') }}"></script>
    <script src="{{ asset('/skillup/js/bootstrap.min.js') }}"></script>

    <script>
        // Set the date we're counting down to
        var test_time = {{ $data['test_duration'] }};

        countdownTimeStart(test_time);

        function countdownTimeStart(distance_minutes) {
            // var countDownDate = new Date("Sep 25, 2025 15:00:00").getTime();
            var count_time = distance_minutes * 1000 * 60;
            var now = 0000;
            // Update the count down every 1 second
            var x = setInterval(function() {
                now += 1000;
                var distance = count_time - now;
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                minutes = minutes < 10 ? ('0' + minutes) : minutes
                seconds = seconds < 10 ? ('0' + seconds) : seconds
                document.getElementById("timer").innerHTML = hours + ":" + minutes + ":" + seconds;
                document.getElementById("timer1").innerHTML = hours + ":" + minutes + ":" + seconds;
                // "00" + ":" + current_minutes.toString() + ":" + (seconds < 10 ? "00" : "") + String(seconds);
                // document.getElementById("demo").innerHTML = hours + "h "
                // + minutes + "m " + seconds + "s ";

                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "EXPIRED";
                    document.getElementById("timer1").innerHTML = "EXPIRED";
                }
            }, 1000);
        }
    </script>

    <script>
        function getTimeRemaining(endtime) {
            const total = Date.parse(endtime) - Date.parse(new Date());
            const seconds = Math.floor((total / 1000) % 60);
            const minutes = Math.floor((total / 1000 / 60) % 60);
            const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
            const days = Math.floor(total / (1000 * 60 * 60 * 24));

            return {
                total,
                days,
                hours,
                minutes,
                seconds
            };
        }

        function initializeClock(id, endtime) {
            const clock = document.getElementById(id);
            const daysSpan = clock.querySelector(".days");
            const hoursSpan = clock.querySelector(".hours");
            const minutesSpan = clock.querySelector(".minutes");
            const secondsSpan = clock.querySelector(".seconds");

            function updateClock() {
                const t = getTimeRemaining(endtime);

                daysSpan.innerHTML = t.days;
                hoursSpan.innerHTML = ("0" + t.hours).slice(-2);
                minutesSpan.innerHTML = ("0" + t.minutes).slice(-2);
                secondsSpan.innerHTML = ("0" + t.seconds).slice(-2);

                if (t.total <= 0) {
                    clearInterval(timeinterval);
                }
            }

            updateClock();
            const timeinterval = setInterval(updateClock, 1000);
        }

        const deadline = new Date(Date.parse(new Date()) + 1 * 24 * 60 * 60 * 1000);
        console.log(deadline);
        initializeClock("clockdiv", deadline);
    </script>

    <script type="text/javascript">
        var time = '<?php echo $data['test_duration']; ?>';
        var realtime = time * 60000;
        setTimeout(function() {
                alert('Time Out');
                document.getElementById("test_submit_form").submit();
            },
            realtime);
    </script>

    <script type="text/javascript">
        //     var timeoutHandle;
        //     function countdown(minutes) {
        //     var seconds = 60;

        //     var num = minutes;
        //     var hours = (num / 60);
        //     var rhours = Math.floor(hours);
        //     var minutes1 = (hours - rhours) * 60;
        //     var mins = Math.round(minutes1);
        //     var current_hour    = rhours-1;

        //     function tick() {
        //         var counter = document.getElementById("timer");
        //         if (current_hour > 0) {
        //             var current_minutes = mins-1;
        //         }
        //         else{
        //             var current_minutes = 60-1;
        //             current_hour = 0;
        //         }
        //         seconds--;
        //         counter.innerHTML =
        //         current_hour.toString() + ":" + current_minutes.toString() + ":" + (seconds < 10 ? "00" : "") + String(seconds);
        //         if( seconds > 0 ) {
        //             timeoutHandle=setTimeout(tick, 1000);
        //         } else {
        //             if(mins > 1){
        //                // countdown(mins-1);   never reach “00″ issue solved:Contributed by Victor Streithorst
        //                setTimeout(function () { countdown(mins - 1); }, 1000);
        //             }else{
        //                 if (current_hour > 0) {
        //                     setTimeout(function () { countdown(rhours * 60); }, 1000);
        //                 }
        //             }
        //         }
        //     }
        //         tick();
        //     }
        //     countdown('<?php echo $data['test_start']->time_to_complete; ?>');
    </script>

    <script type="text/javascript">
        //     var timeoutHandle;
        //     function countdown(minutes) {
        //     var seconds = 60;
        //     var mins = minutes
        //     function tick() {
        //         var counter = document.getElementById("timer");
        //         var current_minutes = mins-1
        //         seconds--;
        //         counter.innerHTML =
        //         "00" + ":" + current_minutes.toString() + ":" + (seconds < 10 ? "00" : "") + String(seconds);
        //         if( seconds > 0 ) {
        //             timeoutHandle=setTimeout(tick, 1000);
        //         } else {
        //             if(mins > 1){
        //                // countdown(mins-1);   never reach “00″ issue solved:Contributed by Victor Streithorst
        //                setTimeout(function () { countdown(mins - 1); }, 1000);
        //             }
        //         }
        //     }
        //         tick();
        //     }
        //     countdown('<?php echo $data['test_start']->time_to_complete; ?>');
    </script>

    <script>
        function starShow(i) {
            var star = document.querySelectorAll(".number-que-list li span")[i];
            star.style.visibility = "visible";
        }
    </script>

    <script>
        var q_id = 0;
        var old_id = 0;
        const questions_key = [];
        var section_id = 0;

        $(document).ready(function() {
            $(".test-questions").hide();

            $('.test-questions').each(function() {
                questions_key.push($(this).attr('key'));
            });

            $("#question_" + questions_key[q_id]).show();
            // $("#question_li_"+questions_key[q_id]).addClass('active1');

            $("#submit-answer").click(function() {
                old_id = q_id;
                $("#question_" + questions_key[old_id]).hide();
                $("#question_li_" + questions_key[old_id]).removeClass("active1");
                $("#question_li_" + questions_key[old_id]).addClass('incomplete');

                q_id += 1;

                $("#question_" + questions_key[q_id]).show();
                // $("#question_li_"+questions_key[q_id]).removeClass('incomplete');
                // $("#question_li_"+questions_key[q_id]).addClass('active1');

                var checkval = $("input[name='question[" + questions_key[old_id] + "]']:checked").val();
                if (checkval != null) {
                    $("input:hidden[name='attemted_questions[" + questions_key[old_id] + "]']").val(1);
                    $("#question_li_" + questions_key[old_id]).removeClass('incomplete');
                    $("#question_li_" + questions_key[old_id]).addClass('active1');
                }

                if (q_id == questions_key.length) {
                    $("#myBtnl").trigger('click');
                    q_id = 0;
                    old_id = 0;
                    $("#question_" + questions_key[q_id]).show();
                }

                if ($("#question_" + questions_key[q_id]).attr('data-id') != section_id) {
                    $(".test-tab-" + section_id).removeClass('active');
                    $(".test-tab-content-" + section_id).removeClass('show');
                    $(".test-tab-content-" + section_id).removeClass('active');

                    section_id = $("#question_" + questions_key[q_id]).attr('data-id')

                    $(".test-tab-" + section_id).addClass('active');
                    $(".test-tab-content-" + section_id).addClass('show');
                    $(".test-tab-content-" + section_id).addClass('active');

                };
                $("#question_number_header").empty();
                $("#question_number_header").html("Question Number " + (q_id + 1));

            });

            $(".nav-link").click(function() {
                // $(".test-tab-"+section_id).removeClass('active');
                // $(".test-tab-content-"+section_id).removeClass('show');
                // $(".test-tab-content-"+section_id).removeClass('active');
                $(".test-questions").hide();
                var section_id = $(this).attr('data-id');
                $('.test-questions[data-id=' + section_id + ']')[0].style.display = 'block';
                console.log(this.innerHTML);
                $("#test_name").html(this.innerHTML);
                // $('.test-questions').attr('data-id',section_id).show();

                // $(".test-tab-"+section_id).addClass('active');
                // $(".test-tab-content-"+section_id).addClass('show');
                // $(".test-tab-content-"+section_id).addClass('active');

            });

            $(".question-list").click(function() {
                var key = $(this).attr('key');
                old_id = q_id;

                $("#question_" + questions_key[old_id]).hide();

                var checkval = $("input[name='question[" + questions_key[old_id] + "]']:checked").val();
                if (checkval == null) {
                    $("#question_li_" + questions_key[old_id]).removeClass("active1");
                    $("#question_li_" + questions_key[old_id]).addClass('incomplete');
                }

                q_id = questions_key.indexOf(key);
                $("#question_" + questions_key[q_id]).show();
                $("#question_li_" + questions_key[q_id]).removeClass('incomplete');
                $("#question_li_" + questions_key[q_id]).addClass('active1');

                $(".test-tab-" + section_id).removeClass('active');
                $(".test-tab-content-" + section_id).removeClass('show');
                $(".test-tab-content-" + section_id).removeClass('active');

                section_id = $(this).attr('data-id');
                console.log(section_id);
                $(".test-tab-" + section_id).addClass('active');
                $(".test-tab-content-" + section_id).addClass('show');
                $(".test-tab-content-" + section_id).addClass('active');

                $("#question_number_header").empty();
                $("#question_number_header").html("Question Number " + (q_id + 1));
            })

            $("#clear-response").click(function() {
                $("input:radio[name='question[" + questions_key[q_id] + "]']").each(function() {
                    $(this).prop("checked", false);
                });
                $("input:hidden[name='attemted_questions[" + questions_key[q_id] + "]']").val(0);
            });

            $("#mark-for-review").click(function() {
                if ($("input:hidden[name='mark_for_review_questions[" + questions_key[q_id] + "]']")
                    .val() == 1) {
                    $("#question_i_" + questions_key[q_id]).removeAttr('style', 'visibility:visible');
                    $("#question_i_" + questions_key[q_id]).attr('style', 'visibility:hidden');
                    $("input:hidden[name='mark_for_review_questions[" + questions_key[q_id] + "]']").val(0);
                } else {
                    $("#question_i_" + questions_key[q_id]).removeAttr('style', 'visibility:hidden');
                    $("#question_i_" + questions_key[q_id]).attr('style', 'visibility:visible');
                    $("input:hidden[name='mark_for_review_questions[" + questions_key[q_id] + "]']").val(1);
                }
                // if ($("input:hidden[name='mark_for_review_questions["+ questions_key[q_id] +"]']").val() == 0) {
                //     console.log('0');
                //     $("#question_i_"+questions_key[q_id]).removeAttr('style','visibility:hidden');
                //     $("#question_i_"+questions_key[q_id]).attr('style','visibility:visible');
                //     $("input:hidden[name='mark_for_review_questions["+ questions_key[q_id] +"]']").val(1);
                // }

                // $("#question_i_"+questions_key[q_id]).removeAttr('style','visibility:hidden');
                // $("#question_i_"+questions_key[q_id]).attr('style','visibility:visible');
                // $("#question_i_"+questions_key[q_id]).addClass('mark-review');
                // $("input:radio[name='question["+ questions_key[old_id] +"]']").each(function(){
                //     $(this).prop("checked",false);
                // });
                // $("input:hidden[name='attemted_questions["+ questions_key[old_id] +"]']").val(0);
            });

            $("#myBtnl").click(function() {
                var attempt_count = 0;
                var not_attempt = 0;
                var marked_review = 0;
                var temp_key;
                $("input:hidden[name^='attemted_questions']").each(function() {
                    if ($(this).val() == 1) {
                        temp_key = $(this).attr('key');
                        $("#modal_question_li_" + temp_key).removeClass('incomplete');
                        $("#modal_question_li_" + temp_key).addClass('active1');
                        attempt_count += 1;
                        $("#attempt_count").empty();
                        $("#attempt_count").html(attempt_count);
                    }
                    if ($(this).val() == 0) {
                        temp_key = $(this).attr('key');
                        $("#modal_question_li_" + temp_key).removeClass('active1');
                        $("#modal_question_li_" + temp_key).addClass('incomplete');
                        // attempt_count-=1;
                        not_attempt += 1;
                        $("#not_attempt").empty();
                        $("#not_attempt").html(not_attempt);
                    }
                });
                $("input:hidden[name^='mark_for_review_questions']").each(function() {

                    if ($(this).val() == 1) {
                        temp_key = $(this).attr('key');
                        $("#modal_question_span_" + temp_key).removeAttr('style',
                            'visibility:hidden');
                        $("#modal_question_span_" + temp_key).attr('style', 'visibility:visible');
                        marked_review += 1;
                        $("#marked_review").empty();
                        $("#marked_review").html(marked_review);
                    }
                    if ($(this).val() == 0) {
                        temp_key = $(this).attr('key');
                        $("#modal_question_span_" + temp_key).removeAttr('style',
                            'visibility:visible');
                        $("#modal_question_span_" + temp_key).attr('style', 'visibility:hidden');
                        // $("#modal_question_span_"+temp_key).removeClass('mark-review');
                    }
                });
            });

            $('#submit_test').click((event) => {
                event.preventDefault();
                @if ($data['test_start']->show_result == 1)
                    $("#show_result").val(1);
                    swal({
                        title: 'Sweet!',
                        titleText: 'Test has been submitted succesfully....',
                        text: 'Now you can view your result below.',
                        imageUrl: '{{ URL::asset('frontend/images/emoji_with_thumbs_up.png') }}',
                        imageWidth: 400,
                        imageHeight: 200,
                        confirmButtonText: 'View Result',
                    }).then(
                        function(data) {
                            if (data) {
                                document.getElementById("test_submit_form").submit();
                            }
                        },
                        function(dismiss) {
                            document.getElementById("test_submit_form").submit();
                        }
                    );
                @else
                    $("#show_result").val(0);
                    swal({
                        title: 'Sweet!',
                        titleText: 'Test has been submitted succesfully....',
                        text: 'Your result will be declare soon.',
                        imageUrl: '{{ URL::asset('frontend/images/emoji_with_thumbs_up.png') }}',
                        imageWidth: 400,
                        imageHeight: 200,
                        confirmButtonText: 'Home',
                    }).then(
                        function(data) {
                            if (data) {
                                document.getElementById("test_submit_form").submit();
                            }
                        },
                        function(dismiss) {
                            document.getElementById("test_submit_form").submit();
                        }
                    );
                @endif
                // swal({
                //     title: 'Sweet!',
                //     titleText: 'Test has been submitted succesfully....',
                //     text: 'Now you can view your result below.',
                //     imageUrl: '{{ URL::asset('frontend/images/emoji_with_thumbs_up.png') }}',
                //     imageWidth: 400,
                //     imageHeight: 200,
                //     confirmButtonText:'View Result',
                // }).then(
                //     function(data){
                //         if(data){
                //             document.getElementById("test_submit_form").submit(); 
                //         }
                //     },
                //     // function(dismiss) {
                //     //     document.getElementById("test_submit_form").submit(); 
                //     // }
                // );
            });
        });
    </script>

    <script>
        // Get the modal
        var modal = document.getElementById("loc-Modal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtnl");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-modal")[0];

        var submit_test = document.getElementById("submit_test");

        // var question_list1 = document.getElementsByClassName("question-list")[0];


        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        submit_test.onclick = function() {
            modal.style.display = "none";
        }

        $(document).on('click', '.question-list', function() {
            modal.style.display = "none";
        });
        // question_list1.onclick = function() {
        //     modal.style.display = "none";
        // }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection
