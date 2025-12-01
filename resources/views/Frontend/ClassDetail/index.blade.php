@extends('Layouts.frontend')

@section('css')
    <style>
        .sectio-padding {
            padding: 50px 0 !important;
        }

        .custom-bg-green {
            background: #effff2
        }

        .course-image {
            background: #fff;
        }

        .course-image img {
            object-fit: contain
        }

        .text-gray {
            color: #575757
        }

        .text-green {
            color: #20c997
        }

        .link-btn {
            background: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
        }

        .link-btn:hover {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px !important;
        }

        .authorised-detail p {
            padding: 0;
            margin: 0;
        }

        .authorised-detail .list {
            padding: 15px 0;
        }

        .custom-tabs {
            background: #effff2;
            padding: 5px 10px;
        }

        .custom-tab-list {
            padding: 8px 20px;
            width: 200px;
            text-align: center;
            border-radius: 8px;
        }

        .custom-tab-list.active {
            background: #fff;
            color: #03b97c
        }

        .start {
            padding-top: 25px
        }

        .start-btn {
            padding: 6px 20px;
            border-radius: 5px;
        }
    </style>
@endsection
@section('main')

    @php
    $course_logo =  $course_detail->course_image ?? 'https://cdn6.aptoide.com/imgs/2/f/e/2fe1ded8d7b024b1898cfd0ce631ce60_icon.png';
    $course_short_name =  $course_detail->course_short_name ?? "";
    $course_full_name =  $course_detail->course_full_name ?? "";
    $noti_img =  $course_detail->notification_image ?? "";
    $examp_img =  $course_detail->exam_detail ?? "";
    // $free_test =  $course_detail->free_study_note;
    $free_study_notes =  $course_detail->free_study_note ?? "";
    $free_paper =  $course_detail->previous_papers ?? "";
    $description =  $course_detail->description ?? "";

    $noti_data  = $course_detail->notification_data ?? "";
    $registration = $course_detail->registration ?? "";
    $exam_date = $course_detail->exam_date ?? "";
    $exam_mode= $course_detail->exam_mode ?? "";
    $vacancies= $course_detail->vacancies ?? "";
    $eligibility= $course_detail->eligibility ?? "";
    $salary= $course_detail->salary ?? "";
    $website = $course_detail->official_site ?? "";
    $required_first= $course_detail->required_A ?? "";
    $required_second = $course_detail->required_B ?? "";
    @endphp
    <section class="custom-bg-green sectio-padding">
        <div class="container">
            <div class="d-flex">
                <div>
                    <div class="course-image rounded">
                        <img src="{{asset($course_logo)}}"
                            alt="" width="150" height="150">
                    </div>
                </div>
                <div class="px-4 d-flex flex-column justify-content-center">
                    <h4>{{ $education_type_data->name }}</h4>
                    <h1>{{ $classes_groups_exams_data->name }}</h1>
                    <div class="d-flex" style="gap: 10px;">
                        <p class="text-gray">{{ $students_count }}+ Student Interested</p>
                        |
                        <p><b> 4.5</b> / 5
                        <ul class="d-flex" style="color: gold; gap: 2px">
                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            <li><i class="fa fa-star-half" aria-hidden="true"></i></li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-flex pt-3" style="gap: 20px; flex-wrap: wrap;">
                <a href="{{asset($noti_img)}}" class="d-flex align-items-center link-btn " download="">Gazette Notification &nbsp; <i
                        class="fas fa-download"></i></a>
                <a href="{{asset($examp_img)}}" class="d-flex align-items-center link-btn " download>Exam Details &nbsp; <i
                        class="fas fa-download"></i></a>
                <a href="" class="d-flex align-items-center link-btn " download>Free Test & Quiz</a>
                <a href="{{asset($free_study_notes)}}" class="d-flex align-items-center link-btn " download>Free Study Notes &nbsp; <i
                        class="fas fa-download"></i></a>
                <a href="{{asset($free_paper)}}" class="d-flex align-items-center link-btn " download>Previous Year Paper &nbsp; <i
                        class="fas fa-download" download></i></a>

            </div>
        </div>
    </section>
    <section class="sectio-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    {!!$description!!}
                </div>
                <div class="col-12 col-md-4">
                    <h2>Authorised Details</h2>
                    <div class="shadow">
                        <div class="p-4 authorised-detail">
                            <div
                                class="list d-flex justify-content-between border border-top-0 border-end-0 border-start-0">
                                <p>Notification Date</p>
                                <p>24 sept 2023 - 26 sept 2023</p>
                            </div>
                            <div
                                class="list d-flex justify-content-between border border-top-0 border-end-0 border-start-0">
                                <p>Registraton</p>
                                <p>{{$registration}}</p>
                            </div>
                            <div
                                class="list d-flex justify-content-between border border-top-0 border-end-0 border-start-0">
                                <p>Exam Date</p>
                                <p>{{$exam_date}}</p>
                            </div>
                            <div
                                class="list d-flex justify-content-between border border-top-0 border-end-0 border-start-0">
                                <p>Exam Mode</p>
                                <p>{{$exam_mode}} </p>
                            </div>
                            <div
                                class="list d-flex justify-content-between border border-top-0 border-end-0 border-start-0">
                                <p>Vacancies</p>
                                <p>{{$vacancies}}</p>
                            </div>
                            <div
                                class="list d-flex justify-content-between border border-top-0 border-end-0 border-start-0">
                                <p>Eligibility</p>
                                <p>{{$eligibility}}</p>
                            </div>
                            <div
                                class="list d-flex justify-content-between border border-top-0 border-end-0 border-start-0">
                                <p>Salary</p>
                                <p>{{$salary}}</p>
                            </div>
                            <div class="list d-flex justify-content-between ">
                                <p>Official Site</p>
                                <p><a href="{{$website}}">{{$website}}</a></p>
                            </div>
                            <div class="list d-flex justify-content-between ">

                               <p></p>
                                <p>{{$required_first}}</p>
                            </div>
                            <div class="list d-flex justify-content-between ">

                                <p></p>
                                 <p>{{$required_second}}</p>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sectio-padding">
        <div class="container">
            <div class="d-flex justify-content-center border border-top-0 border-end-0 border-start-0 pb-4"
                style="flex-wrap: wrap;">
                <div class="d-flex custom-tabs justify-content-center" style="gap:20px; flex-wrap: wrap; ">
                    <a href="javascript:void(0)" onclick="handleTab(this)" class="custom-tab-list active"
                        data-value="test">Test & Quiz</a>
                    <a href="javascript:void(0)" onclick="handleTab(this)" class="custom-tab-list" data-value="study">Study
                        Materials</a>
                    <a href="javascript:void(0)" onclick="handleTab(this)" class="custom-tab-list"
                        data-value="package">Packages</a>
                </div>
            </div>
            <div class="py-4">
                <div class="custom-tab-content" id="test">
                    <div class="row text-center">

                        <!-- Team item -->
                        @foreach ($tests_category_data as $item)
                            <div class="col-xl-3 col-sm-6 mb-5">
                                <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                        src="{{ '/storage/app/' . $item->cat_image }}" alt="" width="100"
                                        class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                    <h5 class="mb-0">{{ $item->cat_name }}</h5>

                                    <div class="start">
                                        @if ($item->cat_name == 'Premium Test')
                                            <a href="{{route('student.dashboard_gyanology_list', ['cat' => $item->id])}}" class="start-btn border">Explore Now</a>
                                        @else
                                            <a href="{{route('student.dashboard_gyanology_list', ['cat' => $item->id])}}" class="start-btn border">Start Free</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/institute_test.png" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Institute Test</h5>

                                <div class="start">
                                        <a href="{{route('student.dashboard_tests_list')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-tab-content" id="study" style="display: none;">
                    <div class="row text-center">
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/student_note.png" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Study Notes & E-Books</h5>

                                <div class="start">
                                        <a href="{{route('student.show')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/video_note.png" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Live & Video Classes</h5>

                                <div class="start">
                                        <a href="{{route('student.showvideo')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/gk.png" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Static GK & Current Affairs</h5>

                                <div class="start">
                                        <a href="{{route('student.showgk')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/institute_test.png" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Comprehensive Study Material</h5>

                                <div class="start">
                                        <a href="{{route('student.show')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/institute_test.png" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Short Notes & One Liner</h5>

                                <div class="start">
                                        <a href="{{route('student.show')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/institute_test.png" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Premium Study Notes</h5>

                                <div class="start">
                                        <a href="{{route('student.show')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                    </div></div>
                <div class="custom-tab-content" id="package" style="display: none;">
                    <div class="row text-center">
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/menu-package.jpeg" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Free Packages</h5>

                                <div class="start">
                                        <a href="{{route('student.plan')}}" class="start-btn border">Start Free</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="bg-white rounded shadow-sm py-4 px-4"><img
                                    src="/student1/images/menu-package.jpeg" alt="" width="100"
                                    class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                <h5 class="mb-0">Premium Packages</h5>

                                <div class="start">
                                        <a href="{{route('student.plan')}}" class="start-btn border">Explore Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function handleTab(event) {
            $('.custom-tab-list').removeClass('active')
            $('.custom-tab-content').hide()
            const tabName = event.getAttribute('data-value')
            event.classList.add('active')
            $('#' + tabName).show();
        }
    </script>
@endsection
