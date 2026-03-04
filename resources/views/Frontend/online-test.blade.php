@extends('Layouts.frontend')

@section('css')
    <style>
        .counter-box img {
            width: auto;
        }

        .testimonials .cource-item, 
        .books .cource-item {
            border: 0 !important;
        }

    </style>
@endsection
@section('main')

<!-- ============================ Page Title Start================================== -->
<!-- <div class="ed_detail_head bg-cover" style="background:#f8f8f8" data-overlay="8">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-7">
                <div class="ed_detail_wrap light">
                    <div class="ed_header_caption">
                        <h2 class="ed_title">{{ $data['test']->title }}</h2>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- ============================ Page Title End ================================== -->
<!-- ============================ Course Detail ================================== -->

<section class="gray pt-3">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-8 col-md-12 order-lg-first">
                <!-- Overview Detail -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <!-- Overview -->
                    <div class="edu_wraper">
                        <h2 class="ed_title">{{ $data['test']->title }}</h2>
                        <h4 class="ed_title">{{ 'Duration: ' }}{{ $data['test_duration'] }}{{ ' minutes' }} | {{ $data['test']->sections }}{{ ' sections' }} | {{ $data['test']->total_questions }}{{ ' Questions' }}</h4>
                        <!-- <div class="sec-viw-1">
                            <div>
                                <h6>Education Type</h6>
                                    <p>Education type here</p>
                                <h6>Class Group</h6>
                                    <p>Class here</p>
                                <h6>Recommended Board</h6>
                                    <p>Boards here</p>
                            </div>
                            <div>
                                <h6>Marks per Question</h6>
                                    <p>Marks per Question here</p>
                                <h6>Negative Marks per Questions</h6>
                                    <p>Negative Marks per Questions here</p>
                                <h6>Total Questions</h6>
                                    <p>Total Questions here</p>
                            </div>
                        </div>
                        
                        <h6>Requirements</h6>
                        <ul class="simple-list p-0">
                            <li>At vero eos et accusamus et iusto odio dignissimos ducimus</li>
                            <li>At vero eos et accusamus et iusto odio dignissimos ducimus</li>
                            <li>At vero eos et accusamus et iusto odio dignissimos ducimus</li>
                            <li>At vero eos et accusamus et iusto odio dignissimos ducimus</li>
                            <li>At vero eos et accusamus et iusto odio dignissimos ducimus</li>
                        </ul> -->
                    </div>
                   
                            
                    <!-- Overview -->
                    <div class="edu_wraper">
                    <h2 class="edu_title">Instructions</h2>
                    <p>1. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                    <p>2. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                    <ul class="no-ul-list">
                        <li>
                            <input id="terms_and_condition" class="checkbox-custom" name="terms_and_condition" type="checkbox" value="0">
                            <label for="terms_and_condition" class="checkbox-custom-label">I agree to all terms & conditions</label>
                        </li>
                        <li>
                            <input id="privacy_policy" class="checkbox-custom" name="privacy_policy" type="checkbox" value="0">
                            <label for="privacy_policy" class="checkbox-custom-label">I accept privacy policy</label>
                        </li>
                    </ul>
                    <!-- <h4 class="edu_title">Sections</h4>
                        @foreach($data['test']->getSection as $key => $section)
                            <h5 class="edu_title">{{ $section->sectionSubject->name }}</h5>
                            <ul class="lists-3 row">
                                <li class="col-xl-4 col-lg-6 col-md-6 m-0">{{ $section->sectionSubjectPart->name }}</li>
                                <li class="col-xl-4 col-lg-6 col-md-6 m-0">{{ $section->sectionSubjectLesson->name }}</li>
                                <li class="col-xl-4 col-lg-6 col-md-6 m-0">{{ $section->question_type == '1' ? 'MCQ' : 'Text' }}</li>
                                <li class="col-xl-4 col-lg-6 col-md-6 m-0">{{ $section->number_of_questions }}{{ ' Questions' }}</li>
                                <li class="col-xl-4 col-lg-6 col-md-6 m-0">{{ $section->duration }}{{ ' minutes per question' }}</li>
                            </ul></br>
                        @endforeach -->
                        <!-- <h5 class="edu_title">Main Subject 1</h5>
                        <ul class="lists-3 row">
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Subject Part</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Chapter/Lesson</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Type of Questions</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">No of questions</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Duration (per Question)</li>
                        </ul></br>
                        <h5 class="edu_title">Main Subject 2</h5>
                        <ul class="lists-3 row">
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Subject Part</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Chapter/Lesson</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Type of Questions</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">No of questions</li>
                            <li class="col-xl-4 col-lg-6 col-md-6 m-0">Duration (per Question)</li>
                        </ul> -->
                    </div>
                </div>
            </div>

        <!-- Sidebar -->
            <div class="col-lg-4 col-md-12  order-lg-last">
                
                <!-- Course info -->
                <div class="ed_view_box style_3 ovrlio stick_top">
                
                    <div class="property_video sm">
                        <div class="thumb">
                            <img class="pro_img img-fluid w100" src="{{ '/storage/'.$data['user_data']->photo_url }}" alt="7.jpg">
                            <!-- <div class="overlay_icon">
                                <div class="bb-video-box">
                                    <div class="bb-video-box-inner">
                                        <div class="bb-video-box-innerup">
                                            <a href="https://www.youtube.com/watch?v=A8EI6JaFbv4" data-toggle="modal" data-target="#popup-video" class="theme-cl"><i class="ti-control-play"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="edu_wraper">
                        <h2 class="ed_title">{{ auth()->user()->name }}</h2>
                    <div class="ed_view_link">
                        <!-- <a href="#" class="btn theme-light enroll-btn">Start Test<i class="ti-angle-right"></i></a> -->
                        <a href="javascript:void(0)" class="btn theme-bg enroll-btn" id="start_test" disabled="disabled">Start Test<i class="ti-angle-right"></i></a>
                    </div>
                    
                </div>
            </div>
        
        </div>
    </div>
</section>
<!-- ============================ Course Detail ================================== -->

@endsection

@section('js')
<script>
    $(document).ready(()=>{

        var terms_and_condition = 0;
        var privacy_policy      = 0;
        $('input:checkbox[name="terms_and_condition"]').click(function(){
            // console.log($(this).prop("checked") == true); 
            if($(this).prop("checked") == true){
                terms_and_condition = 1;
            }
            else if($(this).prop("checked") == false){
                terms_and_condition = 0;
            }
        });

        $('input:checkbox[name="privacy_policy"]').click(function(){
            if($(this).prop("checked") == true){
                privacy_policy = 1;
            }
            else if($(this).prop("checked") == false){
                privacy_policy = 0;
            }
        });

        $("#start_test").click(()=>{

            if (terms_and_condition == 1 && privacy_policy == 1) {
                $('#start_test').removeAttr('href','javascript:void(0)');
                $('#start_test').attr('href','{{ route('start-test',[$data['test']->id]) }}');
            }
            else{
                $('#start_test').removeAttr('href','{{ route('start-test',[$data['test']->id]) }}');
                $('#start_test').attr('href','javascript:void(0)');
                if (terms_and_condition == 0) {
                    alert('please accept the terms and condition...');
                }
                if (privacy_policy == 0) {
                    alert('please accept the privacy policy...');
                    
                }
            }
        });
    })
</script>
@endsection