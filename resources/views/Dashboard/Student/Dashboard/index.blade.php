@extends('Layouts.student')

@section('main')

<style>
    /* .row-scrollable > .row > .col {
        width: 230px;
    } */
    .img_area_stu {
        width: 70px;
        height: 55px;
        padding: 3px;
    }
</style>

<div class="container p-0">
    <div class="dashboard-container">
        <div class="row-scrollable">
            <div class="row ">
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#fece5e; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/test_attempt.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;">{{ $testAttemptCount }}</div>
                                <div class="num_heading">Test Attempts</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.test-attempt') }}" class="text-primary" style="color:inherit">
                                    View Details!
                                    {{-- <span data-feather="arrow-right-circle-fill"></span> --}}
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#ace1f9; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/institute_test.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;">{{ $testInstitute }}</div>
                                <div class="num_heading">Institute Tests</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.dashboard_tests_list') }}" class="text-primary" style="color:inherit">
                                    View Details!
                                    {{-- <span data-feather="arrow-right-circle-fill"></span> --}}
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($test_cat as $item)
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#dee9a2; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ 'storage/app/'.$item->cat_image }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;">{{ $testCount[$item->id] }}</div>
                                <div class="num_heading">{{$item->cat_name}}</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.dashboard_gyanology_list',['cat'=>$item->id]) }}" class="text-primary" style="color:inherit">
                                    View Details!
                                    {{-- <span data-feather="arrow-right-circle-fill"></span> --}}
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
    <div class="dashboard-container">
        <div class="row-scrollable">
            <div class="row">
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#facacb; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/student_note.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;"><?php echo $notes_count; ?></div>
                                <div class="num_heading">Study Notes & E-Books</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.show') }}" class="text-primary" style="color:inherit">
                                    View Details
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#fff466; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/video_note.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;"><?php echo $video_count; ?></div>
                                <div class="num_heading">Live & Video Classes</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.showvideo') }}" class="text-primary" style="color:inherit">
                                    View Details
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#c6c4e1; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/gk.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;"><?php echo $gk_count; ?></div>
                                <div class="num_heading">Static GK & Current Affairs</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.showgk') }}" class="text-primary" style="color:inherit">
                                    View Details
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#ace1f9; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/institute_test.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;"><?php echo $comprehensive_count; ?></div>
                                <div class="num_heading">Comprehensive Study Material</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.showComprehensive') }}" class="text-primary" style="color:inherit">
                                    View Details
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#dee9a2; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/institute_test.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;"><?php echo $short_notes_count; ?></div>
                                <div class="num_heading">Short Notes & One Liner</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.showShortNotes') }}" class="text-primary" style="color:inherit">
                                    View Details
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card custom-dash-card" style="border-color:black; border-radius:10px;">
                        <div class="part1 py-1" style="background-color:#facacb; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="img_area_stu" style="border-color:red">
                                <img class="box_icon" src="{{ asset('student1/images/institute_test.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number text-primary" style="color:inherit;margin-top:10px;"><?php echo $premium_count; ?></div>
                                <div class="num_heading">Premium Study Notes</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="{{ route('student.showPremium') }}" class="text-primary" style="color:inherit">
                                    View Details
                                    <i class="bi bi-arrow-right-circle icon_img"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-container">
        <div class="flex-item-left">
            <span><i>Believe in yourself</i></span><br />
            <span><i>You will definately achieve your goal very soon!</i></span>
        </div>

    </div>
</div>
@endsection
