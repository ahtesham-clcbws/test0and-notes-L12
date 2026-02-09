function inititateSelect2() {

    $("#education_type_id").select2({
        placeholder: "Education Type",
        allowClear: true
    });
    $("#class_boards").select2({
        placeholder: "Board / State / Agency",
        allowClear: true,
        tags: true
        });
    $("#class_other_exam_detail").select2({
        placeholder: "Subjects",
        allowClear: true,
        tags: true
    });
    $("#class_group_exam").select2({
        placeholder: "Subjects",
        allowClear: true,
        tags: true
    });
    $("#education_name").select2({
        placeholder: "Education Type",
        allowClear: true,
        tags: true
    });
    $("#class_group_exam_name_id").select2({
        placeholder: "Class / Group / Exam Name",
        allowClear: true,
        tags: true
    });
    $("#board_name_id").select2({
        placeholder: "Exam Agency",
        allowClear: true,
        tags: true
    });
    $("#other_exam_name_id").select2({
        placeholder: "Exam Agency",
        allowClear: true,
        tags: true
    });
}
inititateSelect2();

var value = $("#class_group_exam_name_id").html();

if ($('#class_group_exam_id').val() == 0) {
    $("#class_group_exam_name_id").empty();
    inititateSelect2();
}

var other_exam_name_id = $("#other_exam_name_id").html();

if ($("#otherExam_id").val() == 0) {
    $("#other_exam_name_id").empty();
    inititateSelect2();
}

function resetForm(formName) {
    $('#' + formName + 'Form')[0].reset();
    $('#' + formName + '_name').empty();
    $('#' + formName + 'FormName').val(formName + '_form');
    $('#' + formName + '_id').val(0);
    $('#' + formName + 'Reset').hide();
}

function editForm(id, name, formName, education = 0, boards = '', subjects = '', class_exam = '', slug = '') {
    $('#' + formName + '_id').val(id);
    $('#' + formName + '_name').empty();
    $('#' + formName + '_name').append("<option value=\"" + name + "\" selected>" + name + "</option>");
    if (formName == 'education') {
        $('#education_slug').val(slug);
    }
    console.log(formName);
    if (formName == 'class_group_exam') {
        $('#exam_education_type_id').val(education);
        $("#class_group_exam_name_id").empty();
        $("#class_group_exam_name_id").append(value);
            // inititateSelect2();
        console.log(JSON.parse(name));
        $('#class_group_exam_name_id').val(JSON.parse(name));
        inititateSelect2();
    }

    if (formName == 'board') {
        educationTypeChange(education,class_exam);
        $('#board_education_type_id').val(education);
        $('#board_class_group_exam').val(class_exam);
        $('#board_name_id').val(JSON.parse(name));
        inititateSelect2();
    }

    if(formName== 'otherExam'){

        other_exam_education_type_change(education).finally(() => {
            $('#other_exam_class_group_exam_id').val(class_exam);
            other_exam_classes_group_exams_change(class_exam).finally(() => {
                $('#other_exam_agency_board_university_id').val(boards);
            })
        })
        $('#other_exam_education_type_id').val(education);
        $("#other_exam_name_id").empty();
        $("#other_exam_name_id").append(other_exam_name_id);
        $('#other_exam_name_id').val(JSON.parse(name));
        inititateSelect2();

    }
    if (formName == 'class') {
        $('#education_type_id').val(education);
        $('#class_boards').val(JSON.parse(boards));
        $('#class_subjects').val(JSON.parse(subjects));
        inititateSelect2();
    }
    $('#' + formName + 'Reset').show();
}

