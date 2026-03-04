@extends('Layouts.frontend')

@section('css')

@endsection
@section('main')
<!-- ============================ Page Title Start================================== -->
<section class="page-title bg-cover" style="background:url(https://via.placeholder.com/1920x1200)no-repeat;" data-overlay="8">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                
                <div class="breadcrumbs-wrap">
                    <h1 class="breadcrumb-title text-light">Tests</h1>
                    <nav class="transparent">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item"><a href="#" class="text-light">Home</a></li>
                            <li class="breadcrumb-item active theme-cl" aria-current="page">Test</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- ============================ Page Title End ================================== -->
<!-- ============================ Instructor Start ================================== -->
<section class="min gray">
    <div class="container">

        <!-- <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="sec-heading center">
                    <h2>Best Courses by Top <span class="theme-cl">Instructor</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
            </div>
        </div> -->

        <div class="row justify-content-center">

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/01.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>Physics Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">Civil Services</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(244 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 2.5k Users Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/02.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>History Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">SSC - CGL</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(119 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 3.2k Users Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/03.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>Hindi Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">UP Lekhpal</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(96 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 2.2k Users Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/04.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>Math Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">Railway Group-D</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(149 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 3.1k Users Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/05.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>Bio Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">SBI Clerk</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(204 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 2.3k Users Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/06.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>Chemistry Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">Indian Defence</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(74 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 1.5k Users Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/07.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>Sociology Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">UP TET</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(96 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 1.2k Users Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="crs_trt_grid">
                    <div class="crs_trt_thumb circle">
                        <a href="instructor-detail.html" class="crs_trt_thum_link"><img
                                src="{{asset('images/home/09.jpg')}}" class="img-fluid circle" alt=""></a>
                    </div>
                    <div class="crs_trt_caption">
                        <div class="instructor_tag dark"><span>Regining Teacher</span></div>
                        <div class="instructor_title">
                            <h4><a href="#">UP Police (SI)</a></h4>
                        </div>
                        <div class="trt_rate_inf">
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star filled"></i>
                            <i class="fa fa-star-half filled"></i>
                            <span class="alt_rates">(73 Reviews)</span>
                        </div>
                    </div>
                    <div class="crs_trt_footer">
                        <div class="crs_trt_ent"><i class="fa fa-user"></i> 2.1k Users Enrolled</div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
<div class="clearfix"></div>
<!-- ============================ Instructor End ================================== -->


@endsection

@section('js')

@endsection