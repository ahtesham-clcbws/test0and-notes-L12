@extends('Layouts.frontend')

@section('css')
<style>
    .number-que-list{
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
    .number-que-list>.active>span {
        background-color: #03b97c;
        color: #fff;
    }
    .number-que-list>.inactive>span {
        background-color: #700404;
        color: #fff;
    }
    .number-que-list>.incomplete>span {
        background-color: #CDF7C3 ;
        color: #fff;
    }
    .number-que-list>.mark-review>span {
        background-color: #e8741c;
        color: #fff;
    }
	.number-que-list>.incorrect>span {
        background-color: #F64B2F;
        color: #fff;
    }
	.number-que-list>.not-attempt>span {
        background-color: #B4B1AD;
        color: #fff;
    }
    .counter{
        display:flex;
        color: #fff;
    }
    .counter>div{
        padding: 10px;
        border-radius: 3px;
        display: inline-block;
    }
    .counter>div>span{
        padding: 9px;
        font-size: 20px;
        width: 45px;
        border-radius: 3px;
        background: #03b97c;
        display: inline-block;
    }
    .fa-star{
        position: absolute;
        visibility: hidden;
        left: 7px;
        top: -4px;
        color: orange;
    }

    /* The Modal (background) */
    .modal-loc {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
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
        width:40%;
        height:40%;
        max-width: 300px;
        cursor: pointer;
    }
    /* .modal-container>p{
        text-align:center;
    }
    .modal-container>img{
    align-content:center;
    } */
    .modal-container{
        float:none;
        width: 30%;
        display: block;
        align-content: center;
        text-align: center;
    }
	.no-ul-list > .right{
		/* list-style: circle; */
		background-color: #03b91147;
	}

	.no-ul-list > .wrong{
		/* list-style: circle; */
		background-color: #b9460352;
	}
</style>
@endsection

@section('main')


<section class="gray" style="padding-top: 25px;">
    <div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-12 order-lg-first">
				<!-- <div class="modalloc-content" > -->
					<!-- <div class="col-md-12"> -->
						<div class="ed_view_box style_2">
							<div class="" style="text-align:center">
								<h2>Test Result </h2><br>
							</div>
							<div class="ed_author" style="justify-content: space-around;">
								<div style="display: flex;flex-direction: column;justify-content: flex-start;flex-wrap: nowrap;align-items: center;">
									<h5 class="">Total Question: </h5><b><span id="marked_review">{{ $data['total_question'] }}</span></b>
								</div>
							
                                <div style="display: flex;flex-direction: column;justify-content: flex-start;flex-wrap: nowrap;align-items: center;">
									<h5 class="">Attempted Question: </h5><b><span id="attempt_count">{{ $data['total_question'] - $data['not_attempted']  }}</span></b>
								</div>
							</div>
                            <div class="ed_author" style="justify-content: space-around;">
								<div style="display: flex;flex-direction: column;justify-content: flex-start;flex-wrap: nowrap;align-items: center;">
									<h5 class="">Not-Attempted Question: </h5><b><span id="not_attempt">{{ $data['not_attempted'] }}</span></b>
								</div>
						
								<div style="display: flex;flex-direction: column;justify-content: flex-start;flex-wrap: nowrap;align-items: center;">
									<h5 class="">Right Answer: </h5><b><span id="attempt_count">{{ $data['correct_answer'] }} | {{ $data['out_of_marks'] }} {{ 'Marks' }}</span></b>
								</div>
							</div>
                            <div class="ed_author" style="justify-content: space-around;">
								<div style="display: flex;flex-direction: column;justify-content: flex-start;flex-wrap: nowrap;align-items: center;">
									<h5 class="">Wrong Answer: </h5><b><span id="not_attempt">{{ $data['incorrect_answer'] }} | -{{ $data['negative_marks'] }} {{ 'Marks' }}</span></b>
								</div>
							
								<div style="display: flex;flex-direction: column;justify-content: flex-start;flex-wrap: nowrap;align-items: center;">
									<h5 class="">Total Marks: </h5><b><span id="marked_review">{{ $data['final_marks'] }}</span></b>
								</div>
							</div>
							@foreach($data['test']->getSection as $i => $section)
								<div class="eld mb-3">
									<h5 class="font-medium">{{ $section->sectionSubject->name }}</h5>
									<ul class="number-que-list">
										@foreach($section->getQuestions()->wherePivot('deleted_at','=',NULL)->get() as $key => $questions)
											<li class="question-list" id="question_li_{{ $questions->id }}" key="{{ $questions->id }}"><i class="fa fa-eye" id="question_i_{{ $questions->id }}" style="visibility:hidden"></i><span class="numberlist">{{ $key+=1 }}</span></li>
										@endforeach
									</ul>
								</div>
							@endforeach
							<!-- <div class="ed_view_features">
								<div class="ed_view_link">
									<a href="{{ route('showTestResponse',[$data['student_id'],$data['test']->id]) }}" class="btn theme-bg enroll-btn">Show Test Response<i class="ti-angle-right"></i></a>
								</div>
							</div>	 -->
						</div>	
					<!-- </div> -->
				<!-- </div> -->
			</div>
			<div class="col-lg-8 col-md-12 order-lg-last">
				@foreach($data['test']->getSection as $i => $section)
					@foreach($section->getQuestions()->wherePivot('deleted_at','=',NULL)->get() as $j => $questions)
                            <div class="edu_wraper test-questions test-questions_{{ $j+=1 }}" key="{{ $questions->id }}" id="question_{{ $questions->id }}">
                            @if($data['test']->show_answer == 1)
                                <h3 class="edu_title">Question Number {{ $j }} @if(in_array($questions->id,$data['answer']['not_attempted']->pluck('question_id')->toArray())) <span style="background-color: #b4b1ad;">('Not Attempted')</span> @endif</h3>
                                <p>{!! $questions->question !!}</p>		
                                <ul class="no-ul-list">

                                    @for($k=1; $k <= $questions->mcq_options; $k++)
                                        @if($questions->mcq_answer == "ans_$k")
                                            <li class="right">
                                                {!! $questions['ans_'.$k] !!}
                                            </li>
                                        @elseif(in_array($questions->id,$data['answer']['incorrect_answer']->pluck('question_id')->toArray()))
                                            @if("ans_$k" == $data['answer']['incorrect_answer']->where('question_id',$questions->id)->first()->answer)
                                                <li class="wrong">
                                                    {!! $questions['ans_'.$k] !!}
                                                </li>
                                            @else
                                                <li class="">
                                                    {!! $questions['ans_'.$k] !!}
                                                </li>
                                            @endif
                                        @else
                                            <li class="">
                                                {!! $questions['ans_'.$k] !!}
                                            </li>
                                        @endif
                                    @endfor
                                </ul>
                            @endif
                                @if($data['test']->show_solution == 1)
                                    <div class="soln-res">
                                        <label> Solution :</label>{!! $questions->solution !!}                                  
                                        <label> Explanation :</label>{!! $questions->explanation !!}
                                    </div>
                                @endif
                                <hr>
                                
                                <input type="hidden" name="clear_questions[{{ $questions->id }}]" value="0">
                                <input type="hidden" key ="{{ $questions->id }}" name="mark_for_review_questions[{{ $questions->id }}]" value="0">
                                <input type="hidden" key ="{{ $questions->id }}" name="attemted_questions[{{ $questions->id }}]" value="0">
                            </div>
                            
                       
					@endforeach
				@endforeach
				<input type="hidden" name="correct_answer" value="{{ json_encode($data['answer']['correct_answer']->pluck('question_id')->toArray()) }}">
				<input type="hidden" name="incorrect_answer" value="{{ json_encode($data['answer']['incorrect_answer']->pluck('question_id')->toArray()) }}">
				<input type="hidden" name="not_attempted" value="{{ json_encode($data['answer']['not_attempted']->pluck('question_id')->toArray()) }}">

				<!-- <button type="button" class="btn btn-outline-theme" id="mark-for-review" onclick="starShow(0)">Mark for Review <i class="ti-hand-open"></i></button>
				<button type="button" class="btn btn-outline-theme" id="clear-response">Clear Response <i class="ti-brush-alt"></i></button>
				<button type="button" class="btn btn-outline-theme" id="submit-answer">Save & Next<i class="ti-angle-right"></i></button> -->
			</div>
		</div>
    </div>
</section>
@endsection

@section('js')
<script>
	var q_id = 0;
    var old_id = 0;
    const questions_key = [];

	$(document).ready(function(){
		$(".test-questions").hide();

		$('.test-questions').each(function(){
            questions_key.push($(this).attr('key'));
        });

		$("#question_"+ questions_key[q_id]).show();

		var correct_answer = JSON.parse($("input:hidden[name='correct_answer']").val());

		for (let i = 0; i < correct_answer.length; i++) {
			$("#question_li_"+correct_answer[i]).addClass('active');
		}

		var incorrect_answer = JSON.parse($("input:hidden[name='incorrect_answer']").val());
		
		for (let i = 0; i < incorrect_answer.length; i++) {
			$("#question_li_"+incorrect_answer[i]).addClass('incorrect');
		}

		var not_attempted = JSON.parse($("input:hidden[name='not_attempted']").val());
		
		for (let i = 0; i < not_attempted.length; i++) {
			$("#question_li_"+not_attempted[i]).addClass('not-attempt');
		}

		$(".question-list").click(function() {
			old_id = q_id;
            $("#question_"+questions_key[old_id]).hide();

			var key = $(this).attr('key'); 
			q_id = questions_key.indexOf(key);
            
			$("#question_"+questions_key[q_id]).show();
        });
		// correct_answer.each(function(){
		// 	var temp_key = $(this).val();
		// 	$("#question_li_"+questions_key[temp_key]).addClass('active');
		// });
		// $("input:hidden[name^='correct_answer']").each(function(){
		// 	var temp_key = $(this).val();
		// 	$("#question_li_"+questions_key[temp_key]).addClass('active');
		// });
	});
</script>
@endsection