async function educationTypeChange(id,class_exam) {
    var formData = new FormData();
    formData.append('form_name', 'get_class_group_exam');
    formData.append('education_type_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const class_group_exam = data.message;
            var options = '<option value=""></option>';
            if (class_group_exam.length > 0) {
                $(class_group_exam).each(function (index, item) {
                    options += '<option value="' + item.id + '" '+(item.id == class_exam ? "selected" : "")+'>' + item.name + '</option>';
                });
                $('#board_class_group_exam').removeAttr('disabled');
            } else {
                $('#board_class_group_exam').val('');
                $('#board_class_group_exam').attr('disabled', 'disabled');
                alert('No Class/ Group/ Exam Name in this Education Type, please select another, or add some.');
            }
            $('#board_class_group_exam').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function other_exam_education_type_change(id,class_exam) {

    var formData = new FormData();
    formData.append('form_name', 'get_class_group_exam');
    formData.append('education_type_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const class_group_exam = data.message;
            var options = '<option value=""></option>';
            if (class_group_exam.length > 0) {
                $(class_group_exam).each(function (index, item) {
                    options += '<option value="' + item.id + '" '+(item.id == class_exam ? "selected" : "")+'>' + item.name + '</option>';
                });
                $('#other_exam_class_group_exam_id').removeAttr('disabled');
            } else {
                $('#other_exam_class_group_exam_id').val('');
                $('#other_exam_class_group_exam_id').attr('disabled', 'disabled');
                alert('No Class/ Group/ Exam Name in this Education Type, please select another, or add some.');
            }
            $('#other_exam_class_group_exam_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })

    if(class_exam){
        other_exam_classes_group_exams_change(class_exam);
    }
}

async function other_exam_classes_group_exams_change(id,boards) {
    var education_type_id = $("#other_exam_education_type_id").val();
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
            var options = '<option value=""></option>';
            if (agency_board_university.length > 0) {
                $(agency_board_university).each(function (index, item) {
                    options += '<option value="' + item.id + '" '+(item.id == boards ? "selected" : "")+'>' + item.name + '</option>';
                });
                $('#other_exam_agency_board_university_id').removeAttr('disabled');
            } else {
                $('#other_exam_agency_board_university_id').val('');
                $('#other_exam_agency_board_university_id').attr('disabled', 'disabled');
                alert('Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.');
            }
            $('#other_exam_agency_board_university_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function quickAddEducationTypeChange(id) {
    var formData = new FormData();
    formData.append('form_name', 'get_class_group_exam');
    formData.append('education_type_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const class_group_exam = data.message;
            var options = '<option value=""></option>';
            if (class_group_exam.length > 0) {
                $(class_group_exam).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#class_group_exam').removeAttr('disabled');
            } else {
                $('#class_group_exam').val('');
                // $('#class_group_exam').attr('disabled', 'disabled');
                // alert('No Class/ Group/ Exam Name in this Education Type, please select another, or add some.');
            }
            $('#class_group_exam').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function classes_group_exams_change(id) {
    var classes_group_exams_id = $('#class_group_exam').val();
    var education_type_id = $("#education_type_id").val();

    var formData = new FormData();
    formData.append('form_name', 'gn_get_agency_board_university');
    formData.append('education_type_id', education_type_id);
    for (let i = 0; i < classes_group_exams_id.length; i++) {
        formData.append('classes_group_exams_id[]',classes_group_exams_id[i]);
    }

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const agency_board_university = data.message;
            var options = '<option value=""></option>';
            if (agency_board_university.length > 0) {
                $(agency_board_university).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#class_boards').removeAttr('disabled');
            } else {
                $('#class_boards').val('');
                // $('#class_boards').attr('disabled', 'disabled');
                // alert('Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.');
            }
            $('#class_boards').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function classes_exams_board_change(id) {

    var education_type_id       = $("#education_type_id").val();
    var classes_group_exams_id  = $('#class_group_exam').val();
    var class_boards_id         = $('#class_boards').val();

    var formData = new FormData();
    formData.append('form_name', 'get_other_exam_class_detail');
    formData.append('education_type_id', education_type_id);
    for (let i = 0; i < classes_group_exams_id.length; i++) {
        formData.append('classes_group_exams_id[]',classes_group_exams_id[i]);
    }
    for (let i = 0; i < class_boards_id.length; i++) {
        formData.append('class_boards_id[]',class_boards_id[i]);
    }

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const agency_board_university = data.message;
            var options = '<option value=""></option>';
            if (agency_board_university.length > 0) {
                $(agency_board_university).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#class_other_exam_detail').removeAttr('disabled');
            } else {
                $('#class_other_exam_detail').val('');
                // $('#class_other_exam_detail').attr('disabled', 'disabled');
                // alert('Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.');
            }
            $('#class_other_exam_detail').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function deleteEducationType(id){

    var formData = new FormData();
    formData.append('form_name', 'deleteEducationType');
    formData.append('id', id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log('data deleted');
        location.reload();
    }).fail(function (data) {
        console.log(data);
    })
}

async function deleteClassGroup(class_id,education_id){

    var formData = new FormData();
    formData.append('form_name', 'deleteClass');
    formData.append('education_id', education_id);
    formData.append('class_id', class_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log('data deleted');
        location.reload();
    }).fail(function (data) {
        console.log(data);
    })
}

async function deleteExamAgencyBoard(education_id,class_id,exam_agency_id,gn_display_id){

    var formData = new FormData();
    formData.append('form_name', 'deleteExamAgencyBoard');
    formData.append('education_id', education_id);
    formData.append('class_id', class_id);
    formData.append('exam_agency_id', exam_agency_id);
    formData.append('gn_display_id', gn_display_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log('data deleted');
        location.reload();
    }).fail(function (data) {
        console.log(data);
    })
}

async function deleteOtherExamClass(education_type_id,classes_group_exams_id,agency_board_university_id){

    var formData = new FormData();
    formData.append('form_name', 'deleteOtherExamClass');
    formData.append('education_type_id', education_type_id);
    formData.append('classes_group_exams_id', classes_group_exams_id);
    formData.append('agency_board_university_id', agency_board_university_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log('data deleted');
        location.reload();
    }).fail(function (data) {
        console.log(data);
    })
}

function editMasterClass(id, name, summary, image) {
    $('#master_class_id').val(id);
    $('#master_class_name').val(name);
    $('#master_class_summary').val(summary);
    if (image) {
        $('#master_class_image_preview').html('<img src="/storage/' + image + '" width="100">');
    } else {
        $('#master_class_image_preview').empty();
    }
    // Smooth scroll to form
    $('html, body').animate({
        scrollTop: $("#masterClassForm").offset().top - 100
    }, 500);
}

function resetMasterClassForm() {
    $('#masterClassForm')[0].reset();
    $('#master_class_id').val(0);
    $('#master_class_image_preview').empty();
}
