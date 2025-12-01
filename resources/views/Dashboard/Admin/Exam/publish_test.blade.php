@extends('Layouts.admin')

@section('css')
    <style>
        .dashboard-container .alertx {
            position: relative;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            min-height: 49px;
        }

        .dashboard-container .form-switch {
            padding-top: 4px;
        }

        .dashboard-container .form-switch label {
            width: -webkit-fill-available;
        }

        .noDisplay {
            display: none;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: indianred;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 7px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: darkgreen;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
            width: 60px;
            height: 25px;
            margin-left: 45px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('main')
    <div class="container p-0">
        <form class="card dashboard-container mb-5" method="post" id="publish_test">
            @error('testError')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            @error('testSuccess')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            @csrf
            <input type="number" name="id" class="d-none" id="test_id"
                value="{{ $data['test'] ? $data['test']['id'] : '0' }}">
            <input name="form_name" id="testFormName" class="d-none" value="publish_test">

            <div class="card-body">
                {{-- part 1 --}}
                <div class="row">
                    <div class="col-12">
                        <div class="alertx alert-primary">
                            <small><b>Test Title</b></small>
                            <input type="text" class="form-control form-control-sm" id="test_title" name="title"
                                value="{{ $data['test'] ? $data['test']['title'] : '' }}" placeholder="Test Title" disabled>
                        </div>
                    </div>
                </div>
                {{-- part 3 --}}
                <div class="row mt-3">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Education Type</b></small>
                            <select class="form-select form-select-sm" onchange="getClassesByEducation(this.value)"
                                id="education_type_id" name="education_type_id" required disabled>
                                <option value="">select</option>
                                @foreach ($data['educations'] as $key => $education)
                                    <option
                                        {{ $data['test'] && $data['test']['education_type_id'] == $education['id'] ? 'selected' : '' }}
                                        value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Class/Group/Exam Name</b></small>
                            <select class="form-select form-select-sm" id="class_group_exam_id" name="class_group_exam_id"
                                onchange="classes_group_exams_change(this.value)" disabled>
                                <option value="">Select</option>
                                @if (!empty($data['test']))
                                    @foreach ($data['group_classes'] as $group_classes)
                                        <option value="{{ $group_classes->id }}"
                                            @if ($group_classes->id == $data['test']->education_type_child_id) selected @endif>{{ $group_classes->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary" id="time_to_complete_div">
                            <small><b>Exam Agency/Board/University</b></small>
                            <select class="form-select form-select-sm" id="exam_agency_board_university_id"
                                name="exam_agency_board_university_id"
                                onchange="exam_agency_board_university_change(this.value)" required disabled>
                                <option value="">Select</option>
                                @if (1)
                                    @foreach ($data['agency_boards'] as $agency_boards)
                                        <option value="{{ $agency_boards->board_agency_exam_id }}"
                                            @if ($agency_boards->board_agency_exam_id == $data['test']->board_state_agency) selected @endif>
                                            {{ $agency_boards->agencyBoardUniversity->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary" id="time_to_complete_div">
                            <small><b>Other Exam/ Class Detail</b></small>
                            <select class="form-select form-select-sm" id="other_exam_class_detail_id"
                                name="other_exam_class_detail_id" required disabled>
                                <option value="">Select</option>
                                @if (!empty($data['test']))
                                    @foreach ($data['other_exams'] as $other_exams)
                                        <option value="{{ $other_exams->id }}"
                                            @if ($other_exams->id == $data['test']->other_category_class_id) selected @endif>{{ $other_exams->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Marks per Questions</b></small>

                            <!-- <button style="float:right;" type="" id="divno1" class="btn btn-danger btn-sm">No</button>
                                        <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                        <div id="divinfo1" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_marks_per_questions"
                                name="marks_per_questions" onchange="set_negative_marks()" required disabled>
                                <option value="">Select</option>
                                @foreach ($data['marks'] as $marks)
                                    <option value="{{ $marks }}" @if (old('marks_per_questions', $data['test']->gn_marks_per_questions) == $marks) selected @endif>
                                        {{ $marks }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Negative Marks per Questions</b></small>

                            <!-- <button style="float:right;" type="" id="divno2" class="btn btn-danger btn-sm">No</button>
                                        <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                        <div id="divinfo2" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_negative_marks1" name="negative_marks"
                                disabled required>
                                <option value="">Select</option>
                                @foreach ($data['negative_marks'] as $negative_marks)
                                    <option value="{{ $negative_marks['id'] }}"
                                        @if (old('negative_marks', $data['test']->negative_marks) == $negative_marks['id']) selected @endif>{{ $negative_marks['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                                        <div class="alertx alert-primary">
                                            <small><b>Subjects(s) / Sections(s)</b></small>
                                            <select class="form-select form-select-sm" id="no_of_sections" name="no_of_sections"  onchange="addSection()"
                                                required>
                                                <option value="">Select</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div> -->
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Subjects(s) / Sections(s)</b></small>

                            <!-- <button style="float:right;" type="" id="divno4" class="btn btn-danger btn-sm">No</button>
                                        <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                        <div id="divinfo4" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_no_of_sections" name="no_of_sections"
                                required disabled>
                                <option value="">Select</option>
                                <option value="1" @if ($data['test']->sections == '1') selected @endif>1 Sections
                                </option>
                                <option value="2" @if ($data['test']->sections == '2') selected @endif>2 Sections
                                </option>
                                <option value="3" @if ($data['test']->sections == '3') selected @endif>3 Sections
                                </option>
                                <option value="4" @if ($data['test']->sections == '4') selected @endif>4 Sections
                                </option>
                                <option value="5" @if ($data['test']->sections == '5') selected @endif>5 Sections
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Total Questions</b></small>
                        </div>
                        <div id="divinfo3" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_total_questions" name="total_questions"
                                required disabled>
                                @for ($i = 1; $i < 201; $i++)
                                    <option value="{{ $i }}"
                                        @if ($data['test']->total_questions == $i) selected @endif>{{ $i }}
                                        {{ 'Questions' }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                {{-- part 4 --}}

                {{-- part 2 --}}
                <div class="row">
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Result</b></small>
                            <label class="switch">
                                <input type="checkbox" name="show_result"
                                    @if ($data['test']->show_result == 1) checked="checked" @endif>
                                <span class="slider round"></span>
                            </label>
                            <!-- <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Answer(R/W)</b></small>
                            <label class="switch">
                                <input type="checkbox" name="show_answer"
                                    @if ($data['test']->show_answer == 1) checked="checked" @endif>
                                <span class="slider round"></span>
                            </label>
                            <!-- <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Solution</b></small>
                            <label class="switch">
                                <input type="checkbox" name="show_solution"
                                    @if ($data['test']->show_solution == 1) checked="checked" @endif>
                                <span class="slider round"></span>
                            </label>
                            <!-- <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Rank</b></small>
                            <label class="switch">
                                <input type="checkbox" name="show_rank"
                                    @if ($data['test']->show_rank == 1) checked="checked" @endif>
                                <span class="slider round"></span>
                            </label>
                            <!-- <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Test Type</b></small>
                            <select class="form-select form-select-sm" id="test_type" name="test_type"
                            {{-- getTestType({{ $data['test_category'] }}, this.value, {{ $data['test']['test_cat'] }}) --}}
                                onchange="getPackages(); "
                                required>
                                <option value="" disabled>select</option>
                                <option value="1" @if ($data['test']['test_type'] == 1) selected @endif>Free
                                </option>
                                <option value="0" @if ($data['test']['test_type'] == 0) selected @endif>Paid
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Add Package</b></small>
                            <input type="hidden" name="package_id" id="package_id" value="{{$data['test'] ? $data['test']['package'] : []}}">
                            <select class="form-select form-select-sm select2" multiple id="package" name="package[]" required>
                                <option value="">Select Package</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Test Category</b></small>
                            <select class="form-select form-select-sm select2" id="test_cat" name="test_cat" required>
                                <option value="">Select Category</option>
                                @foreach ($data['test_category'] as $list)
                                    @if ($list->id == $data['test']['test_cat'])
                                        <option value="{{ $list->id }}" selected>
                                        @else
                                        <option value="{{ $list->id }}">
                                    @endif
                                    {{ $list->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12" id="test_fees" >
                        <div class="alertx alert-primary">
                            <small><b>Test Fees</b></small>
                            <input type="text" class="form-control form-control-sm" id="price" name="price"
                                value="{{ $data['test'] ? $data['test']['price'] : '40' }}" placeholder="0">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save Test</button>

            </div>
            <!-- <div class="card-footer">
                                <small><b>Select Creator</b></small>
                                <select class="form-select form-select-sm" id="creater_type" name="creater_type" style="margin-bottom: 10px;"required>
                                    <option value="">Select</option>
                                    <option value="1">Myself</option>
                                    <option value="2">Rohit</option>
                                    <option value="3">Nitin</option>
                                    <option value="4">Joy</option>
                                    <option value="5">Dheer</option>
                                </select>
                        
                                <small><b>Select Publisher</b></small>
                                <select class="form-select -select-sm" id="publisher_type" name="publisher_type" style="margin-bottom: 20px;"required>
                                <option value="">Select</option>
                                    <option value="1">Myself</option>
                                    <option value="2">Rohit</option>
                                    <option value="3">Nitin</option>
                                    <option value="4">Joy</option>
                                    <option value="5">Dheer</option>
                                </select>
                                <button type="submit" class="btn btn-success">Submit Request</button>
                                <button type="submit" class="btn btn-success">Create Test</button>
                            </div> -->
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admintest.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admintestsections.js') }}"></script>
    <script>
        $(document).ready(function() {
            var test_cat = document.querySelector('#test_cat');
            var category = []
            for (let i = 0; i < test_cat.options.length; i++) {
                if (test_cat.options[i].value != "") {
                    category.push({
                        id: test_cat.options[i].value,
                        cat_name: test_cat.options[i].text
                    })
                }
            }

            // getTestType(category, $("#test_type").val(), {{ $data['test']['test_cat'] }})
            getPackages();
        });

        // x`x`x(JSON.parse("{{ $data['test_category'] }}") , $("#education_type_id").val())

        async function getPackages() {
            var education_type_id = $("#education_type_id").val();
            var class_id = $("#class_group_exam_id").val();
            var test_type = $("#test_type").val();
            console.log('testtype'+test_type);
            if (test_type != '') {
                if (test_type == 1) {
                    test_type = 'Free';
                    $('#price').attr('disabled', true);
                    $("#price").removeAttr('required');

                } else {
                    test_type = 'Paid';
                    $('#price').removeAttr('disabled');
                    $("#price").attr('required', true);
                }
            }

            var formData = new FormData();
            formData.append('form_name', 'get_package');
            formData.append('education_type_id', education_type_id);
            formData.append('classes_group_exams_id', class_id);
            formData.append('test_type', test_type);

            console.log("value:", education_type_id, class_id, test_type);
            if (test_type != '' && class_id != '') {

                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    if (data && data.success) {
                        const package_data = data.message;
                        console.log('packahe');
                        const package = $('#package_id').val();
                        console.log(package);
                        // console.log('pack'+package);
                        // var options = '<option value="">Add Video</option>';
                        var packageOptions = '';
                        
                        if (package_data.length > 0) {

                            $(package_data).each(function(index, item) {
                                console.log(item);
                                var selected = "";
                                if (package != 0) {
                                    package_arry = package.toString().split(',');
                                    console.log("package_arry:", package_arry);
                                    if (jQuery.inArray(item.id.toString(), package_arry) !== -1) {
                                        console.log('item.id:', item.id);
                                        selected = 'selected';
                                    }
                                }
                                packageOptions += '<option value="' + item.id + '" ' + selected + '>' +
                                    item.plan_name + '</option>';
                            });
                        }
                        if(package == 0){
                            packageOptions += '<option value="0" selected >No Pacakge</option>';
                        }else {
                            packageOptions += '<option value="0">No Pacakge</option>';
                        }
                        //  else {
                        //     alert('No Data, please select another, or add some.');
                        // }
                        $('#package').html(packageOptions);
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }
        }

        function getTestType(items, val, select = '') {
            console.log('select:' + select);
            var selectElement = $('#test_cat');
            selectElement.empty();
            var newOption = $('<option>', {
                value: '',
                text: 'Select Category',
            });
            selectElement.append(newOption);
            items.filter((x) => {
                if (val == '0') {
                    if (x.id == 7) {
                        var newOption = $('<option>', {
                            value: x.id,
                            text: x.cat_name,
                            selected: x.id == select ? true : false
                        });
                        selectElement.append(newOption);
                        return;
                    }
                } else if (val == '1') {
                    if (x.id != 7) {
                        var newOption = $('<option>', {
                            value: x.id,
                            text: x.cat_name,
                            selected: x.id == select ? true : false
                        });
                        selectElement.append(newOption);
                        return;
                    }
                }
                selectElement.append(newOption);
                // Append the new option to the select element

            })

        }
    </script>
@endsection
