@extends('Layouts.frontend')

@section('css')
    <style>
        .package-subtitle {
            font-size: 10px;
        }

        .review-font-size {
            font-size: 12px;
        }

        .h-100-px {
            height: 100px;
        }

        .instructor_sub_title {
            font-size: 14px;
            font-weight: 900;

        }

        .test_color {
            font-size: 12px;
            color: #2e339e;
        }

        .font-20-px {
            font-size: 20px;
            text-transform: uppercase;
            font-weight: 900;
        }

        .align-text {
            text-align: left;
        }

        .three-sec {
            border: 1px solid;
        }

        p.pop-box-text {
            margin: 0px;
            font-weight: 700;
            line-height: 1.3;
        }

        .pop2-text {
            color: #ef6738;
        }

        p.academic-title {
            margin: 0px;
            background: #343d56;
            color: #fff;
            padding: 5px 15px;
        }

        p.academic-title2 {
            padding: 0px;
            margin: 0px;
            font-weight: 800;
        }

        a.exam-preparation-btn {
            background: #ee6639;
            padding: 5px 10px;
            color: #fff;
            margin: 5px;
        }

        /* rating input css  */
        .rating {
            --dir: right;
            --fill: gold;
            --fillbg: rgba(100, 100, 100, 0.15);
            --heart: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 21.328l-1.453-1.313q-2.484-2.25-3.609-3.328t-2.508-2.672-1.898-2.883-0.516-2.648q0-2.297 1.57-3.891t3.914-1.594q2.719 0 4.5 2.109 1.781-2.109 4.5-2.109 2.344 0 3.914 1.594t1.57 3.891q0 1.828-1.219 3.797t-2.648 3.422-4.664 4.359z"/></svg>');
            --star: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"/></svg>');
            --stars: 5;
            --starsize: 1.5rem;
            --symbol: var(--star);
            --value: 1;
            --w: calc(var(--stars) * var(--starsize));
            --x: calc(100% * (var(--value) / var(--stars)));
            block-size: var(--starsize);
            inline-size: var(--w);
            position: relative;
            touch-action: manipulation;
            appearance: none;
            -webkit-appearance: none;
        }

        [dir="rtl"] .rating {
            --dir: left;
        }

        .rating::-moz-range-track {
            background: linear-gradient(to var(--dir), var(--fill) 0 var(--x), var(--fillbg) 0 var(--x));
            block-size: 100%;
            mask: repeat left center/var(--starsize) var(--symbol);
        }

        .rating::-webkit-slider-runnable-track {
            background: linear-gradient(to var(--dir), var(--fill) 0 var(--x), var(--fillbg) 0 var(--x));
            block-size: 100%;
            mask: repeat left center/var(--starsize) var(--symbol);
            -webkit-mask: repeat left center/var(--starsize) var(--symbol);
        }

        .rating::-moz-range-thumb {
            height: var(--starsize);
            opacity: 0;
            width: var(--starsize);
        }

        .rating::-webkit-slider-thumb {
            height: var(--starsize);
            opacity: 0;
            width: var(--starsize);
            -webkit-appearance: none;
        }

        .rating,
        .rating-label {
            display: block;
            font-family: ui-sans-serif, system-ui, sans-serif;
            background: #faebd700;
        }

        .rating-label {
            margin-block-end: 1rem;
        }

        /* rating input css end */

        @media screen and (min-width: 579px) and (max-width: 980px) {
            .align-text {
                text-align: center;
            }
        }

        .hover_box {
            font-size: 12px;
        }

        .footer-new-poup a,
        .footer-new-poup button {
            background: #ef6738;
            color: #fff;
            border: 1px solid;
            padding: 7px 20px;
            float: left;
            display: block;
            font-size: small;
            width: 100%;
        }

        /* Flip Card Styles */
        .flip-card {
            background-color: transparent;
            perspective: 1000px;
            cursor: pointer;
            /* Ensure the card itself takes full height if in a flex container */
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: left;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            flex: 1;
            /* Grow to fill */
            display: flex;
            flex-direction: column;
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            width: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 10px;
            /* Optional: maintain border radius if needed */
            display: flex;
            flex-direction: column;
        }

        .flip-card-front {
            background-color: #fff;
            height: 100%;
            /* Ensure it fills the inner container */
            justify-content: space-between;
        }

        .flip-card-back {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #fff;
            color: black;
            transform: rotateY(180deg);
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 15px;
            overflow: hidden;
            /* Scroll if details exceed front face height */
            z-index: 10;
            border: 1px solid #eef0f2;
        }

        .flip-card-front {
            background-color: #fff;
            color: black;
            /* Image is inside here */
        }

        .flip-card-back {
            background-color: #fff;
            color: black;
            transform: rotateY(180deg);
            position: absolute;
            top: 0;
            left: 0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 10px;
            /* Reduced padding */
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            /* Align top since content is long */
            overflow-y: auto;
            /* Allow scroll for long content */
            font-size: 11px;
            /* Smaller text for compact view */
        }

        .flip-card-back h5 {
            font-size: 13px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .flip-card-back ul {
            margin-bottom: 5px;
            padding-left: 15px;
        }

        .flip-card-back .pop-box-text {
            font-size: 10px;
        }

        .flip-card-back button {
            padding: 3px 10px;
            font-size: 10px;
        }

        /* Course Image 4:3 Aspect Ratio */
        .cource-img {
            width: 100%;
            aspect-ratio: 4 / 3;
            overflow: hidden;
            position: relative;
        }

        .cource-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .slick-list {
            overflow: visible !important;
        }
    </style>
    <link href='https://fonts.googleapis.com/css?family=Sansita' rel='stylesheet'>
@endsection
@section('main')
    <?php use Illuminate\Support\Facades\DB; ?>
    <!-- ============================ Hero Banner  Start================================== -->
    <div class="hero_banner image-cover image_bottom h6_bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="simple-search-wrap text-left">
                        <div class="hero_search-2">
                            <h1 class="banner_title mb-4">
                                {{ $result['banner_title_first'] }}<br>{{ $result['banner_title_second'] }}<br><span
                                    style="font-family: 'Sansita'; color: #03B97C;">{{ $result['banner_title_third'] }}</span>
                            </h1>
                            <p class="font-lg mb-4">{{ $result['banner_content'] }}</p>
                            <div class="inline_btn">
                                <a class="btn theme-bg register text-white" href="/login">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="side_block extream_img">
                        <div class="list_crs_img">
                            <img class="img-fluid elsio cirl animate-fl-y"
                                src="{{ url('home/' . $result['banner_attr_image_1']) }}" alt="" />
                            <img class="img-fluid elsio arrow animate-fl-x"
                                src="{{ url('home/' . $result['banner_attr_image_2']) }}" alt="" />
                            <img class="img-fluid elsio moon animate-fl-x"
                                src="{{ url('home/' . $result['banner_attr_image_3']) }}" alt="" />
                        </div>
                        <img class="img-fluid" src="{{ url('home/' . $result['banner_photo']) }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Hero Banner End ================================== -->

    <!-- ============================ Our Awards Start ================================== -->
    <section class="gray p-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="crp_box ovr_top">
                        <div class="row align-items-center m-0">
                            <div class="col-xl-2 col-lg-3 col-md-2 col-sm-12">
                                <div class="crt_169">
                                    <div class="crt_overt style_2">
                                        <h4>4.7</h4>
                                    </div>
                                    <div class="crt_stion">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="crt_io90">
                                        <h6>3,272 Rating</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-9 col-md-10 col-sm-12">
                                <div class="part_rcp">
                                    <ul>
                                        <li>
                                            <div class="dro_140">
                                                <div class="dro_141"><i class="fa fa-layer-group"></i></div>
                                                <div class="dro_142">
                                                    <h6>Innovative Online<br>Education</h6>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dro_140">
                                                <div class="dro_141 st-1"><i class="fa fa-business-time"></i></div>
                                                <div class="dro_142">
                                                    <h6>1 Year Free<br>Subscription</h6>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dro_140">
                                                <div class="dro_141 st-2"><i class="fa fa-user-shield"></i></div>
                                                <div class="dro_142">
                                                    <h6>8000+ Enrolled<br>Students</h6>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dro_140">
                                                <div class="dro_141 st-3"><i class="fa fa-journal-whills"></i></div>
                                                <div class="dro_142">
                                                    <h6>60+ Courses<br>Available</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Our Awards End ================================== -->

    <!-- ============================ Our Best Demanding Start ================================== -->
    <section class="gray min">
        <div class="book-container container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10">
                    <div class="sec-heading center">
                        <h2>{{ $result['subtitle1_first'] }} {{ $result['subtitle1_second'] }} <span
                                class="theme-cl">{{ $result['subtitle1_third'] }}</span></h2>
                        <p>{{ $result['subtitle1_content'] }}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12 only-tow-slider">
                    <div class="best-course space" style="overflow-x:visible;">
                        @if (count($Gn_PackagePackagelist) > 0)
                            @foreach ($Gn_PackagePackagelist as $item)
                                @if ($item->is_featured != '0')
                                    <div class="cource-item book-cource-item flip-card mx-2">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front" style="overflow:hidden;">
                                                <div class="d-flex align-items-center gap-2">
                                                    <p class="academic-title">{{ $item->educationType?->name }}</p>
                                                    <p class="academic-title2">{{ $item->classType?->name }}</p>
                                                </div>
                                                <div class="cource-img">
                                                    @if (isset($item->package_image))
                                                        <img src="/storage/{{ $item->package_image }}" alt="">
                                                    @else
                                                        <img src="{{ asset('noimg.png') }}" alt="">
                                                    @endif
                                                </div>
                                                <div class="course-body">
                                                    <a class="course-category"
                                                        href="#">{{ $item->special_remark_1 }}</a>
                                                    <div class="course-desc">
                                                        <p class="m-0">{{ $item->plan_name }}</p>
                                                    </div>
                                                    <div class="rating-box">
                                                        <span class="rating-pres">{{ $item->student_rating }}</span>
                                                        <input class="rating" type="range" value="2.5"
                                                            style="--value:<?= $item->student_rating ?>" max="5"
                                                            oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                                                            step="0.5">
                                                        <span class="rating-text">(@if ($item->enrol_student_no != null)
                                                                {{ $item->enrol_student_no }}
                                                            @else
                                                                0
                                                            @endif)</span>
                                                    </div>
                                                    <div class="payment-box">
                                                        <span>&#8377; {{ $item->final_fees }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flip-card-back">
                                                <h5>{{ $item->plan_name }}</h5>
                                                <ul>
                                                    @if ($item->total_test != '0')
                                                        <li>&#x2713; {{ $item->total_test }} Test</li>
                                                    @endif
                                                    @if ($item->total_video != '0')
                                                        <li>&#x2713; {{ $item->total_video }} Video/ Live Class</li>
                                                    @endif
                                                    @if ($item->total_notes != '0')
                                                        <li>&#x2713; {{ $item->total_notes }} Study Notes & E-Books</li>
                                                    @endif
                                                    @if ($item->current_affairs_allow != '0')
                                                        <li>&#x2713; {{ $item->current_affairs_allow }} Current Affairs
                                                        </li>
                                                    @endif
                                                    @if ($item->special_remark_1 != '0')
                                                        <li class="mt-2">&#x2713; {{ $item->special_remark_1 }}</li>
                                                    @endif
                                                    @if ($item->special_remark_2 != '0')
                                                        <li class="mb-2">&#x2713; {{ $item->special_remark_2 }}</li>
                                                    @endif

                                                </ul>
                                                <div class="row" style="margin:0px;">
                                                    <div class="col-12 three-sec">
                                                        <p class="pop-box-text">Offer Start: {{ $item->active_date }}</p>
                                                        <p class="pop-box-text pop2-text">Offer End:
                                                            {{ $item->expire_date }}</p>
                                                    </div>
                                                    <div class="col-12 three-sec">
                                                        <p class="pop-box-text">{{ $item->duration }} Days +
                                                            {{ $item->free_duration }} Days (Free)</p>
                                                        <p class="pop-box-text pop2-text">Offer Price:
                                                            {{ $item->package_category }}</p>
                                                    </div>
                                                    <div class="col-12 three-sec">
                                                        <p class="pop-box-text">Actual Price: ₹ {{ $item->actual_fees }}/-
                                                            Only</p>
                                                        <p class="pop-box-text pop2-text">Offer Price: ₹
                                                            {{ $item->final_fees }}/- Only</p>
                                                    </div>
                                                </div>
                                                <div class="footer-new-poup mt-2">
                                                    @if (Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active')
                                                        <a
                                                            href="{{ route('student.package_manage', [$item->id]) }}" class="btn-custom text-center">Start</a>
                                                    @else
                                                        <a href="{{ route('login', ['redirect' => route('student.package_manage', [$item->id])]) }}"
                                                            class="btn-custom text-center">Start</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12 only-tow-slider">
                    <div class="best-course space">
                        @if (count($Gn_PackagePlanInstitute) > 0)
                            @foreach ($Gn_PackagePlanInstitute as $item)
                                @if ($item->is_featured != '0')
                                    <div class="cource-item book-cource-item flip-card mx-2">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front">
                                                <div class="cource-img">
                                                    @if (isset($item->package_image))
                                                        <img src="/storage/{{ $item->package_image }}" alt="">
                                                    @else
                                                        <img src="{{ asset('noimg.png') }}" alt="">
                                                    @endif
                                                </div>
                                                <div class="course-body">
                                                    <a class="course-category"
                                                        href="#">{{ $item->special_remark_1 }}</a>
                                                    <div class="course-desc">
                                                        <p class="m-0">{{ $item->plan_name }}</p>
                                                    </div>
                                                    <div class="rating-box">
                                                        <span class="rating-pres">{{ $item->student_rating }}</span>
                                                        <input class="rating" type="range" value="2.5"
                                                            style="--value:<?= $item->student_rating ?>" max="5"
                                                            oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                                                            step="0.5">
                                                        <span class="rating-text">(@if ($item->enrol_student_no != null)
                                                                {{ $item->enrol_student_no }}
                                                            @else
                                                                0
                                                            @endif)</span>
                                                    </div>
                                                    <div class="payment-box">
                                                        <span>&#8377; {{ $item->final_fees }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flip-card-back">
                                                <h5>{{ $item->plan_name }}</h5>
                                                <ul>
                                                    @if ($item->total_test != '0')
                                                        <li>&#x2713; {{ $item->total_test }} Test</li>
                                                    @endif
                                                    @if ($item->total_video != '0')
                                                        <li>&#x2713; {{ $item->total_video }} Video/ Live Class</li>
                                                    @endif
                                                    @if ($item->total_notes != '0')
                                                        <li>&#x2713; {{ $item->total_notes }} Study Notes & E-Books</li>
                                                    @endif
                                                    @if ($item->current_affairs_allow != '0')
                                                        <li>&#x2713; {{ $item->current_affairs_allow }} Current Affairs
                                                        </li>
                                                    @endif
                                                    @if ($item->special_remark_1 != '0')
                                                        <li>&#x2713; {{ $item->special_remark_1 }}</li>
                                                    @endif
                                                    @if ($item->special_remark_2 != '0')
                                                        <li>&#x2713; {{ $item->special_remark_2 }}</li>
                                                    @endif
                                                </ul>
                                                <div class="row">
                                                    <div class="col-12 three-sec">
                                                        <p class="pop-box-text">Offer Start: {{ $item->active_date }}</p>
                                                        <p class="pop-box-text pop2-text">Offer End:
                                                            {{ $item->expire_date }}</p>
                                                    </div>
                                                    <div class="col-12 three-sec">
                                                        <p class="pop-box-text">{{ $item->duration }} Days +
                                                            {{ $item->free_duration }} Days (Free)</p>
                                                        <p class="pop-box-text pop2-text">Offer Price:
                                                            {{ $item->package_category }}</p>
                                                    </div>
                                                    <div class="col-12 three-sec">
                                                        <p class="pop-box-text">Actual Price: ₹ {{ $item->actual_fees }}/-
                                                            Only</p>
                                                        <p class="pop-box-text pop2-text">Offer Price: ₹
                                                            {{ $item->final_fees }}/- Only</p>
                                                    </div>
                                                </div>
                                                <div class="footer-new-poup mt-2">
                                                    @if (Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active')
                                                        <a
                                                            href="{{ route('student.package_manage', [$item->id]) }}"><button>Start</button></a>
                                                    @else
                                                        <a href="{{ route('login', ['redirect' => route('student.package_manage', [$item->id])]) }}"
                                                            class="btn-custom">{{ $item->permission_to_download }}</a>
                                                    @endif
                                                    <div class="like-bt">
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ Our Best Demanding End ================================== -->

    <!-- ============================ Our Best Academic & Academics Start ================================== -->
    <section class="min">
        <div class="book-container container">

            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10">
                    <div class="sec-heading center">
                        <h2>{{ $result['subtitle2_first'] }} {{ $result['subtitle2_second'] }} <span class="theme-cl">
                                {{ $result['subtitle2_third'] }}</span></h2>
                        <p>{{ $result['subtitle2_content'] }}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12 only-tow-slider">
                    <div class="best-course space">
                        <!--@if ($result['competitive_courses_status'] == 1)-->
                        @if (count($Gn_PackagePlanGyanology) > 0)
                            @foreach ($Gn_PackagePlanGyanology as $item)
                                <div class="cource-item book-cource-item flip-card mx-2">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front">
                                            <div class="d-flex align-items-center gap-2">
                                                <p class="academic-title">{{ $item->classType?->name }}</p>
                                                <p class="academic-title2">{{ $item->educationType?->name }}</p>
                                            </div>
                                            <div class="cource-img">
                                                @if (isset($item->package_image))
                                                    <img src="/storage/{{ $item->package_image }}" alt="">
                                                @else
                                                    <img src="{{ asset('noimg.png') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="course-body">
                                                <a class="course-category"
                                                    href="#">{{ $item->special_remark_1 }}</a>
                                                <div class="course-desc">
                                                    <p class="m-0">{{ $item->plan_name }}</p>
                                                </div>
                                                <div class="rating-box">
                                                    <span class="rating-pres">{{ $item->student_rating }}</span>
                                                    <input class="rating" type="range" value="2.5"
                                                        style="--value:<?= $item->student_rating ?>" max="5"
                                                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                                                        step="0.5">
                                                    <span class="rating-text">({{ $item->enrol_student_no }})</span>
                                                </div>
                                                <div class="payment-box">
                                                    <span>&#8377; {{ $item->final_fees }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flip-card-back">
                                            <h5>{{ $item->plan_name }}</h5>
                                            <ul>
                                                <li>{{ $item->total_test }} Test</li>
                                                <li>{{ $item->total_video }} Video/ Live Class</li>
                                                <li>{{ $item->current_affairs_allow }}</li>
                                                <li>{{ $item->special_remark_1 }}</li>
                                                <li>{{ $item->special_remark_2 }}</li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-12 three-sec">
                                                    <p class="pop-box-text">Offer Start: {{ $item->active_date }}</p>
                                                    <p class="pop-box-text pop2-text">Offer End: {{ $item->expire_date }}
                                                    </p>
                                                </div>
                                                <div class="col-12 three-sec">
                                                    <p class="pop-box-text">{{ $item->duration }} Days +
                                                        {{ $item->free_duration }} Days (Free)</p>
                                                    <p class="pop-box-text pop2-text">Offer Price:
                                                        {{ $item->package_category }}</p>
                                                </div>
                                                <div class="col-12 three-sec">
                                                    <p class="pop-box-text">Actual Price: ₹ {{ $item->actual_fees }}/-
                                                        Only</p>
                                                    <p class="pop-box-text pop2-text">Offer Price: ₹
                                                        {{ $item->final_fees }}/- Only</p>
                                                </div>
                                            </div>
                                            <div class="footer-new-poup mt-2">
                                                @if (Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active')
                                                    <a
                                                        href="{{ route('student.package_manage', [$item->id]) }}"><button>Start</button></a>
                                                @else
                                                    <a href="{{ route('login', ['redirect' => route('student.package_manage', [$item->id])]) }}"
                                                        class="btn-custom">Start</a>
                                                @endif
                                                <div class="like-bt">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <!--@endif-->
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12 only-tow-slider">
                    <div class="best-course space">
                        @if (count($Gn_PackagePlanGyanology2) > 0)
                            @foreach ($Gn_PackagePlanGyanology2 as $item)
                                <div class="cource-item book-cource-item flip-card mx-2">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front">
                                            <div class="d-flex align-items-center gap-2">
                                                <p class="academic-title">{{ $item->classType?->name }}</p>
                                                <p class="academic-title2">{{ $item->educationType?->name }}</p>
                                            </div>
                                            <div class="cource-img">
                                                @if (isset($item->package_image))
                                                    <img src="/storage/{{ $item->package_image }}" alt="">
                                                @else
                                                    <img src="{{ asset('noimg.png') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="course-body">
                                                <a class="course-category"
                                                    href="#">{{ $item->special_remark_1 }}</a>
                                                <div class="course-desc">
                                                    <p class="m-0">{{ $item->plan_name }}</p>
                                                </div>
                                                <div class="rating-box">
                                                    <span class="rating-pres">{{ $item->student_rating }}</span>
                                                    <input class="rating" type="range" value="2.5"
                                                        style="--value:<?= $item->student_rating ?>" max="5"
                                                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                                                        step="0.5">
                                                    <span class="rating-text">({{ $item->enrol_student_no }})</span>
                                                </div>
                                                <div class="payment-box">
                                                    <span>&#8377; {{ $item->final_fees }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flip-card-back">
                                            <h5>{{ $item->plan_name }}</h5>
                                            <ul>
                                                <li>{{ $item->total_test }} Test</li>
                                                <li>{{ $item->total_video }} Video/ Live Class</li>
                                                <li>{{ $item->current_affairs_allow }}</li>
                                                <li>{{ $item->special_remark_1 }}</li>
                                                <li>{{ $item->special_remark_2 }}</li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-12 three-sec">
                                                    <p class="pop-box-text">Offer Start: {{ $item->active_date }}</p>
                                                    <p class="pop-box-text pop2-text">Offer End: {{ $item->expire_date }}
                                                    </p>
                                                </div>
                                                <div class="col-12 three-sec">
                                                    <p class="pop-box-text">{{ $item->duration }} Days +
                                                        {{ $item->free_duration }} Days (Free)</p>
                                                    <p class="pop-box-text pop2-text">Offer Price:
                                                        {{ $item->package_category }}</p>
                                                </div>
                                                <div class="col-12 three-sec">
                                                    <p class="pop-box-text">Actual Price: ₹ {{ $item->actual_fees }}/-
                                                        Only</p>
                                                    <p class="pop-box-text pop2-text">Offer Price: ₹
                                                        {{ $item->final_fees }}/- Only</p>
                                                </div>
                                            </div>
                                            <div class="footer-new-poup mt-2">
                                                @if (Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active')
                                                    <a
                                                        href="{{ route('student.package_manage', [$item->id]) }}"><button>Start</button></a>
                                                @else
                                                    <a href="{{ route('login', ['redirect' => route('student.package_manage', [$item->id])]) }}"
                                                        class="btn-custom">Start</a>
                                                @endif
                                                <div class="like-bt">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="clearfix"></div>
    <!-- ============================ Our Best Academic & Academics End ================================== -->

    <!-- ============================ Live & Video Class Start ================================ -->
    @if ($result['range_of_courses_status'] == 1)
        <section class="main min gray">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-10 text-center">
                        <div class="sec-heading center mb-4">
                            <h2>{{ $result['subtitle3_first'] }} {{ $result['subtitle3_second'] }} <span
                                    class="theme-cl"> {{ $result['subtitle3_third'] }}</span></h2>
                            <p>{{ $result['subtitle3_content'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="video-ebooks-pdf space regular-new1 slider">
                            @if (count($StudymaterialGovComp4) > 0)
                                @foreach ($StudymaterialGovComp4 as $item)
                                    <div class="cource-item m-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="academic-title">{{ $item->title }}</p>
                                            <p class="academic-title2">{{ $item->education_type_name }}</p>
                                        </div>
                                        <div class="cource-img">
                                            @php
                                                $video_link = $item->video_link;
                                                $video_link = str_replace(
                                                    'youtu.be/',
                                                    'www.youtube.com/embed/',
                                                    $video_link,
                                                );
                                            @endphp
                                            <iframe src="{{ $video_link }}" title="YouTube video player"
                                                width="100%" height="200px" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                            <!--<iframe src="https://www.youtube.com/embed/RnKlNbI3dmw" title="YouTube video player" width="100%" height="200px" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                                        </div>
                                        <div class="course-body">
                                            <p class="book-text">
                                                @if (isset($item->study_material_image))
                                                    <img src="/storage/{{ $item->study_material_image }}">
                                                @else
                                                    <img src="{{ asset('logos/logo-white-square.png') }}">
                                                @endif
                                                <span>{{ $item->sub_title }}</span>
                                            </p>
                                            <p class="book-heding">{{ $item->class_name }}</p>
                                            <span class="mini-text">{{ $item->material_remark_1 }}</span>
                                            <div class="rating-box">
                                                <ul>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star-half" aria-hidden="true"></i></li>
                                                </ul>
                                                <span class="rating-text">{{ $item->student_rating }} |
                                                    {{ $item->total_student }} Enrolled</span>
                                                <div class="like-bt">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- ============================ Live & Video Class End ================================ -->

    <!-- ============================ Academics Special Live Start ================================ -->
    <section class="main min">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2>{{ $result['subtitle4_first'] }} {{ $result['subtitle4_second'] }} <span class="theme-cl">
                                {{ $result['subtitle4_third'] }}</span></h2>
                        <p>{{ $result['subtitle4_content'] }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="video-ebooks-pdf space regular-new1 slider">
                        @if (count($StudymaterialGovComp5) > 0)
                            @foreach ($StudymaterialGovComp5 as $item)
                                <div class="cource-item m-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <p class="academic-title">{{ $item->title }}</p>
                                        <p class="academic-title2">{{ $item->education_type_name }}</p>
                                    </div>
                                    <div class="cource-img">
                                        @php
                                            $video_link = $item->video_link;
                                            $video_link = str_replace(
                                                'youtu.be/',
                                                'www.youtube.com/embed/',
                                                $video_link,
                                            );
                                        @endphp
                                        <iframe src="{{ $video_link }}" title="YouTube video player" width="100%"
                                            height="200px" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                        <!--<iframe src="https://www.youtube.com/embed/RnKlNbI3dmw" title="YouTube video player" width="100%" height="200px" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                                    </div>
                                    <div class="course-body">
                                        <p class="book-text">
                                            @if (isset($item->study_material_image))
                                                <img src="/storage/{{ $item->study_material_image }}">
                                            @else
                                                <img src="{{ asset('logos/logo-white-square.png') }}">
                                            @endif
                                            <span>{{ $item->sub_title }}</span>
                                        </p>
                                        <p class="book-heding">{{ $item->class_name }}</p>
                                        <span class="mini-text">{{ $item->material_remark_1 }}</span>
                                        <div class="rating-box">
                                            <ul>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star-half" aria-hidden="true"></i></li>
                                            </ul>
                                            <span class="rating-text">{{ $item->student_rating }} |
                                                {{ $item->total_student }} Enrolled</span>
                                            <div class="like-bt">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Academics Special Live End ================================ -->

    <!-- ============================ Comprehensive Notes Start ================================ -->
    <section class="gray min">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2>Govt Job & Competitive Entrance Live & <span class="theme-cl"> Online Classes By Top
                                Classroom Instructor</span></h2>
                        <p>{{ $result['subtitle5_content'] }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="video-ebooks-pdf space regular-new1 slider">
                        @if (count($StudymaterialGovComp) > 0)
                            @foreach ($StudymaterialGovComp as $item)
                                @if ($item->video_link)
                                    <div class="cource-item m-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="academic-title">{{ $item->title }}</p>
                                            <p class="academic-title2">{{ $item->education_type_name }}</p>
                                        </div>
                                        <div class="cource-img">
                                            @php
                                                $video_link = $item->video_link;
                                                $video_link = str_replace(
                                                    'youtu.be/',
                                                    'youtube.com/embed/',
                                                    $video_link,
                                                );
                                            @endphp
                                            <iframe src="{{ $video_link }}" title="YouTube video player"
                                                width="100%" height="200px" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                            <!--<iframe src="https://www.youtube.com/embed/RnKlNbI3dmw" title="YouTube video player" width="100%" height="200px" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                                        </div>
                                        <div class="course-body">
                                            <p class="book-text">
                                                @if (isset($item->study_material_image))
                                                    <img src="/storage/{{ $item->study_material_image }}">
                                                @else
                                                    <img src="{{ asset('logos/logo-white-square.png') }}">
                                                @endif
                                                <span>{{ $item->sub_title }}</span>
                                            </p>
                                            <p class="book-heding">{{ $item->class_name }}</p>
                                            <span class="mini-text">{{ $item->material_remark_1 }}</span>
                                            <div class="rating-box">
                                                <ul>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <li><i class="fa fa-star-half" aria-hidden="true"></i></li>
                                                </ul>
                                                <span class="rating-text">{{ $item->student_rating }} |
                                                    {{ $item->total_student }} Enrolled</span>
                                                <div class="like-bt">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gray min">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2>{{ $result['subtitle5_first'] }} {{ $result['subtitle5_second'] }} <span class="theme-cl">
                                {{ $result['subtitle5_third'] }}</span></h2>
                        <p>{{ $result['subtitle5_content'] }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="ebooks-pdf space book-caver">
                        @if (count($StudymaterialGovComp) > 0)
                            @foreach ($StudymaterialGovComp as $item)
                                @if (!$item->video_link)
                                    <div class="cource-item mx-3">
                                        <div class="cource-img">
                                            @if (isset($item->study_material_image))
                                                <img src="/storage/{{ $item->study_material_image }}" alt="">
                                            @else
                                                <img src="{{ asset('images/static/pdf-icon.jpeg') }}" alt="">
                                            @endif
                                        </div>
                                        <div class="course-body">
                                            <p class="book-text"><b>{{ $item->title }}</b></p>
                                            <p class="book-heding">{{ $item->sub_title }}</p>
                                            <span class="mini-text">{{ $item->material_remark_1 }}</span>
                                            <div class="rating-box">
                                                <ul>
                                                    @php
                                                        $floatValue = $item->student_rating;
                                                        $intValue = intval($floatValue);
                                                        if ($intValue == 0) {
                                                            $intValue = 5;
                                                        }
                                                    @endphp

                                                    @if ((int) $floatValue == $floatValue)
                                                        @for ($i = 1; $i <= $intValue; $i++)
                                                            <li><i class="fa fa-star" aria-hidden="true"
                                                                    style="font-size:12px;"></i></li>
                                                        @endfor
                                                    @else
                                                        @for ($i = 1; $i <= $intValue; $i++)
                                                            <li><i class="fa fa-star" aria-hidden="true"
                                                                    style="font-size:12px;"></i></li>
                                                        @endfor
                                                        <li><i class="fa fa-star-half" aria-hidden="true"
                                                                style="font-size:12px;"></i></li>
                                                    @endif

                                                </ul>
                                                @if ($item->total_student != null)
                                                    <span class="rating-text"
                                                        style="margin:0px;">({{ $item->total_student }})</span>
                                                @endif
                                            </div>
                                            <div class="row"> <!-- payment-box-->
                                                <div class="col-12" style="">
                                                    @if (isset($item->price))
                                                        <span>{{ $item->price }}</span>
                                                    @else
                                                        @if ($item->remarks)
                                                            <span class="mt-2">&#x2713; {{ $item->remarks }}</span>
                                                        @endif
                                                        @if ($item->other_remark)
                                                            <br /><span class="mb-2">&#x2713;
                                                                {{ $item->other_remark }}</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="col-12 like-bt footer-new-poup"
                                                    style="float:right; line-height:unset; padding:0px;">
                                                    @php
                                                        $file = $item->file;
                                                        $fileName = Str::afterLast($file, '/');
                                                    @endphp

                                                    @if (Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active')
                                                        <a href="{{ url('storage/' . $item->file) }}"
                                                            tabindex="0" target="_blank"><button tabindex="0"
                                                                style="width:100%; padding: 0px; font-size: 16px">{{ $item->permission_to_download }}</button></a>
                                                    @else
                                                        @if ($fileName)
                                                            <a href="{{ route('login', ['redirect' => url('storage/' . $item->file)]) }}"
                                                                style="width:100%; padding: 0px 10px; font-size: 16px; display:inline-block; text-align:center;" target="_blank">{{ $item->permission_to_download }}</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Comprehensive Notes End ================================ -->

    <!-- ============================ Current Affairs Start ================================ -->
    <section class="min">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2>{{ $result['subtitle6_first'] }} {{ $result['subtitle6_second'] }} <span class="theme-cl">
                                {{ $result['subtitle6_third'] }}</span></h2>
                        <p>{{ $result['subtitle6_content'] }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="ebooks-pdf space book-caver">
                        @if (count($StudymaterialGovComp2) > 0)
                            @foreach ($StudymaterialGovComp2 as $item)
                                <div class="cource-item mx-3">
                                    <div class="pdf-img">
                                        @if (isset($item->study_material_image))
                                            <img src="/storage/{{ $item->study_material_image }}" alt=""
                                                width="180px" height="280px">
                                        @else
                                            <img src="{{ asset('images/static/pdf-icon.jpeg') }}" alt=""
                                                width="180px" height="280px">
                                        @endif
                                    </div>
                                    <div class="course-body">
                                        <p class="book-text"><b>{{ $item->title }}</b></p>
                                        <p class="book-heding">{{ $item->sub_title }}</p>
                                        <span class="mini-text">Lorem ipsum</span>
                                        <div class="footer-new-poup mt-1">
                                            @php
                                                $file = $item->file;
                                                $fileName = Str::afterLast($file, '/');
                                            @endphp

                                            @if (Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active')
                                                <a href="{{ url('storage/' . $item->file) }}"
                                                    tabindex="0" target="_blank"><button tabindex="0"
                                                        style="width:100%; padding: 0px; font-size: 16px;font-size: small;">{{ $item->permission_to_download }}</button></a>
                                            @else
                                                <a href="{{ route('login', ['redirect' => url('storage/' . $item->file)]) }}"
                                                    style="font-size: small;" target="_blank">{{ $item->permission_to_download }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Current Affairs End ================================ -->

    <!-- ============================ Current Affairs Start ================================ -->
    <section class="gray min">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2>{{ $result['subtitle7_first'] }} {{ $result['subtitle7_second'] }} <span
                                class="theme-cl">{{ $result['subtitle7_third'] }}</span></h2>
                        <p>{{ $result['subtitle7_content'] }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="ebooks-pdf space book-caver">
                        @if (count($StudymaterialGovComp3) > 0)
                            @foreach ($StudymaterialGovComp3 as $item)
                                <div class="cource-item mx-3">
                                    <div class="pdf-img">
                                        @if (isset($item->study_material_image))
                                            <img src="/storage/{{ $item->study_material_image }}" alt=""
                                                style="width:180px; height:280px">
                                        @else
                                            <img src="{{ asset('images/static/pdf-icon.jpeg') }}" alt=""
                                                style="width:180px; height:280px">
                                        @endif
                                    </div>
                                    <div class="course-body">
                                        <p class="book-text"><b>{{ $item->title }}</b></p>
                                        <p class="book-heding">{{ $item->sub_title }}</p>
                                        <span class="mini-text">Lorem ipsum</span>
                                        <div class="footer-new-poup mt-1">
                                            <!-- <button tabindex="0">View</button> -->
                                            @php
                                                $file = $item->file;
                                                $fileName = Str::afterLast($file, '/');
                                            @endphp

                                            @if (Auth::check() && Auth::user()->isAdminAllowed == 0 && Auth::user()->is_franchise == 0 && Auth::user()->is_staff == 0 && Auth::user()->status == 'active')
                                                <a href="{{ url('storage/' . $item->file) }}"
                                                    tabindex="0" target="_blank"><button tabindex="0"
                                                        style="width:100%; padding: 0px; font-size: 16px; font-size: small;">{{ $item->permission_to_download }}</button></a>
                                            @else
                                                <a href="{{ route('login', ['redirect' => url('storage/' . $item->file)]) }}"
                                                    style="font-size: small;" target="_blank">{{ $item->permission_to_download }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================ Students Reviews ================================== -->
    <section class="min">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8">
                    <div class="sec-heading center">
                        <h2>What Student Are saying about <span class="theme-cl">Test&Notes.Com</span></h2>
                        <p>We appreciate the views of each student about our educational system as well as we provide them.
                            No matter what they are saying about us. We always encourage them to fair reviews about us.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                    <div class="edu_cat_2 review-first-block-color row align-text m-0 mb-4">
                        <div class="d-flex">
                            <div class="w-25 text-center">
                                <img class="img-fluid rounded-circle" src="https://www.w3schools.com/w3images/avatar2.png"
                                    alt="" width="100" height="100">
                                <div class="mt-1 text-center">
                                    <div class="review-font-size">Student Name</div>
                                    <div class="review-font-size">SSC-CGL</div>
                                    <div class="review-font-size">City Name</div>
                                </div>
                            </div>
                            <div class="w-75 d-flex justify-content-center align-items-center m-2 text-center">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form, by injected humour, or randomised words which don't look
                                even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                    <div class="edu_cat_2 review-second-block-color row align-text m-0 mb-4">
                        <div class="d-flex">
                            <div class="w-25 text-center">
                                <img class="img-fluid rounded-circle" src="https://www.w3schools.com/w3images/avatar2.png"
                                    alt="" width="100" height="100">
                                <div class="mt-1 text-center">
                                    <div class="review-font-size">Student Name</div>
                                    <div class="review-font-size">SSC-CGL</div>
                                    <div class="review-font-size">City Name</div>
                                </div>
                            </div>
                            <div class="w-75 d-flex justify-content-center align-items-center m-2 text-center">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form, by injected humour, or randomised words which don't look
                                even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                    <div class="edu_cat_2 review-third-block-color row align-text m-0 mb-4">
                        <div class="d-flex">
                            <div class="w-25 text-center">
                                <img class="img-fluid rounded-circle" src="https://www.w3schools.com/w3images/avatar2.png"
                                    alt="" width="100" height="100">
                                <div class="mt-1 text-center">
                                    <div class="review-font-size">Student Name</div>
                                    <div class="review-font-size">SSC-CGL</div>
                                    <div class="review-font-size">City Name</div>
                                </div>
                            </div>
                            <div class="w-75 d-flex justify-content-center align-items-center m-2 text-center">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form, by injected humour, or randomised words which don't look
                                even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Students Reviews End ================================== -->

    <!-- ============================ Brand & Institutes Start ================================ -->
    <hr>
    <section class="min">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2>Our Excellent Contributors Who Make Us Proud With <span class="theme-cl">Great
                                Selections</span></h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="video-ebooks-pdf space">
                        {{-- {{ $result['slider_footer_image'] }} --}}
                        @foreach (json_decode($result['slider_footer_image']) as $list)
                            <img class="mx-3" src="{{ url('home/slider/' . $list) }}" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Brand & Institutes End ================================ -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var classes = ["cat-1", "cat-2", "cat-3", "cat-4", "cat-5", "cat-6"];
            var classes2 = ["cat-1", "cat-2", "cat-3", "cat-4", "cat-5", "cat-6"];

            $("#plan_login").click(function() {
                var dataDashboardValue = $("#plan_login").data("dashboard");
                //alert(dataDashboardValue);
                $("#plan_input").html("<input type='hidden' name='planclick' value='" + dataDashboardValue +
                    "'>");
            });

            $(".section-2").each(function() {
                const className = classes.splice(~~(Math.random() * classes.length), 1)[0]
                $(this).addClass(className);
                const element = $(this).parent().children()[1];
                $(element).addClass(className);
            });

            $(".section-1").each(function() {
                const className = classes2.splice(~~(Math.random() * classes2.length), 1)[0]
                $(this).addClass(className);
                const element = $(this).parent().children()[1];
                $(element).addClass(className);
            });

            $('.counter').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 200000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });

            // $('.book-cource-item').hover(function() {
            //     addRightTooltip('book-cource-item')
            // });

            // $('.book-cource-item-2').hover(function() {
            //     addRightTooltip('book-cource-item-2')
            // });

            const addRightTooltip = (selector) => {
                const elements = $('.' + selector + '.slick-active')
                const lastElement = elements[elements.length - 1]
                const lastChildren = $(lastElement).children().last()[0];
                $(lastChildren).removeClass('course-hover-box')
                $(lastChildren).addClass('course-hover-box-right')
            }

            const removeRightTooltip = (selector) => {
                const elements = $('.' + selector + '.slick-active')
                const lastElement = elements[elements.length - 1]
                const lastChildren = $(lastElement).children().last()[0];
                $(lastChildren).removeClass('course-hover-box-right')
                $(lastChildren).addClass('course-hover-box')
            }
        });
    </script>
@endsection
