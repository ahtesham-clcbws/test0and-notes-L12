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
        <form class="card dashboard-container mb-5" action="{{ route('administrator.manage_home_process') }}" method="post"
            enctype="multipart/form-data">

            @csrf
            <input class="d-none" id="id" name="id" type="number" value="{{ $id }}">
            <input class="d-none" id="testFormName" name="form_name" value="package_plan">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Banner Title First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="banner_title_first"
                                type="text" value="{{ $banner_title_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Banner Title Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="banner_title_second"
                                type="text" value="{{ $banner_title_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Banner Title Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="banner_title_third"
                                type="text" value="{{ $banner_title_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Banner Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="banner_content"
                                type="text" value="{{ $banner_content }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Banner Photo</label>
                            <input class="form-control form-control-sm" id="banner_photo" name="banner_photo"
                                type="file">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="banner_attr_image_1">Banner Attr Image 1</label>
                            <input class="form-control form-control-sm" id="banner_attr_image_1" name="banner_attr_image_1"
                                type="file">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="banner_attr_image_2">Banner Attr Image 2</label>
                            <input class="form-control form-control-sm" id="banner_attr_image_2" name="banner_attr_image_2"
                                type="file">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="banner_attr_image_3">Banner Attr Image 3</label>
                            <input class="form-control form-control-sm" id="banner_attr_image_3" name="banner_attr_image_3"
                                type="file">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-check form-switch">
                            <label class="control-label" for="Package Image">Competitive Courses Status</label>
                            @if ($competitive_courses_status == 1)
                                <input class="form-check-input" id="flexSwitchCheckChecked"
                                    name="competitive_courses_status" type="checkbox" value="1" role="switch" checked>
                            @else
                                <input class="form-check-input" id="flexSwitchCheckChecked"
                                    name="competitive_courses_status" type="checkbox" value="0" role="switch">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-check form-switch">
                            <label class="control-label" for="Package Image">Range Of Courses Status</label>
                            @if ($range_of_courses_status == 1)
                                <input class="form-check-input" id="flexSwitchCheckChecked"
                                    name="range_of_courses_status" type="checkbox" value="1" role="switch"
                                    checked>
                            @else
                                <input class="form-check-input" id="flexSwitchCheckChecked"
                                    name="range_of_courses_status" type="checkbox" value="0" role="switch">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle1 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle1_first"
                                type="text" value="{{ $subtitle1_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle1 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle1_second"
                                type="text" value="{{ $subtitle1_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle1 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle1_third"
                                type="text" value="{{ $subtitle1_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle1 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle1_content"
                                type="text" value="{{ $subtitle1_content }}">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle2 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle2_first"
                                type="text" value="{{ $subtitle2_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle2 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle2_second"
                                type="text" value="{{ $subtitle2_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle2 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle2_third"
                                type="text" value="{{ $subtitle2_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle2 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle2_content"
                                type="text" value="{{ $subtitle2_content }}">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle3 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle3_first"
                                type="text" value="{{ $subtitle3_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle3 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle3_second"
                                type="text" value="{{ $subtitle3_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle3 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle3_third"
                                type="text" value="{{ $subtitle3_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle3 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle3_content"
                                type="text" value="{{ $subtitle3_content }}">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle4 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle4_first"
                                type="text" value="{{ $subtitle4_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle4 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle4_second"
                                type="text" value="{{ $subtitle4_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle4 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle4_third"
                                type="text" value="{{ $subtitle4_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle4 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle4_content"
                                type="text" value="{{ $subtitle4_content }}">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle5 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle5_first"
                                type="text" value="{{ $subtitle5_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle5 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle5_second"
                                type="text" value="{{ $subtitle5_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle5 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle5_third"
                                type="text" value="{{ $subtitle5_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle5 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle5_content"
                                type="text" value="{{ $subtitle5_content }}">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle6 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle6_first"
                                type="text" value="{{ $subtitle6_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle6 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle6_second"
                                type="text" value="{{ $subtitle6_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle6 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle6_third"
                                type="text" value="{{ $subtitle6_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle6 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle6_content"
                                type="text" value="{{ $subtitle6_content }}">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle7 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle7_first"
                                type="text" value="{{ $subtitle7_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle7 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle7_second"
                                type="text" value="{{ $subtitle7_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle7 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle7_third"
                                type="text" value="{{ $subtitle7_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle7 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle7_content"
                                type="text" value="{{ $subtitle7_content }}">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle8 First</label>
                            <input class="form-control form-control-sm" id="banner_title_first" name="subtitle8_first"
                                type="text" value="{{ $subtitle8_first }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle8 Second</label>
                            <input class="form-control form-control-sm" id="banner_title_second" name="subtitle8_second"
                                type="text" value="{{ $subtitle8_second }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle8 Third</label>
                            <input class="form-control form-control-sm" id="banner_title_third" name="subtitle8_third"
                                type="text" value="{{ $subtitle8_third }}">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Subtitle8 Content</label>
                            <input class="form-control form-control-sm" id="banner_content" name="subtitle8_content"
                                type="text" value="{{ $subtitle8_content }}">
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    {{-- Partner Logos Management Section --}}
    <div class="container p-0">
        <form class="card dashboard-container mb-5" action="{{ route('administrator.upload_partner_logos') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h5 class="mb-0">Manage Partner Logos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="slider_footer_image">Upload Partner Logos (Select Multiple)</label>
                            <input class="form-control form-control-sm" id="slider_footer_image" name="slider_footer_image[]"
                                type="file" multiple accept="image/*" required>
                            <small class="text-muted">Supported formats: JPG, PNG, JPEG</small>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-upload"></i> Upload Logos
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <h4> Partner Logos</h4>
    <div class="row">
        @if (!empty($slider_footer_image) && count(json_decode($slider_footer_image)))
            @foreach (json_decode($slider_footer_image, true) as $item)
                @php
                    $image = is_array($item) ? $item['image'] : $item;
                    $url = is_array($item) ? ($item['url'] ?? '') : '';
                @endphp
                <div class="col-md-3 mb-4">
                    <div class="card relative shadow-sm h-100">
                        <img src="{{ asset('storage/home/slider/' . $image) }}" alt="Slider Image" class="card-img-top"
                            style="height: 150px; object-fit: cover;" />
                        <div class="absolute" style="top: 5px; right: 5px; left: auto;">
                            <a href="{{ route('administrator.slider_delete', [$image]) }}" class="btn btn-danger btn-sm rounded-circle"
                                onclick="return confirm('Are you sure you want to delete this image?');">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <div class="card-body p-2">
                            <form action="{{ route('administrator.update_slider_url') }}" method="POST">
                                @csrf
                                <input type="hidden" name="image" value="{{ $image }}">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="url" class="form-control" placeholder="https://example.com" value="{{ $url }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p class="text-muted">No slider images found.</p>
            </div>
        @endif
    </div>

    <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection
