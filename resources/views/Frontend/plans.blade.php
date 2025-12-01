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
                    <h1 class="breadcrumb-title text-light">Our Packages</h1>
                    <nav class="transparent">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item"><a href="#" class="text-light">Home</a></li>
                            <li class="breadcrumb-item active theme-cl" aria-current="page">Pricing</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ Pricing Table ================================== -->
<section class="min">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="sec-heading center">
                    <h2>Select Your <span class="theme-cl">Package</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center">
            
            <!-- Single Package -->
            @foreach($gn_PackagePlan as $key => $packagePlan)
            <div class="col-lg-4 col-md-4">
                <div class="pricing_wrap">
                    <div class="prt_head">
                        <h4>{{ $packagePlan->plan_name}}</h4>
                    </div>
                    <div class="prt_price">
                        <h2><span>&#x20B9</span>{{ $packagePlan->final_fees }}</h2>
                        <!-- <span>{{ $packagePlan->duration }} days, per user </span>  -->
                    </div>
                    <div class="prt_body">
                        <ul>
                            {{-- li>99.5% Uptime Guarantee</li> --}}
                            <li>{{ $packagePlan->duration }} days</li>
                            <li>{{ count($packagePlan->test) }} tests</li>
                            {{-- <li>5GB Cloud Storage</li>
                            <li class="none">Personal Help Support</li>
                            <li class="none">Enterprise SLA</li> --}}
                        </ul>
                    </div>
                    <div class="prt_footer">
                        <a href="{{ route('student.plan-checkout',[$packagePlan->id]) }}" class="btn choose_package active">Buy Now</a>
                    </div>
                </div>
            </div>
            @endforeach
            
            
            <!-- Single Package -->
            {{-- <div class="col-lg-4 col-md-4">
                <div class="pricing_wrap">
                    <div class="prt_head">
                        <div class="recommended">Best Value</div>
                        <h4>Standard</h4>
                    </div>
                    <div class="prt_price">
                        <h2><span>$</span>49</h2>
                        <span>per user, per month</span>
                    </div>
                    <div class="prt_body">
                        <ul>
                            <li>99.5% Uptime Guarantee</li>
                            <li>150GB CDN Bandwidth</li>
                            <li>10GB Cloud Storage</li>
                            <li>Personal Help Support</li>
                            <li class="none">Enterprise SLA</li>
                        </ul>
                    </div>
                    <div class="prt_footer">
                        <a href="#" class="btn choose_package active">Start Standard</a>
                    </div>
                </div>
            </div>
            
            <!-- Single Package -->
            <div class="col-lg-4 col-md-4">
                <div class="pricing_wrap">
                    <div class="prt_head">
                        <h4>Platinum</h4>
                    </div>
                    <div class="prt_price">
                        <h2><span>$</span>79</h2>
                        <span>2 user, per month</span>
                    </div>
                    <div class="prt_body">
                        <ul>
                            <li>100% Uptime Guarantee</li>
                            <li>200GB CDN Bandwidth</li>
                            <li>20GB Cloud Storage</li>
                            <li>Personal Help Support</li>
                            <li>Enterprise SLA</li>
                        </ul>
                    </div>
                    <div class="prt_footer">
                        <a href="#" class="btn choose_package">Start Platinum</a>
                    </div>
                </div>
            </div> --}}
            
        </div>
        
    </div>
</section>
<!-- ============================ Pricing Table End ================================== -->

<!-- ============================ partner Start ================================== -->
<section class="gray">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="sec-heading center">
                    <h2>Trusted By <span class="theme-cl">10,000</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
            <!-- Single Item -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="crs_partn">
                    <div class="p-3">
                        <img src="https://via.placeholder.com/400x110" class="img-fluid" alt="" />
                    </div>
                </div>							
            </div>
            
        </div>
        
    </div>
</section>
<div class="clearfix"></div>
<!-- ============================ partner End ================================== -->

<!-- ============================ Students Reviews ================================== -->
<section>
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="sec-heading center">
                    <h2>Our Students <span class="theme-cl">Reviews</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-sm-12">
                
                <div class="reviews-slide space">
                    
                    <!-- Single Item -->
                    <div class="single_items lios_item">
                        <div class="_testimonial_wrios shadow_none border">
                            <div class="_testimonial_flex">
                                <div class="_testimonial_flex_first">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                    </div>
                                    <div class="_tsl_flex_capst">
                                        <h5>Susan D. Murphy</h5>
                                        <div class="_ovr_posts"><span>CEO, Leader</span></div>
                                        <div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
                                    </div>
                                </div>
                                <div class="_testimonial_flex_first_last">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/300x300" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="facts-detail">
                                <p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single Item -->
                    <div class="single_items lios_item">
                        <div class="_testimonial_wrios shadow_none border">
                            <div class="_testimonial_flex">
                                <div class="_testimonial_flex_first">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                    </div>
                                    <div class="_tsl_flex_capst">
                                        <h5>Maxine E. Gagliardi</h5>
                                        <div class="_ovr_posts"><span>Apple CEO</span></div>
                                        <div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.5</div>
                                    </div>
                                </div>
                                <div class="_testimonial_flex_first_last">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/300x300" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="facts-detail">
                                <p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single Item -->
                    <div class="single_items lios_item">
                        <div class="_testimonial_wrios shadow_none border">
                            <div class="_testimonial_flex">
                                <div class="_testimonial_flex_first">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                    </div>
                                    <div class="_tsl_flex_capst">
                                        <h5>Roy M. Cardona</h5>
                                        <div class="_ovr_posts"><span>Google Founder</span></div>
                                        <div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.9</div>
                                    </div>
                                </div>
                                <div class="_testimonial_flex_first_last">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/300x300" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="facts-detail">
                                <p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single Item -->
                    <div class="single_items lios_item">
                        <div class="_testimonial_wrios shadow_none border">
                            <div class="_testimonial_flex">
                                <div class="_testimonial_flex_first">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                    </div>
                                    <div class="_tsl_flex_capst">
                                        <h5>Dorothy K. Shipton</h5>
                                        <div class="_ovr_posts"><span>Linkedin Leader</span></div>
                                        <div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
                                    </div>
                                </div>
                                <div class="_testimonial_flex_first_last">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/300x300" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="facts-detail">
                                <p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Single Item -->
                    <div class="single_items lios_item">
                        <div class="_testimonial_wrios shadow_none border">
                            <div class="_testimonial_flex">
                                <div class="_testimonial_flex_first">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                    </div>
                                    <div class="_tsl_flex_capst">
                                        <h5>Robert P. McKissack</h5>
                                        <div class="_ovr_posts"><span>CEO, Leader</span></div>
                                        <div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
                                    </div>
                                </div>
                                <div class="_testimonial_flex_first_last">
                                    <div class="_tsl_flex_thumb">
                                        <img src="https://via.placeholder.com/300x300" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="facts-detail">
                                <p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
                            </div>
                        </div>
                    </div>
                
                </div>
            
            </div>
        </div>
        
    </div>
</section>
<!-- ============================ Students Reviews End ================================== -->



@endsection

@section('js')

@endsection