async function changeSubject(id, key,class_id) {
    var formData = new FormData();
    formData.append('form_name', 'get_subject_parts');
    formData.append('subject_id', id);
    formData.append('class_id', class_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
    }).done(function (data) {
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value=""></option>';
            var subject_part = $('#subject_part_' + key);
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                subject_part.removeAttr('disabled');
                // $('#other_category_class_id').removeAttr('disabled');
            } else {
                subject_part.attr('disabled', 'disabled');
                // $('#other_category_class_id').attr('disabled', 'disabled');
            }
            subject_part.val('');
            subject_part.html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}
async function changeSubjectPart(id, key) {
    // console.log(id);
    var formData = new FormData();
    formData.append('form_name', 'get_subject_part_lessons');
    formData.append('subject_part_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
    }).done(function (data) {
        // console.log(data);
        if (data && data.success) {
            const lessons = data.message;
            var options = '<option value=""></option>';
            var subject_part_lesson = $('#subject_part_lesson_' + key);
            if (lessons.length > 0) {
                $(lessons).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                subject_part_lesson.removeAttr('disabled');
                // $('#other_category_class_id').removeAttr('disabled');
            } else {
                subject_part_lesson.attr('disabled', 'disabled');
                // $('#other_category_class_id').attr('disabled', 'disabled');
            }
            subject_part_lesson.val('');
            subject_part_lesson.html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function changeSubjectChapter(id,key) {
    // console.log(id);
    var gn_subject_id = $("#subject_" + key).val();
    var gn_subject_part_id = $('#subject_part_' + key).val();

    var formData = new FormData();
    formData.append('form_name', 'get_subject_chapter_lession');
    formData.append('subject_id', gn_subject_id);
    formData.append('subject_part_id', gn_subject_part_id);
    formData.append('subject_chapter_id', id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const lessons = data.message;
            var options = '<option value=""></option>';
            var subject_part_lesson = $('#gn_subject_part_lesson_' + key);
            if (lessons.length > 0) {
                $(lessons).each(function (index, item) {
                    options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                subject_part_lesson.removeAttr('disabled');
                // $('#other_category_class_id').removeAttr('disabled');
            } else {
                subject_part_lesson.attr('disabled', 'disabled');
                // $('#other_category_class_id').attr('disabled', 'disabled');
            }
            subject_part_lesson.val('');
            subject_part_lesson.html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}
var total_questions = $('#test_total_questions').val();
console.log('total_questions:'+total_questions);
onTriggerQuestionType();

function onTriggerQuestionType(){
    $('.section_subject').each(function () {
        var questions_type_key = $(this).attr('key');
        var questionType = $('#question_type_'+questions_type_key).val();
        onSelectQuestionType(questionType,questions_type_key);
        $('#difficulty_level_'+questions_type_key).val(50);
        var mykey = parseInt(questions_type_key)+1;
        $('#number_of_questions_'+mykey).attr('disabled','disabled');
    });

    // $('#number_of_questions_0').empty();
    $('#number_of_questions_0').append('<option value="" disabled>Choose Question</option>');
    let section = $('#test_no_of_sections').val()
    for (let i = 1; i <= total_questions; i++) {
        if(i == total_questions && section == 1){
            var options = '<option value="'+ i +'">'+ i +' Questions</option>';
            $('#number_of_questions_0').append(options);
            $("#number_of_questions_0 option[value='"+i+"']").attr("selected", "selected");
            console.log(1321313123213213);
        }   
        else{
            var options = '<option value="'+ i +'">'+ i +' Questions</option>';
            $('#number_of_questions_0').append(options);
        }
    }


    

}

async function onSelectQuestionType(questionType, key) {
    // console.log(questionType)
    if (questionType == 1) {
        $('#mcq_options_' + key).val(4);
        // $('#question_mcq_options_default_div').show();
        $('#mcq_options_' + key).removeAttr('disabled');
    }
    if (!questionType || questionType == 2) {
        // $('#question_mcq_options_default_div').hide();
        $('#mcq_options_' + key).val(0);
        $('#mcq_options_' + key).attr('disabled', 'disabled');
    }
}

async function onChangeQustions(no_of_questions, key) {
    var key = parseInt(key);
    key+=1;
    var t_questions = 0;
    t_questions = total_questions;
    t_questions -= no_of_questions;
    if (t_questions == 0) {
        $('#number_of_questions_'+key).empty();
        $('#number_of_questions_'+key).attr('disabled','disabled');
    }
    else{
        $('#number_of_questions_'+key).removeAttr('disabled');
        $('#number_of_questions_'+key).empty();
        for (let i = 1; i <= t_questions; i++) {
            var option = '<option value="'+ i +'">'+ i +' Questions</option>';
            $('#number_of_questions_'+key).append(option);
        }
    }
}

var sectionCounts = $('#total_sections');
var initialSectionCounts = parseInt(sectionCounts.html());

function increaseSectionCount() {
    initialSectionCounts++;
    console.log(initialSectionCounts);
    sectionCounts.html(initialSectionCounts)
    showHideSaveButton()
}
function decreaseSectionCount() {
    initialSectionCounts--
    sectionCounts.html(initialSectionCounts)
    showHideSaveButton()
}

// addSection();
// initial functions
function initialFunctions() {
    $('.section_subject').each(function () {
        var subjectId = $(this).val();
        var key = $(this).attr('key');
        if (subjectId) {
            changeSubject(subjectId, key,$("#class_group_exam_id").val()).finally(() => {
                var partId = $('#subject_part_' + key).attr('initialValue');
                if (partId) {
                    $('#subject_part_' + key).val(partId);
                    changeSubjectPart(partId, key).finally(() => {
                        var lessonId = $('#subject_part_lesson_' + key).attr('initialValue');
                        if (lessonId) {
                            $('#subject_part_lesson_' + key).val(lessonId);
                            changeSubjectChapter(lessonId,key).finally(() => {
                                gn_lessonId = $('#gn_subject_part_lesson_' + key).attr('initialValue');
                                if (gn_lessonId) {
                                    $('#gn_subject_part_lesson' + key).val(gn_lessonId);
                                }
                            })
                        }
                    })
                }
            })
        }
    })

}

initialFunctions();
sectionNumberGenerate();
initiatlQuestions();

function initiatlQuestions() {
    $('.section_questions').each(function() {
        var no_of_questions = $(this).attr('initialValue');
        var key             = $(this).attr('key');
        if(no_of_questions){
            onChangeQustions(no_of_questions,key).finally(()=>{
                var count  = parseInt(no_of_questions);
                $('#number_of_questions_'+key).val(count);
            });
        }
    });
}
// initial functions

function removeSection(id) {
    // console.log(id);
    if (!confirm('Are you sure to delete this section?, this is non revertable!!')) return false;
    // direct remove by ajax
    sectionNumberGenerate();
    decreaseSectionCount();
}
function removeDynamicSection(event) {
    $(event).parent().parent().parent().remove();
    decreaseSectionCount();
    // sectionCounts.html(initialSectionCounts);
    sectionNumberGenerate();
}

function addSection() {
    const html = $('#sectionTemplate');
    var template = jQuery.validator.format(
        $.trim(html.html())
    );
    increaseSectionCount();
    sectionCounts.html(initialSectionCounts);
    $(template(initialSectionCounts)).insertAfter($('.test_sections_div').last());
    if ($('#noSectionAlert').length) {
        $('#noSectionAlert').remove();
    }
    $('#saveButton').show();
    sectionNumberGenerate();

    $(".flatpickr").flatpickr({
        altInput: true,
        altFormat: "j F, Y",
        minDate: "today",
    });
}

function sectionNumberGenerate() {

    // var countings = $('.section_number').length;
    $('.section_number').each(function (index) {
        $(this).html(index + 1);
    })
}

function showHideSaveButton() {
    if (initialSectionCounts > 0) {
        showSaveButton()
    } else {
        hideSaveButton()
    }
}

function showSaveButton() {
    if ($('#saveSectionButton').hasClass('noDisplay')) {
        $('#saveSectionButton').removeClass('noDisplay');
    }
}

function hideSaveButton() {
    if ($('#saveSectionButton').hasClass('noDisplay')) {
    }
    else {
        $('#saveSectionButton').addClass('noDisplay');
    }
}

function notifyCreator(createrSelect, sectionId) {
    var creatorId = $('#' + createrSelect).val();

    var formData = new FormData();
    formData.append('form_name', 'notify_creator');
    formData.append('creatorId', creatorId);
    formData.append('sectionId', sectionId);

    console.log(Array.from(formData));
    // return;

    $.ajax({
        url: '',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (respone, textStatus, jqXHR) {
        console.log(respone);
        console.log(textStatus);
        console.log(jqXHR);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    })
}