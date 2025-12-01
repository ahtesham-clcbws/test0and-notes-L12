function inititateSelect2() {
    $("#subject_name").select2({
        placeholder: "Subject Name",
        allowClear: true,
        tags: true
    });

    $("#part_name_id").select2({
        placeholder: "Part Name",
        allowClear: true,
        tags: true
    });

    $("#lesson_name_id").select2({
        placeholder: "Chapter Name",
        allowClear: true,
        tags: true
    });

    $("#gn_lesson_name_id").select2({
        placeholder: "Lession Name",
        allowClear: true,
        tags: true
    });
      
}
inititateSelect2();

var part_name_id = $("#part_name_id").html();

if ($('#part_id').val() == 0) {
    $("#part_name_id").empty();
    inititateSelect2();
}

var lesson_name_id = $("#lesson_name_id").html();

if ($('#lesson_id').val() == 0) {
    $("#lesson_name_id").empty();
    inititateSelect2();
}

var subject_name_id = $("#subject_name").html();

if ($('#subject_id').val() == 0) {
    $("#subject_name").empty();
    inititateSelect2();
}
// function initPartName() {
//     if ($('#part_id').val() == 0) {
//         $("#part_name_id").empty();
//         inititateSelect2();
//     }
//     else{
//         console.log($('#part_id').val());
//         $("#part_name_id").append(part_name_id);
//         inititateSelect2();
//     }
// }
// initPartName();

function resetForm(formName) {
    if (formName == 'part') {
        $('#' + formName + '_subject_id').val('');
        $('#part_name_id').empty();
    }
    if (formName == 'lesson') {
        $('#' + formName + '_subject_id').val('');
        $('#lesson_subject_part_id').val('');
        $('#lesson_subject_part_id').attr('disabled', 'disabled');
    }
    if (formName == 'subject') {
        $('#subject_class_id').val('');
        $('#subject_name').empty();
    }
    $('#' + formName + '_form')[0].reset();
    $('#' + formName + '_form_name').val(formName + '_form');
    $('#' + formName + '_id').val(0);
    $('#' + formName + '_reset').hide();
}
function editForm(id, name, formName, subjectId = 0, subjectPartId = 0,classId = 0) {
    

    if (formName == 'part') {
        $("#subject_part_class_id").val(classId);
        partClassChange(classId).finally(() => {
            $('#part_subject_id').val(subjectId);
        })
        $("#part_name_id").empty();
        $("#part_name_id").append(part_name_id);
        $('#part_name_id').val(JSON.parse(name));
        // $('#' + formName + '_subject_id').val(subjectId);
        inititateSelect2();
    }
    if (formName == 'lesson') {

        $('#' + formName + '_subject_id').val(subjectId);
        $('#lession_class_id').val(classId);
        lessionClassChange(classId).finally(() => {
            console.log('finally called lessionClassChange');
            $('#lesson_subject_id').val(subjectId);
        })
        lessonSubjectChange(subjectId).finally(() => {
            console.log('finally called');
            $('#lesson_subject_part_id').val(subjectPartId);
        })
        $('#lesson_name_id').empty();
        $('#lesson_name_id').append(lesson_name_id);
        $('#lesson_name_id').val(JSON.parse(name));
        inititateSelect2();
    }
    if (formName == 'subject') {
        $("#subject_class_id").val(classId);
        // $('#subject_name').empty();
        $('#subject_name').append(subject_name_id);
        $('#subject_name').val(JSON.parse(name));
        inititateSelect2();
    }
    $('#' + formName + '_id').val(id);
    // $('#' + formName + '_name').val(name);
    $('#' + formName + '_reset').show();

}
async function lessonSubjectChange(id) {
    console.log(id);
    var class_id = $("#lession_class_id").val();
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
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value=""></option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
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
    }).fail(function (data) {
        console.log(data);
    })
}

async function gn_lessonSubjectChange(id) {
    console.log(id);
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
            var options = '<option value=""></option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#gn_lesson_subject_part_id').removeAttr('disabled');
            } else {
                $('#gn_lesson_subject_part_id').val('');
                $('#gn_lesson_subject_part_id').attr('disabled', 'disabled');
                alert('No Subject parts in this subject, please select another, or add some.');
            }
            $('#gn_lesson_subject_part_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function gn_lessonSubjectPartChange(id) {
    console.log(id);
    var gn_lesson_subject_id = $("#gn_lesson_subject_id").val();
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
            var options = '<option value=""></option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#gn_lesson_chapter_id').removeAttr('disabled');
            } else {
                $('#gn_lesson_chapter_id').val('');
                $('#gn_lesson_chapter_id').attr('disabled', 'disabled');
                alert('No Subject parts in this subject, please select another, or add some.');
            }
            $('#gn_lesson_chapter_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
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
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value=""></option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#part_subject_id').removeAttr('disabled');
            } else {
                $('#part_subject_id').val('');
                $('#part_subject_id').attr('disabled', 'disabled');
                alert('No Subject parts in this subject, please select another, or add some.');
            }
            $('#part_subject_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function lessionClassChange(class_id) {
    var formData = new FormData();
    formData.append('form_name', 'get_parts_subject');
    formData.append('class_id', class_id);
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
            var options = '<option value=""></option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#lesson_subject_id').removeAttr('disabled');
            } else {
                $('#lesson_subject_id').val('');
                $('#lesson_subject_id').attr('disabled', 'disabled');
                alert('No Subject parts in this subject, please select another, or add some.');
            }
            $('#lesson_subject_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function deleteSubject(id){

    var formData = new FormData();
    formData.append('form_name', 'deleteSubject');
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

async function deleteSubjectPart(subject_id,subject_part_id){

    var formData = new FormData();
    formData.append('form_name', 'deleteSubjectpart');
    formData.append('subject_id', subject_id);
    formData.append('subject_part_id', subject_part_id);

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

async function deleteSubjectPartChapter(subject_id,subject_part_id,subject_chapter){

    var formData = new FormData();
    formData.append('form_name', 'deleteSubjectPartChapter');
    formData.append('subject_id', subject_id);
    formData.append('subject_part_id', subject_part_id);
    formData.append('subject_chapter', subject_chapter);

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

async function deleteSubjectPartLession(subject_id,subject_part_id,subject_chapter,subject_lession){

    var formData = new FormData();
    formData.append('form_name', 'deleteSubjectPartLession');
    formData.append('subject_id', subject_id);
    formData.append('subject_part_id', subject_part_id);
    formData.append('subject_chapter', subject_chapter);
    formData.append('subject_lession', subject_lession);
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

