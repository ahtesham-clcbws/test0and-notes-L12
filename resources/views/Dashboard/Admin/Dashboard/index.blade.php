@extends('Layouts.admin')

@section('main')
    <div class="container p-0">
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#fb6f24">
                            <div class="part1" style="background-color:#fff8ad">
                                <div class="img_area" style="border-color:#fb6f24">
                                    <img class="box_icon" src="{{ asset('super/images/1.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#ff0000">{{ $data['counts']['new_business_enquiry'] }}</div>
                                    <div class="num_heading">New business Enquiry</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#fb6f24">
                                <div class="box_heading">
                                    <a href="/administrator/corporate-enquiry/type/new" style="color:#ff0000">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#fb6f24">
                            <div class="part1" style="background-color:#fffaa4">
                                <div class="img_area" style="border-color:#fb6f24">
                                    <img class="box_icon" src="{{ asset('super/images/2.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#EC268F">{{ $data['counts']['approved_business_enquiry'] }}</div>
                                    <div class="num_heading">Approved business Enquiry</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#fb6f24">
                                <div class="box_heading">
                                    <a href="/administrator/corporate-enquiry/type/approved" style="color:#EC268F">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#fb6f24">
                            <div class="part1" style="background-color:#fff8ad">
                                <div class="img_area" style="border-color:#fb6f24">
                                    <img class="box_icon" src="{{ asset('super/images/3.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#EC268F">{{ $data['counts']['pending_business_enquiry'] }}</div>
                                    <div class="num_heading">Pending business Enquiry</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#fb6f24">
                                <div class="box_heading">
                                    <a href="/administrator/corporate-enquiry/type/rejected" style="color:#EC268F">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#EC9E4F">
                            <div class="part1" style="background-color:#FECE5E">
                                <div class="img_area" style="border-color:#EC9E4F">
                                    <img class="box_icon" src="{{ asset('super/images/4.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#e10d0a">{{ $data['counts']['franchise_discontinue'] }}</div>
                                    <div class="num_heading">Franchise Discontinue</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#EC9E4F">
                                <div class="box_heading">
                                    <a href="/administrator/corporate-enquiry/type/discontinue" style="color:#e10d0a">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#EC9E4F">
                            <div class="part1" style="background-color:#FECE5E">
                                <div class="img_area" style="border-color:#EC9E4F">
                                    <img class="box_icon" src="{{ asset('super/images/5.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#e10d0a">{{ $data['counts']['student_left_direct'] }}</div>
                                    <div class="num_heading">Student Left Direct Portal</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#EC9E4F">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/left" style="color:#e10d0a">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#EC9E4F">
                            <div class="part1" style="background-color:#FECE5E">
                                <div class="img_area" style="border-color:#EC9E4F">
                                    <img class="box_icon" src="{{ asset('super/images/6.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#e10d0a">{{ $data['counts']['contact_forms_month'] }}</div>
                                    <div class="num_heading">Contact Forms (This Month)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#EC9E4F">
                                <div class="box_heading">
                                    <a href="{{ route('administrator.manage.contactEnquiry') }}" style="color:#e10d0a">
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
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#a0191f">
                            <div class="part1" style="background-color:#fbdeeb">
                                <div class="img_area" style="border-color:#a0191f">
                                    <img class="box_icon" src="{{ asset('super/images/7.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#ff0000">{{ $data['counts']['new_corporate_signup'] }}</div>
                                    <div class="num_heading">New Corporate Sign Up</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#a0191f">
                                <div class="box_heading">
                                    <a href="/administrator/corporate-enquiry/type/converted" style="color:#ff0000">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#a0191f">
                            <div class="part1" style="background-color:#fbdeeb">
                                <div class="img_area" style="border-color:#a0191f">
                                    <img class="box_icon" src="{{ asset('super/images/8.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#93356F">{{ $data['counts']['competition_franchise'] }}</div>
                                    <div class="num_heading">Competition Franchise</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#a0191f">
                                <div class="box_heading">
                                    <a href="/administrator/franchise/type/compitition" style="color:#93356F">
                                        Action Required!

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#a0191f">
                            <div class="part1" style="background-color:#fbdeeb">
                                <div class="img_area" style="border-color:#a0191f">
                                    <img class="box_icon" src="{{ asset('super/images/9.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#93356F">{{ $data['counts']['academics_franchise'] }}</div>
                                    <div class="num_heading">Academics Franchise</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#a0191f">
                                <div class="box_heading">
                                    <a href="/administrator/franchise/type/academics" style="color:#93356F">
                                        Action Required!

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#a0191f">
                            <div class="part1" style="background-color:#fbdeeb">
                                <div class="img_area" style="border-color:#a0191f">
                                    <img class="box_icon" src="{{ asset('super/images/10.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#93356F">{{ $data['counts']['school_franchise'] }}</div>
                                    <div class="num_heading">School Franchise</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#a0191f">
                                <div class="box_heading">
                                    <a href="/administrator/franchise/type/school" style="color:#93356F">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#a0191f">
                            <div class="part1" style="background-color:#fbdeeb">
                                <div class="img_area" style="border-color:#a0191f">
                                    <img class="box_icon" src="{{ asset('super/images/11.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#93356F">{{ $data['counts']['other_franchise'] }}</div>
                                    <div class="num_heading">Other Franchise</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#a0191f">
                                <div class="box_heading">
                                    <a href="/administrator/franchise/type/other" style="color:#93356F">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#a0191f">
                            <div class="part1" style="background-color:#fbdeeb">
                                <div class="img_area" style="border-color:#a0191f">
                                    <img class="box_icon" src="{{ asset('super/images/12.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#93356F">{{ $data['counts']['multi_franchise'] }}</div>
                                    <div class="num_heading">Multi Franchise</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#a0191f">
                                <div class="box_heading">
                                    <a href="/administrator/franchise/type/multi" style="color:#93356F">
                                        Action Required!

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#2e3192">
                            <div class="part1" style="background-color:#d9f0fd">
                                <div class="img_area" style="border-color:#2e3192">
                                    <img class="box_icon" src="{{ asset('super/images/8.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#ff0000">{{ $data['counts']['new_user_signup_franchise'] }}</div>
                                    <div class="num_heading">New User Sign Up (Franchise)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#2e3192">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/new/franchise" style="color:#ff0000">
                                        Action Required!

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#2e3192">
                            <div class="part1" style="background-color:#d9f0fd">
                                <div class="img_area" style="border-color:#2e3192">
                                    <img class="box_icon" src="{{ asset('super/images/14.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#2e3192">{{ $data['counts']['students_franchise'] }}</div>
                                    <div class="num_heading">Students (Franchise)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#2e3192">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/students/franchise" style="color:#2e3192">
                                        Action Required!

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#2e3192">
                            <div class="part1" style="background-color:#d9f0fd">
                                <div class="img_area" style="border-color:#2e3192">
                                    <img class="box_icon" src="{{ asset('super/images/15.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#2e3192">{{ $data['counts']['managers_franchise'] }}</div>
                                    <div class="num_heading">Managers (Franchise)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#2e3192">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/managers/franchise" style="color:#2e3192">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#2e3192">
                            <div class="part1" style="background-color:#d9f0fd">
                                <div class="img_area" style="border-color:#2e3192">
                                    <img class="box_icon" src="{{ asset('super/images/16.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#2e3192">{{ $data['counts']['creators_franchise'] }}</div>
                                    <div class="num_heading">Creators (Franchise)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#2e3192">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/creators/franchise" style="color:#2e3192">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#2e3192">
                            <div class="part1" style="background-color:#d9f0fd">
                                <div class="img_area" style="border-color:#2e3192">
                                    <img class="box_icon" src="{{ asset('super/images/17.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#2e3192">{{ $data['counts']['publishers_franchise'] }}</div>
                                    <div class="num_heading">Publilshers (Franchise)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#2e3192">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/publishers/franchise" style="color:#2e3192">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#2e3192">
                            <div class="part1" style="background-color:#d9f0fd">
                                <div class="img_area" style="border-color:#2e3192">
                                    <img class="box_icon" src="{{ asset('super/images/18.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#2e3192">{{ $data['counts']['multi_role_franchise'] }}</div>
                                    <div class="num_heading">Multi Role (Franchise)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#2e3192">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/multi/franchise" style="color:#2e3192">
                                        Action Required!

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#039050">
                            <div class="part1" style="background-color:#e5ffb1">
                                <div class="img_area" style="border-color:#039050">
                                    <img class="box_icon" src="{{ asset('super/images/19.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#ff0000">{{ $data['counts']['new_user_signup_direct'] }}</div>
                                    <div class="num_heading">New User Sign Up (Direct)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#039050">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/new" style="color:#ff0000">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#039050">
                            <div class="part1" style="background-color:#e5ffb1">
                                <div class="img_area" style="border-color:#039050">
                                    <img class="box_icon" src="{{ asset('super/images/14.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#039050">{{ $data['counts']['students_direct'] }}</div>
                                    <div class="num_heading">Students (Direct)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#039050">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/students" style="color:#039050">
                                        Action Required!

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#039050">
                            <div class="part1" style="background-color:#e5ffb1">
                                <div class="img_area" style="border-color:#039050">
                                    <img class="box_icon" src="{{ asset('super/images/15.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#039050">{{ $data['counts']['managers_direct'] }}</div>
                                    <div class="num_heading">Managers (Direct)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#039050">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/managers" style="color:#039050">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#039050">
                            <div class="part1" style="background-color:#e5ffb1">
                                <div class="img_area" style="border-color:#039050">
                                    <img class="box_icon" src="{{ asset('super/images/16.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#039050">{{ $data['counts']['creators_direct'] }}</div>
                                    <div class="num_heading">Creators (Direct)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#039050">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/creators" style="color:#039050">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#039050">
                            <div class="part1" style="background-color:#e5ffb1">
                                <div class="img_area" style="border-color:#039050">
                                    <img class="box_icon" src="{{ asset('super/images/17.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#039050">{{ $data['counts']['publishers_direct'] }}</div>
                                    <div class="num_heading">Publilshers (Direct)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#039050">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/publishers" style="color:#039050">
                                        View Details

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card custom-dash-card" style="border-color:#039050">
                            <div class="part1" style="background-color:#e5ffb1">
                                <div class="img_area" style="border-color:#039050">
                                    <img class="box_icon" src="{{ asset('super/images/18.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number" style="color:#039050">{{ $data['counts']['multi_role_direct'] }}</div>
                                    <div class="num_heading">Multi Role (Direct)</div>
                                </div>
                            </div>
                            <div class="part2" style="border-top-color:#039050">
                                <div class="box_heading">
                                    <a href="/administrator/users/type/multi" style="color:#039050">
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
    </div>
    {{-- <h2>Dashboard</h2> --}}
    {{-- <div class="container p-0">
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key < 6)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key > 5 && $key < 12)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key > 11 && $key < 18)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key > 17)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}
@endsection
