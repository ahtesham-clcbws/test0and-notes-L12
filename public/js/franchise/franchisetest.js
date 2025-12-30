const timeElapsed = Date.now();
const today = new Date();
// console.log(today.toLocaleString());
// console.log(today.toLocaleDateString());
// console.log(today.toLocaleTimeString());
var year = today.getFullYear().toString();
var month = today.getMonth() + 1;
// console.log(month);

const thisDate = year + "-" + month + "-" + today.getDate() + " " + today.getHours() + ":" + today.getMinutes();
// console.log(thisDate);
initialFunctionOfEducationType();
function initialFunctionOfEducationType() {
    const type_of_education = parseInt($('#type_of_education').val());
    const type_of_class = parseInt($('#class_group_exam_id').val());
    const type_of_board = parseInt($('#exam_agency_board_university_id').val());
    const type_of_other = parseInt($('#other_exam_class_detail_id').val());

    if (type_of_education > 0) {
        getClassesByEducation(type_of_education).finally(() => {
            console.log('hello');
            // setClassId(type_of_class).finally(() => {
            //     var boards = $('option:selected', '#class_group_exam_id').attr('board');
            //     setBoards(boards).finally(() => {
            //         $('#exam_agency_board_university_id').val(type_of_board);
            //         $('#class_group_exam_id').val(classId);
            //     })
            // })
        })
    }
}

async function setClassId(classId) {
    await $('#class_group_exam_id').val(classId);
}

$('#test_schedule_time_start').flatpickr({
    altInput: true,
    altFormat: "F j, Y - H:i K",
    enableTime: true,
    minDate: thisDate,
    onChange: function (selectedDates, dateStr, instance) {
        $('#test_schedule_time_stop').removeAttr('disabled');
        $('#test_schedule_time_stop').flatpickr({
            altInput: true,
            altFormat: "F j, Y - H:i K",
            enableTime: true,
            minDate: new Date(dateStr).fp_incr(1),
        })
    },
});

// part 1
function testTypeChange(value) {
    if (value == 1 || value == 3) {
        $('#test_schedule_time_stop_div').show();
        $('#test_schedule_time_start').removeAttr('required');
        $('#test_schedule_time_stop').removeAttr('required');
    }
    if (!value || value == 2) {
        $('#test_schedule_time_stop_div').hide();
        $('#test_schedule_time_start').attr('required', 'required');
        $('#test_schedule_time_stop').attr('required', 'required');
    }
}
function attemptsTypeChange(event) {
    var checked = $(event).is(":checked");
    if (checked) {
        $('#attemptsDiv').hide();
        $('#test_attempts').val(0);
        $('#test_attempts').removeAttr('required');
    } else {
        $('#attemptsDiv').show();
        $('#test_attempts').val(1);
        $('#test_attempts').attr('required', 'required');
    }
}

// part 2
function resultChange(event) {
    var checked = $(event).is(":checked");
    console.log(checked)
    if (checked) {
        $('#show_rank').removeAttr('disabled');
    } else {
        $('#show_rank').attr('disabled', 'disabled');
        $('#show_rank').prop('checked', false);
    }
}
function answerChange(event) {
    var checked = $(event).is(":checked");
    console.log(checked)
    if (checked) {
        $('#show_solution').removeAttr('disabled');
    } else {
        $('#show_solution').attr('disabled', 'disabled');
        $('#show_solution').prop('checked', false);
    }
}
function testMarkChange(event) {
    var checked = $(event).is(":checked");
    console.log(checked)
    if (checked) {
        $('#show_negative_marks').removeAttr('disabled');
        $('#marks_div').show();
        $('#marks').attr('required', 'required');
    } else {
        $('#show_negative_marks').attr('disabled', 'disabled');
        $('#show_negative_marks').prop('checked', false);
        $('#marks_div').hide();
        $('#marks').val('');
        $('#marks').removeAttr('required');
        $('#negative_marks_div').hide();
        $('#negative_marks').val('');
        $('#negative_marks').removeAttr('required');
    }
}
function negativeMarksChange(event) {
    var checked = $(event).is(":checked");
    console.log(checked)
    if (checked) {
        $('#negative_marks_div').show();
        $('#negative_marks').attr('required', 'required');
    } else {
        $('#negative_marks_div').hide();
        $('#negative_marks').val('');
        $('#negative_marks').removeAttr('required');
    }
}
function setDuration(event) {
    var checked = $(event).is(":checked");
    console.log(checked)
    if (checked) {
        $('#time_to_complete_div').show();
        $('#time_to_complete').attr('required', 'required');
    } else {
        $('#time_to_complete_div').hide();
        $('#time_to_complete').val('');
        $('#time_to_complete').removeAttr('required');
    }
}

set_negative_marks();

function set_negative_marks() {
    var selected = $("#test_marks_per_questions").val();
    if (selected != '') {
        $('#test_negative_marks').removeAttr('disabled');
    }
    else{
        $('#test_negative_marks').attr('disabled','disabled');
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
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const classes = data.message;
            var options = '<option value="">Class / Group / Exam</option>';
            if (classes.length > 0) {
                $(classes).each(function (index, item) {
                    // var boards = JSON.parse(item.boards).join();
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#class_group_exam_id').removeAttr('disabled');
            } else {
                $('#class_group_exam_id').val('');
                $('#class_group_exam_id').attr('disabled', 'disabled');
                alert('No classes / Groups or Exams in this Type, please select another, or add some.');
            }
            $('#class_group_exam_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function classes_group_exams_change(id) {
    var education_type_id = $("#education_type_id").val();
    var formData = new FormData();
    formData.append('form_name', 'get_agency_board_university');
    formData.append('education_type_id', education_type_id);
    formData.append('classes_group_exams_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const agency_board_university = data.message;
            var options = '<option value="">Exam Agency/Board/University</option>';
            if (agency_board_university.length > 0) {
                $(agency_board_university).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#exam_agency_board_university_id').removeAttr('disabled');
            } else {
                $('#exam_agency_board_university_id').val('');
                $('#exam_agency_board_university_id').attr('disabled', 'disabled');
                alert('Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.');
            }
            $('#exam_agency_board_university_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })  
}

async function exam_agency_board_university_change(id) {
    
    var education_type_id       = $("#education_type_id").val();
    var classes_group_exams_id  = $('#class_group_exam_id').val();
    var class_boards_id         = id;

    var formData = new FormData();
    formData.append('form_name', 'get_other_exam_class_detail');
    formData.append('education_type_id', education_type_id);
    formData.append('classes_group_exams_id',classes_group_exams_id);
    formData.append('class_boards_id',class_boards_id);
 
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const agency_board_university = data.message;
            var options = '<option value="">Other Exam/ Class Detail</option>';
            if (agency_board_university.length > 0) {
                $(agency_board_university).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
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
    }).fail(function (data) {
        console.log(data);
    })  
}

async function getBoardsbyClass(event) {
    var boards = $('option:selected', event).attr('board');
    console.log(boards);
    await setBoards(boards);
}

async function setBoards(boardIds) {
    var formData = new FormData();
    formData.append('form_name', 'get_boards');
    formData.append('boards_id', boardIds);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const classes = data.message;
            var options = '<option value="">Class / Group / Exam</option>';
            if (classes.length > 0) {
                $(classes).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#board_state_agency').removeAttr('disabled');
                // $('#other_category_class_id').removeAttr('disabled');
            } else {
                $('#board_state_agency').val('');
                $('#board_state_agency').attr('disabled', 'disabled');
                // $('#other_category_class_id').attr('disabled', 'disabled');
                alert('No Boards / Exam Agency or State in this Type, please select another, or add some.');
            }
            $('#board_state_agency').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

// goes to sections
async function onSelectQuestionType(questionType) {
    // var questionType = $(event).val();
    if (questionType == 1) {
        $('#question_mcq_options_default_div').show();
    }
    if (!questionType || questionType == 2) {
        $('#question_mcq_options_default_div').hide();
        $('#question_mcq_options_default').val(0);
    }
}

// show hide div 1

$(document).ready(
    function(){
        $("#divno1").click(function () {
            $("#divinfo1").toggle();
        });
    });

    // show hide div 2

$(document).ready(
    function(){
        $("#divno2").click(function () {
            $("#divinfo2").toggle();
        });
    });

    // show hide div 3

$(document).ready(
    function(){
        $("#divno3").click(function () {
            $("#divinfo3").toggle();
        });
    });

    // show hide div 4

$(document).ready(
    function(){
        $("#divno4").click(function () {
            $("#divinfo4").toggle();
        });
    });

    //---- Subject Changed Function ----//

async function subjectChange(id) {
    var formData = new FormData();
    formData.append('form_name', 'get_subject_parts');
    formData.append('subject_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value="">Subject Part</option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#subject_part_id').removeAttr('disabled');
            } else {
                $('#subject_part_id').val('');
            }
            $('#subject_part_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function subjectPartChange(id) {
    console.log(id);
    var gn_lesson_subject_id = $("#subject_id").val();
    var formData = new FormData();
    formData.append('form_name', 'get_subject_parts_chapter');
    formData.append('subject_part_id', id);
    formData.append('gn_lesson_subject_id', gn_lesson_subject_id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value="">Chapter Name</option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#subejct_chapter_id').removeAttr('disabled');
            } else {
                $('#subejct_chapter_id').val('');
            }
            $('#subejct_chapter_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function subjectChapterChange(id) {
    var gn_lesson_subject_id = $("#subject_id").val();
    var gn_lesson_part_id    = $("#subject_part_id").val();
    var formData = new FormData();
    formData.append('form_name', 'get_chapter_lession');
    formData.append('subject_part_id', gn_lesson_part_id);
    formData.append('gn_lesson_subject_id', gn_lesson_subject_id);
    formData.append('gn_lesson_chapter_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value="">Lession Name</option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#chapter_lession_id').removeAttr('disabled');
            } else {
                $('#chapter_lession_id').val('');
            }
            $('#chapter_lession_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}