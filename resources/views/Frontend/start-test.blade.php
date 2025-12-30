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
    <div class="ed_detail_head" style="padding: 10px;">
        <div class="container">
            <div class="row align-items-center" style="flex-wrap: nowrap;display: flex;flex-direction: row;">
                <div class="col-lg-8 col-md-7">
                    <div class="ed_detail_wrap">
                        <div class="ed_header_caption">
                            <h2 class="ed_title">{{ $data['test_start']->title }}</h2>
                        </div>

                    </div>
                </div>
                <div class="counter col-lg-4 position-relative">
                    <div class="d-flex justify-content-between">
                        <h3 style="color: red"><b>Time Left - <span id="timer">00:00:00</span></b></h3>
                        <h3 style="position: absolute; right: 0" clas="">Total Qs -
                            {{ $data['test_start']['total_questions'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pt-0">
        <div class="container">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="custom-tab customize-tab tabs_creative">
                    <ul class="nav nav-tabs b-0 pb-2" id="myTab" role="tablist">
                        @foreach ($data['test_start']->getSection as $i => $section)
                            @if ($i == 0)
                                <li class="nav-item">
                                    <a class="nav-link active test-tab-{{ $i }}"
                                        id="{{ $section->sectionSubject->name }}_{{ $i }}-tab"
                                        data-id="{{ $i }}" data-toggle="tab"
                                        href="#{{ $section->sectionSubject->name }}_{{ $i }}" role="tab"
                                        aria-controls="{{ $section->sectionSubject->name }}_{{ $i }}"
                                        aria-selected="true">{{ $section->sectionSubject->name }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link test-tab-{{ $i }}"
                                        id="{{ $section->sectionSubject->name }}_{{ $i }}-tab"
                                        data-id="{{ $i }}" data-toggle="tab"
                                        href="#{{ $section->sectionSubject->name }}_{{ $i }}" role="tab"
                                        aria-controls="{{ $section->sectionSubject->name }}_{{ $i }}"
                                        aria-selected="false">{{ $section->sectionSubject->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <form id="test_submit_form" action="{{ url('end-test/' . $data['test_start']->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-12 order-lg-first">
                        <!-- Overview -->
                        <input id="show_result" name="show_result" type="hidden" value="0">
                        <?php $questions_count = 0; ?>
                        @foreach ($data['test_start']->getSection as $i => $section)
                            @foreach ($section->getQuestions()->wherePivot('deleted_at', '=', null)->get() as $j => $questions)
                                <div class="edu_wraper test-questions test-questions_{{ $j += 1 }} px-1 py-0"
                                    id="question_{{ $questions->id }}" data-id="{{ $i }}"
                                    key="{{ $questions->id }}">
                                    <h3 class="edu_title" style="color: red;">Question Number {{ $questions_count += 1 }}
                                    </h3>
                                    <div class="d-flex">
                                        <p style="flex:none;"> Qs {{ $questions_count }} - &nbsp;</p>
                                        {!! $questions->question !!}
                                    </div>
                                    <ul class="no-ul-list img-ls-src">
                                        @for ($k = 1; $k <= $questions->mcq_options; $k++)
                                            <li>
                                                <input class="checkbox-custom"
                                                    id="answer_{{ $i }}_{{ $j }}_{{ $k }}"
                                                    name="question[{{ $questions->id }}]" type="radio"
                                                    value="ans_{{ $k }}">
                                                <label class="checkbox-custom-label"
                                                    for="answer_{{ $i }}_{{ $j }}_{{ $k }}">{!! $questions['ans_' . $k] !!}</label>
                                            </li>
                                        @endfor
                                    </ul>
                                    <input name="clear_questions[{{ $questions->id }}]" type="hidden" value="0">
                                    <input name="mark_for_review_questions[{{ $questions->id }}]" type="hidden"
                                        value="0" key="{{ $questions->id }}">
                                    <input name="attemted_questions[{{ $questions->id }}]" type="hidden" value="0"
                                        key="{{ $questions->id }}">
                                </div>
                            @endforeach
                        @endforeach
                        <button class="btn btn-outline-theme" id="mark-for-review" type="button" onclick="starShow(0)">Mark
                            for Review <i class="ti-hand-open"></i></button>
                        <button class="btn btn-outline-theme" id="clear-response" type="button">Clear Response <i
                                class="ti-brush-alt"></i></button>
                        <button class="btn btn-outline-theme" id="submit-answer" type="button">Save & Next<i
                                class="ti-angle-right"></i></button>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 col-md-12 order-lg-last p-0">
                        <div class="ed_view_box style_2 border-success rounded-0 border border-2">
                            <?php $questions_count = 0; ?>
                            <div class="tab-content" id="myTabContent">
                                @foreach ($data['test_start']->getSection as $i => $section)
                                    @if ($i == 0)
                                        <div class="row">
                                            <div class="col-3">
                                                <img class="student_image"
                                                    src="{{ '/storage/' . auth()->user()->user_details->photo_url }}"
                                                    alt="">
                                            </div>
                                            <div class="col-9 d-flex flex-column justify-content-center text-center"
                                                style="padding-left: 0;">
                                                <h3
                                                    class="studen_name border-top-0 border-end-0 border-start-0 border-light border border-2">
                                                    {{ auth()->user()->name }}</h3>
                                                <h3 class="test_name" id="test_name">{{ $section->sectionSubject->name }}
                                                </h3>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="tab-pane gray fade {{ $i == 0 ? 'show active ' : '' }} test-tab-content-{{ $i }} pb-3"
                                        id="{{ $section->sectionSubject->name }}_{{ $i }}"
                                        data-id="{{ $i }}" role="tabpanel"
                                        aria-labelledby="{{ $section->sectionSubject->name }}_{{ $i }}-tab">
                                        <div class="eld mb-3">
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


                                <div class="d-flex justify-content-between pt-3">
                                    <div><a class="d-flex align-items-center underline"
                                            href="{{ route('question_paper', [$data['test_start']->id]) }}">Question
                                            Paper<i class="ti-angle-right"></i></a></div>
                                    <div></div>
                                </div>
                                <div class="ed_view_link">
                                    <button class="btn theme-bg enroll-btn" id="myBtnl" type="button"
                                        onclick="alert('Test submitted succesfully....')">Review & Submit<i
                                            class="ti-angle-right"></i></button>
                                </div>

                            </div>

                            <div class="modal-loc" id="loc-Modal">
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
                                                    <!-- <a class="btn theme-light enroll-btn" href="{{ route('question_paper', [$data['test_start']->id]) }}">Question Paper<i class="ti-angle-right"></i></a> -->
                                                    <button class="btn theme-bg enroll-btn" id="submit_test"
                                                        type="button">Submit Test<i class="ti-angle-right"></i></button>
                                                    <!-- <a class="btn theme-bg enroll-btn" href="#">Submit Test<i class="ti-angle-right"></i></a> -->
                                                </div>
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
                $(".test-questions").hide();
                var section_id = $(this).attr('data-id');
                $('.test-questions[data-id=' + section_id + ']')[0].style.display = 'block';
                console.log(this.innerHTML);
                $("#test_name").html(this.innerHTML);

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
                    Swal.fire({
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
                    Swal.fire({
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
