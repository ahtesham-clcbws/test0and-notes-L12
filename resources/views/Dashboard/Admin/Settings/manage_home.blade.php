@extends('Layouts.admin')

@section('main')
<style>
    div.relative {
  position: relative;
}

div.absolute {
  position: absolute;
  top: 0px;
  left: 18%;
}
</style>
<div class="container p-0">
        <form action="{{route('administrator.manage_home_process')}}" class="card dashboard-container mb-5" method="post" enctype="multipart/form-data">

            @csrf
            <input type="number" name="id" class="d-none" id="id" value="{{$id}}">
            <input name="form_name" id="testFormName" class="d-none" value="package_plan">

            <div class="card-body">
                <div class="row">
					<div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Banner Title First</label>
                            <input type="text" value="{{$banner_title_first}}" id="banner_title_first" name="banner_title_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Banner Title Second</label>
                            <input type="text" value="{{$banner_title_second}}" id="banner_title_second" name="banner_title_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Banner Title Third</label>
                            <input type="text" value="{{$banner_title_third}}" id="banner_title_third" name="banner_title_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Banner Content</label>
                            <input type="text" value="{{$banner_content}}" id="banner_content" name="banner_content" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Banner Photo</label>
                            <input type="file" id="banner_photo" name="banner_photo" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="banner_attr_image_1" class="control-label">Banner Attr Image 1</label>
                            <input type="file" id="banner_attr_image_1" name="banner_attr_image_1" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="banner_attr_image_2" class="control-label">Banner Attr Image 2</label>
                            <input type="file" id="banner_attr_image_2" name="banner_attr_image_2" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="banner_attr_image_3" class="control-label">Banner Attr Image 3</label>
                            <input type="file" id="banner_attr_image_3" name="banner_attr_image_3" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-check form-switch">
                            <label for="Package Image" class="control-label">Competitive Courses Status</label>
                          @if($competitive_courses_status == 1)
                          <input class="form-check-input" value="1" name="competitive_courses_status" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                          @else
                          <input class="form-check-input" value="0" name="competitive_courses_status" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                          @endif
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-check form-switch">
                            <label for="Package Image" class="control-label">Range Of Courses Status</label>
                          @if($range_of_courses_status == 1)
                          <input class="form-check-input" value="1" name="range_of_courses_status" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                          @else
                          <input class="form-check-input" value="0" name="range_of_courses_status" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                          @endif
                        </div>
                    </div>
                     <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Slider Footer Image</label>
                            <input type="file" id="slider_footer_image" name="slider_footer_image[]" class="form-control form-control-sm" multiple>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle1 First</label>
                            <input type="text" value="{{$subtitle1_first}}" id="banner_title_first" name="subtitle1_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle1 Second</label>
                            <input type="text" value="{{$subtitle1_second}}" id="banner_title_second" name="subtitle1_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle1 Third</label>
                            <input type="text" value="{{$subtitle1_third}}" id="banner_title_third" name="subtitle1_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle1 Content</label>
                            <input type="text" value="{{$subtitle1_content}}" id="banner_content" name="subtitle1_content" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle2 First</label>
                            <input type="text" value="{{$subtitle2_first}}" id="banner_title_first" name="subtitle2_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle2 Second</label>
                            <input type="text" value="{{$subtitle2_second}}" id="banner_title_second" name="subtitle2_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle2 Third</label>
                            <input type="text" value="{{$subtitle2_third}}" id="banner_title_third" name="subtitle2_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle2 Content</label>
                            <input type="text" value="{{$subtitle2_content}}" id="banner_content" name="subtitle2_content" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle3 First</label>
                            <input type="text" value="{{$subtitle3_first}}" id="banner_title_first" name="subtitle3_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle3 Second</label>
                            <input type="text" value="{{$subtitle3_second}}" id="banner_title_second" name="subtitle3_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle3 Third</label>
                            <input type="text" value="{{$subtitle3_third}}" id="banner_title_third" name="subtitle3_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle3 Content</label>
                            <input type="text" value="{{$subtitle3_content}}" id="banner_content" name="subtitle3_content" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle4 First</label>
                            <input type="text" value="{{$subtitle4_first}}" id="banner_title_first" name="subtitle4_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle4 Second</label>
                            <input type="text" value="{{$subtitle4_second}}" id="banner_title_second" name="subtitle4_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle4 Third</label>
                            <input type="text" value="{{$subtitle4_third}}" id="banner_title_third" name="subtitle4_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle4 Content</label>
                            <input type="text" value="{{$subtitle4_content}}" id="banner_content" name="subtitle4_content" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle5 First</label>
                            <input type="text" value="{{$subtitle5_first}}" id="banner_title_first" name="subtitle5_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle5 Second</label>
                            <input type="text" value="{{$subtitle5_second}}" id="banner_title_second" name="subtitle5_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle5 Third</label>
                            <input type="text" value="{{$subtitle5_third}}" id="banner_title_third" name="subtitle5_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle5 Content</label>
                            <input type="text" value="{{$subtitle5_content}}" id="banner_content" name="subtitle5_content" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle6 First</label>
                            <input type="text" value="{{$subtitle6_first}}" id="banner_title_first" name="subtitle6_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle6 Second</label>
                            <input type="text" value="{{$subtitle6_second}}" id="banner_title_second" name="subtitle6_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle6 Third</label>
                            <input type="text" value="{{$subtitle6_third}}" id="banner_title_third" name="subtitle6_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle6 Content</label>
                            <input type="text" value="{{$subtitle6_content}}" id="banner_content" name="subtitle6_content" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle7 First</label>
                            <input type="text" value="{{$subtitle7_first}}" id="banner_title_first" name="subtitle7_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle7 Second</label>
                            <input type="text" value="{{$subtitle7_second}}" id="banner_title_second" name="subtitle7_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle7 Third</label>
                            <input type="text" value="{{$subtitle7_third}}" id="banner_title_third" name="subtitle7_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle7 Content</label>
                            <input type="text" value="{{$subtitle7_content}}" id="banner_content" name="subtitle7_content" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle8 First</label>
                            <input type="text" value="{{$subtitle8_first}}" id="banner_title_first" name="subtitle8_first" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle8 Second</label>
                            <input type="text" value="{{$subtitle8_second}}" id="banner_title_second" name="subtitle8_second" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle8 Third</label>
                            <input type="text" value="{{$subtitle8_third}}" id="banner_title_third" name="subtitle8_third" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
						<div class="form-group">
                        	<label for="Package Image" class="control-label">Subtitle8 Content</label>
                            <input type="text" value="{{$subtitle8_content}}" id="banner_content" name="subtitle8_content" class="form-control form-control-sm">
                        </div>
                    </div>


				<div class="row mt-3 mt-3">
					<div class="col-sm-9">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</div>
				</div>
            </div>
        </form>
    </div>
    <h4> Slider Footer Images</h4>
 @foreach(json_decode($slider_footer_image) as $list)
 <div class="relative">
<img style="max-width: 20%; max-height: 20%; width: auto; height: auto;" src="{{ url('home/slider/'.$list)}}" alt="" />
    <div class="absolute">
    <a href="{{route('administrator.slider_delete', [$list])}}"><i class="fa fa-close "></i></a>
    </div>
</div>
@endforeach

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
