@extends('Layouts.frontend')

@section('css')

@endsection
@section('main')

<!-- ============================ Page Title Start================================== -->
<div class="ed_detail_head">
    <div class="container">
        <div class="row align-items-center" style="flex-wrap: nowrap;display: flex;flex-direction: row;">
            
            <div class="col-lg-8 col-md-7">
                <div class="ed_detail_wrap">
                    <!-- <div class="crs_cates cl_1"><span>Design</span></div><div class="crs_cates cl_3"><span>Design</span></div> -->
                    <div class="ed_header_caption">
                        <h2 class="ed_title">{{ $data['test_question_paper']->title }} Question Paper</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================ Page Title End ================================== -->
<!-- ============================ Course Detail ================================== -->
<section class="gray" style="padding-top: 25px;">
    <div class="container">
        <div class="row">
        
            <div class="col-lg-8 col-md-12 order-lg-first">
                
                <!-- Overview -->
                @foreach($data['test_question_paper']->getSection as $i => $section)
                    @foreach($section->getQuestions()->wherePivot('deleted_at','=',NULL)->get() as $j => $questions)
                    <div class="edu_wraper test-questions">
                        <h3 class="edu_title">Question Number {{ $j+=1 }}</h3>
                        <p>{!! $questions->question !!}</p>		
                        <ul class="lists lists-4">
                            @for($k=1; $k <= $questions->mcq_options; $k++)
                                <li>
                                    <label for="answer_{{ $i }}_{{ $j }}_{{ $k }}" class="checkbox-custom-label">{!! $questions['ans_'.$k] !!}</label>
                                </li>
                            @endfor
                        </ul>
                    </div>
                    @endforeach
                @endforeach
                
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-12 order-lg-last">
                <div class="ed_view_box style_2 stick_top">
                    <div class="ed_view_link" style="padding-top:10px;">
                        <!-- <a href="#" class="btn theme-light enroll-btn">Question Paper<i class="ti-angle-right"></i></a> -->
                        <a href="{{ url()->previous() }}" class="btn theme-bg enroll-btn">Back to Test<i class="ti-angle-right"></i></a>
                    </div>    
                </div>	
            </div>
        </div>
    </div>
</section>
<!-- ============================ Course Detail ================================== -->


@endsection

@section('js')

@endsection