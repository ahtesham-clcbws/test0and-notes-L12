<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.88.1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link type="image/x-icon" href="{{ asset('logos/logo-white-square.png') }}" rel="icon">
        <link type="image/x-icon" href="{{ asset('logos/logo-white-square.png') }}" rel="shortcut-icon">
        <link href="{{ asset('logos/logo-white-square.png') }}" rel="apple-touch-icon">
        <title>{{ env('APP_NAME') }}</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }} " rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:wght@400;500;600;700&amp;display=swap"
            rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('css')

        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <link type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />

        @stack('styles')

    </head>

    <body>

        @include('Dashboard.Admin.partials.mainheader')

        <div class="container-fluid">
            <div class="row">
                @include('Dashboard.Admin.partials.sidebar')

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                    <div class="custom-dashboard pb-2 pt-3">
                        <div class="w-100 dashboard-header mb-4">
                            <h2 class="d-inline-block">
                                {{ isset($data['pagename']) ? $data['pagename'] : 'Administrator' }}
                            </h2>
                        </div>
                        @yield('main')
                        @if (isset($slot))
                            {{ $slot }}
                        @endif
                    </div>
                </main>
            </div>
        </div>


        @if (session()->has('loginSuccess'))
            <div class="toast align-items-center bg-primary position-absolute bottom-0 end-0 mb-3 border-0 text-white"
                id="myToastEl" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('loginSuccess') }}
                    </div>
                    <button class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" type="button"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif

        <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
            integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>

        {{-- <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let class_group = "{{ isset($class) ? $class : 0 }}";
            let board = "{{ isset($board) ? $board : 0 }}";
            let other_exam = "{{ isset($other_exam) ? $other_exam : 0 }}";
            let subject = "{{ isset($subject) ? $subject : 0 }}";
            let subject_part = "{{ isset($subject_part) ? $subject_part : 0 }}";
            let video = "{{ isset($video) ? $video : '0' }}";
            let notes = "{{ isset($notes) ? $notes : '0' }}";
            let gk = "{{ isset($gk) ? $gk : '0' }}";
            let package_info = "{{ isset($package) ? $package : 0 }}";

            let test = 0;
            @if (isset($test) && $test != '0' && $test != '')
                test = {!! $test !!};
            @endif
        </script>


        <script>
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            if ($('.select2').length) {
                console.log("select2");
                $('.select2').select2();
            }
            if ($('.datatable').length) {
                $('.datatable').DataTable();
            }
            $(".flatpickr").flatpickr({
                altInput: true,
                altFormat: "j F, Y",
                minDate: "today",
            });
            $(".flatpickrtime").flatpickr({
                altInput: true,
                altFormat: "j F, Y - H:i K",
                enableTime: true,
                minDate: "today",
                minTime: "10:00",
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': csrfToken
                }
            });
            feather.replace({
                'aria-hidden': 'true'
            })
            if (document.getElementById('myToastEl')) {
                var myToastEl = document.getElementById('myToastEl');
                var myToast = new bootstrap.Toast(myToastEl)
                myToast.show();
            }

            $('.validate').keyup(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid')
                    $(this).removeClass('is-valid')
                } else {
                    $(this).removeClass('is-invalid')
                    $(this).addClass('is-valid')
                }
            })
            if ($('.deletebutton').length) {
                $('.deletebutton').on('click', function() {
                    return confirm('Are you sure want to delete this?');
                });
            }

            $('#test_image').on('change', function() {
                var output = document.getElementById('package_img');
                output.src = URL.createObjectURL(this.files[0]);
            })

            async function getStudyMaterial(id) {
                var education_type_id = $("#education_type_id").val();
                var institute_id = $("#institute_id").val();
                var formData = new FormData();
                formData.append('form_name', 'get_study_material');
                formData.append('education_type_id', education_type_id);
                formData.append('classes_group_exams_id', id);
                formData.append('institute_id', institute_id);
                console.log("value:", education_type_id, id, institute_id);
                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    console.log("study material data:", data);
                    if (data && data.success) {
                        const study_material = data.message;
                        // var options = '<option value="">Add Video</option>';
                        var videoOptions = '';
                        var staticOptions = '';
                        var notesOptions = '';
                        if (study_material.length > 0) {

                            $(study_material).each(function(index, item) {
                                if (item.category == 'Live & Video Classes') {
                                    var selected = "";
                                    if (video != 0) {
                                        video_arry = video.toString().split(',');
                                        if (jQuery.inArray(item.id.toString(), video_arry) !== -1) {
                                            console.log('item.id:', item.id);
                                            selected = 'selected';
                                        }
                                    }
                                    videoOptions += '<option value="' + item.id + '" ' + selected + '>' +
                                        item.title + '</option>';
                                }
                                if (item.category == 'Static GK & Current Affairs') {
                                    var selected = "";
                                    if (gk != 0) {
                                        gk_arry = gk.toString().split(',');
                                        console.log("notes_arry:", gk_arry);
                                        if (jQuery.inArray(item.id.toString(), gk_arry) !== -1) {
                                            console.log('item.id:', item.id);
                                            selected = 'selected';
                                        }
                                    }
                                    staticOptions += '<option value="' + item.id + '" ' + selected + '>' +
                                        item.title + '</option>';
                                }
                                if (item.category == 'Study Notes & E-Books') {
                                    var selected = "";
                                    if (notes != 0) {
                                        notes_arry = notes.toString().split(',');
                                        console.log("notes_arry:", notes_arry);
                                        if (jQuery.inArray(item.id.toString(), notes_arry) !== -1) {
                                            console.log('item.id:', item.id);
                                            selected = 'selected';
                                        }
                                    }
                                    notesOptions += '<option value="' + item.id + '" ' + selected + '>' +
                                        item.title + '</option>';
                                }
                            });
                        } else {
                            alert('No Data, please select another, or add some.');
                        }
                        $('#video_id').html(videoOptions).trigger('change');
                        $('#current_affairs_id').html(staticOptions).trigger('change');
                        $('#study_material_id').html(notesOptions).trigger('change');
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }

            async function getTest(id) {
                var education_type_id = $("#education_type_id").val();
                var institute_id = $("#institute_id").val();
                var package_type = $("input[name='package_type']:checked").val();
                var formData = new FormData();
                formData.append('form_name', 'get_test_package');
                formData.append('education_type_id', education_type_id);
                formData.append('classes_group_exams_id', id);
                formData.append('institute_id', institute_id);
                formData.append('package_type', package_type);
                console.log("value:", education_type_id, id, institute_id, package_type);
                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    console.log("Get Test data:", data);
                    if (data && data.success) {
                        const test_data = data.message;
                        // var options = '<option value="">Add Video</option>';
                        var testOptions = '';

                        if (test_data.length > 0) {
                            if (test != 0) {
                                console.log("inside test condition!");
                                var test_arry = [];
                                $.each(test, function(index, value) {
                                    console.log("test res:", value.test_id);
                                    test_arry.push(value.test_id);
                                });
                                console.log("test array:", test_arry);
                            }
                            $(test_data).each(function(index, item) {
                                var selected = "";
                                if (test != 0) {
                                    if (jQuery.inArray(item.id.toString(), test_arry.map(String)) !== -1) {
                                        console.log('item.id:', item.id);
                                        selected = 'selected';
                                    }
                                }
                                console.log("institute name:", item.institute_name);
                                if (item.institute_name != '' && item.institute_name != null) {
                                    title = item.title + ' (' + item.institute_name + ')';
                                } else {
                                    title = item.title;
                                }
                                testOptions += '<option value="' + item.id + '" ' + selected + '>' + title +
                                    '</option>';
                            });
                        } else {
                            alert('No Data, please select another, or add some.');
                        }
                        $('#test_id').html(testOptions).trigger('change');
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }

            async function getPackage() {
                var education_type_id = $("#education_type_id").val();
                var class_id = $("#class_group_exam_id").val();
                var test_type = $("#test_type").val();
                if (test_type != '') {
                    if (test_type == 1)
                        test_type = 'Free';
                    else if (test_type == 2)
                        $("#packages").hide();
                    else if (test_type == 3)
                        $("#packages").hide();
                    else
                        test_type = 'Paid';
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
                        console.log("Get package data:", data);
                        if (data && data.success) {
                            const package_data = data.message;
                            // var options = '<option value="">Add Video</option>';
                            var packageOptions = '';

                            if (package_data.length > 0) {

                                $(package_data).each(function(index, item) {
                                    var selected = "";
                                    if (package_info != 0) {
                                        package_arry = package_info.toString().split(',');
                                        console.log("package_arry:", package_arry);
                                        if (jQuery.inArray(item.id.toString(), package_arry) !== -1) {
                                            console.log('item.id:', item.id);
                                            selected = 'selected';
                                        }
                                    }
                                    packageOptions += '<option value="' + item.id + '" ' + selected + '>' +
                                        item.plan_name + '</option>';
                                });
                            } else {
                                alert('No Data, please select another, or add some.');
                            }
                            $('#package').html(packageOptions);
                        } else {
                            alert(data.message);
                        }
                    }).fail(function(data) {
                        console.log(data);
                    })
                }
            }

            async function getClassesByEducation(educationId) {
                console.log(educationId);
                var formData = new FormData();
                formData.append('form_name', 'get_classes');
                formData.append('education_id', educationId);
                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                }).done(function(data) {
                    console.log(data);
                    if (data && data.success) {
                        const classes = data.message;
                        var options = '<option value="">Class / Group / Exam</option>';
                        if (classes.length > 0) {
                            $(classes).each(function(index, item) {
                                // var boards = JSON.parse(item.boards).join();
                                var selected = '';
                                if (class_group == item.id) {
                                    selected = 'selected';
                                }
                                options += '<option value="' + item.id + '" ' + selected + '>' + item.name +
                                    '</option>';
                            });
                            $('#class_group_exam_id').removeAttr('disabled');
                        } else {
                            $('#class_group_exam_id').val('');
                            $('#class_group_exam_id').attr('disabled', 'disabled');
                            alert('No classes / Groups or Exams in this Type, please select another, or add some.');
                        }
                        $('#class_group_exam_id').html(options);
                        if (class_group != 0) {
                            $('#class_group_exam_id').trigger('change');
                        }
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }

            async function classes_group_exams_change(id) {
                var education_type_id = $("#education_type_id").val();
                var formData = new FormData();
                formData.append('form_name', 'get_agency_board_university');
                formData.append('education_type_id', education_type_id);
                formData.append('classes_group_exams_id', id);
                console.log("value:", education_type_id, id);
                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    if (data && data.success) {
                        getPackage()
                        const agency_board_university = data.message;
                        var options = '<option value="">Exam Agency/Board/University</option>';
                        if (agency_board_university.length > 0) {
                            $(agency_board_university).each(function(index, item) {
                                var selected = '';
                                if (board == item.id) {
                                    selected = 'selected';
                                }
                                options += '<option value="' + item.id + '" ' + selected + '>' + item.name +
                                    '</option>';
                            });
                            $('#exam_agency_board_university_id').removeAttr('disabled');
                        } else {
                            $('#exam_agency_board_university_id').val('');
                            $('#exam_agency_board_university_id').attr('disabled', 'disabled');
                            alert(
                                'Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.'
                            );
                        }
                        $('#exam_agency_board_university_id').html(options);
                        if (board != 0)
                            $('#exam_agency_board_university_id').trigger('change');
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }

            async function exam_agency_board_university_change(id) {

                var education_type_id = $("#education_type_id").val();
                var classes_group_exams_id = $('#class_group_exam_id').val();
                var class_boards_id = id;

                var formData = new FormData();
                formData.append('form_name', 'get_other_exam_class_detail');
                formData.append('education_type_id', education_type_id);
                formData.append('classes_group_exams_id', classes_group_exams_id);
                formData.append('class_boards_id', class_boards_id);

                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    if (data && data.success) {
                        const agency_board_university = data.message;
                        var options = '<option value="">Other Exam/ Class Detail</option>';
                        if (agency_board_university.length > 0) {
                            $(agency_board_university).each(function(index, item) {
                                var selected = '';
                                if (other_exam == item.id) {
                                    selected = 'selected';
                                }
                                options += '<option value="' + item.id + '" ' + selected + '>' + item.name +
                                    '</option>';
                            });
                            $('#other_exam_class_detail_id').removeAttr('disabled');
                        } else {
                            $('#other_exam_class_detail_id').val('');
                            // $('#class_other_exam_detail').attr('disabled', 'disabled');
                            // alert('Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.');
                        }
                        $('#other_exam_class_detail_id').html(options);
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }

            async function partClassChange(class_id) {
                var formData = new FormData();
                formData.append('form_name', 'get_parts_subject');
                formData.append('class_id', class_id);
                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    console.log(data);
                    if (data && data.success) {
                        const subjectParts = data.message;
                        var options = '<option value="">Select Subject</option>';
                        if (subjectParts.length > 0) {
                            $(subjectParts).each(function(index, item) {
                                var selected = '';
                                if (subject == item.id) {
                                    selected = 'selected';
                                }
                                options += '<option value="' + item.id + '" ' + selected + '>' + item.name +
                                    '</option>';
                            });
                            $('#part_subject_id').removeAttr('disabled');
                        } else {
                            $('#part_subject_id').val('');
                            $('#part_subject_id').attr('disabled', 'disabled');
                            alert('No Subject parts in this subject, please select another, or add some.');
                        }
                        $('#part_subject_id').html(options);
                        if (subject != 0)
                            $('#part_subject_id').trigger('change');
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }

            async function lessonSubjectChange(id) {
                console.log(id);
                var class_id = $("#class_group_exam_id").val();
                var formData = new FormData();
                formData.append('form_name', 'get_subject_parts');
                formData.append('class_id', class_id);
                formData.append('subject_id', id);
                await $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    console.log(data);
                    if (data && data.success) {
                        const subjectParts = data.message;
                        var options = '<option value="" default selected> Select Subject Part</option>';
                        if (subjectParts.length > 0) {
                            $(subjectParts).each(function(index, item) {
                                var selected = '';
                                if (subject_part == item.id) {
                                    selected = 'selected';
                                }
                                options += '<option value="' + item.id + '" ' + selected + '>' + item.name +
                                    '</option>';
                            });
                            $('#lesson_subject_part_id').removeAttr('disabled');
                        } else {
                            $('#lesson_subject_part_id').val('');
                            $('#lesson_subject_part_id').attr('disabled', 'disabled');
                            alert('No Subject parts in this subject, please select another, or add some.');
                        }
                        $('#lesson_subject_part_id').html(options);
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }

            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-center",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            function success(messasge) {
                return Toast.fire({
                    icon: "success",
                    title: messasge
                });
            }

            function error(messasge) {
                return Toast.fire({
                    icon: "error",
                    title: messasge
                });
            }
        </script>
        @yield('javascript')

        @stack('scripts')
    </body>

</html>
