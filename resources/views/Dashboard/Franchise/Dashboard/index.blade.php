@extends('Layouts.franchise')

@section('main')
    <div class="container p-0 franchise-dashboard">

        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    <div class="col">
                        <div class="card franchise-card custom-dash-card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('/super/images/8.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">{{ $data['newSignup'] }}</div>
                                    <div class="num_heading">New User signup</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading {{ $data['newSignup'] > 0 ? 'action_required' : '' }}">
                                    <a href="{{ route('franchise.users_type', 'new') }}">
                                        {{ $data['newSignup'] > 0 ? 'Action Required!' : 'View Details' }}

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card franchise-card custom-dash-card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('/super/images/14.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">{{ $data['totalStudents'] }}</div>
                                    <div class="num_heading">Students</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading {{ $data['totalStudents'] > 0 ? 'action_required' : '' }}">
                                    <a href="{{ route('franchise.users_type', 'students') }}">
                                        {{ $data['totalStudents'] > 0 ? 'Action Required!' : 'View Details' }}

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card franchise-card custom-dash-card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('/super/images/15.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">{{ $data['totalManagers'] }}</div>
                                    <div class="num_heading">Managers</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading {{ $data['totalManagers'] > 0 ? 'action_required' : '' }}">
                                    <a href="{{ route('franchise.users_type', 'managers') }}">
                                        {{ $data['totalManagers'] > 0 ? 'Action Required!' : 'View Details' }}

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card franchise-card custom-dash-card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('/super/images/16.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">{{ $data['totalCreators'] }}</div>
                                    <div class="num_heading">Creators</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading {{ $data['totalCreators'] > 0 ? 'action_required' : '' }}">
                                    <a href="{{ route('franchise.users_type', 'creators') }}">
                                        {{ $data['totalCreators'] > 0 ? 'Action Required!' : 'View Details' }}

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card franchise-card custom-dash-card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('/super/images/17.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">{{ $data['totalPublishers'] }}</div>
                                    <div class="num_heading">Publishers</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading {{ $data['totalPublishers'] > 0 ? 'action_required' : '' }}">
                                    <a href="{{ route('franchise.users_type', 'publishers') }}">
                                        {{ $data['totalPublishers'] > 0 ? 'Action Required!' : 'View Details' }}

                                        <i class="bi bi-arrow-right-circle icon_img"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card franchise-card custom-dash-card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('/super/images/18.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">{{ $data['totalMulti'] }}</div>
                                    <div class="num_heading">Multi Role</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading {{ $data['totalMulti'] > 0 ? 'action_required' : '' }}">
                                    <a href="{{ route('franchise.users_type', 'multi') }}">
                                        {{ $data['totalMulti'] > 0 ? 'Action Required!' : 'View Details' }}
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
@endsection
