var tinyMceOptions = {
    // selector: '.tinyMce',
    mode: 'textareas',
    paste_data_images: true,
    height: 300,
    branding: false,
    plugins: 'paste print preview importcss searchreplace autolink code autosave save directionality visualblocks visualchars fullscreen image link media table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount imagetools textpattern noneditable charmap',
    menubar: 'file edit view insert format tools table',
    // toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange removeformat | pagebreak | charmap | fullscreen  preview save print | insertfile image media template link anchor | a11ycheck ltr rtl | code',
    autosave_ask_before_unload: true,
    paste_as_text: true,
    autosave_interval: '30s',
    autosave_prefix: '{path}{query}-{id}-',
    autosave_restore_when_empty: false,
    autosave_retention: '2m',
    image_advtab: true,
    importcss_append: true,
    // quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: 'mceNonEditable',
    toolbar_mode: 'sliding',
    content_style: '.mymention{ color: gray; }',
    contextmenu: 'link image imagetools table configurepermanentpen',
    a11y_advanced_options: true,
    visualblocks_default_state: false,
    end_container_on_empty_block: true,
    toolbar1: 'fullscreen | alignleft aligncenter alignright alignjustify | outdent indent | charmap | numlist bullist | forecolor backcolor | insertfile image media | link anchor | pagebreak | ltr rtl | undo redo',
    image_title: true,
    automatic_uploads: true,
    file_picker_types: 'image',
    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), {
                    title: file.name
                });
            };
            reader.readAsDataURL(file);
        };
        input.click();
    },
    setup: function (editor) {
        editor.on('keydown', function () {
            editor.save();
        });
        editor.on('keyup', function () {
            editor.save();
        });
        editor.on('change', function () {
            editor.save();
        });
    },
    onchange_callback: function (editor) {
        tinyMCE.triggerSave();
        $("#" + editor.id).valid();
    }
};
tinymce.init(tinyMceOptions);

var inititalMcqAnswers = $('#inititalMcqAnswers');
var mcqAnswers = 0;
function increaseMcqAnswers() {
    mcqAnswers++
    inititalMcqAnswers.html(mcqAnswers)
    // showHideSaveButton()
}
function decreaseMcqAnswers() {
    mcqAnswers--
    inititalMcqAnswers.html(mcqAnswers)
    // showHideSaveButton()
}

$('.tinyMce').tinymce(tinyMceOptions);

function initiateTinyMce() {
    var solutionOption = tinyMceOptions;
    solutionOption.height = 200;
    $('.mcqanswer').tinymce(solutionOption);
}
initiateTinyMce();
$(function () {
    var validator = $("#questionForm").submit(function (event) {
        event.preventDefault();
        // update underlying textarea before submit validation
        tinyMCE.triggerSave();
    }).validate({
        errorClass: "text-danger",
        validClass: "text-success",
        ignore: "",
        rules: {
            question: "required",
            ans_1: "required",
            ans_2: "required",
            ans_3: "required",
            ans_4: "required",
            ans_5: "required"
        },
        errorPlacement: function (label, element) {
            // position error label after generated textarea
            if (element.is("textarea")) {
                label.insertAfter(element.next());
            } else {
                if ($(element).attr('type') == 'radio') {
                    label.insertAfter(element.next());
                } else {
                    label.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($(form)[0]);
            formData.append('form_name', 'submit_question');
            console.log(Array.from(formData));
            $.ajax({
                url: '/',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data, textStatus, request) {
                console.log(JSON.parse(data));
                console.log(textStatus);
                console.log(request);
                if (textStatus == 'success' && data == 'true') {
                    location.reload();
                }
            }).fail(function (request, textStatus) {
                console.log(request);
                console.log(textStatus);
            })
        }
    });
    validator.focusInvalid = function () {
        // put focus on tinymce on submit validation
        if (this.settings.focusInvalid) {
            try {
                var toFocus = $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []);
                if (toFocus.is("textarea")) {
                    tinyMCE.get(toFocus.attr("id")).focus();
                } else {
                    toFocus.filter(":visible").focus();
                }
            } catch (e) {
                // ignore IE throwing errors when focusing hidden elements
            }
        }
    }
})


// on select education type show class
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
                    var boards = JSON.parse(item.boards).join();
                    options += '<option value="' + item.id + '" board="' + boards + '">' + item.name + '</option>';
                });
                $('#education_type_child_id').removeAttr('disabled');
            } else {
                $('#education_type_child_id').val('');
                $('#education_type_child_id').attr('disabled', 'disabled');
                alert('No classes / Groups or Exams in this Type, please select another, or add some.');
            }
            // $('#education_type_child_id').html(options);
            $('#education_type_child_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}
// on select class show all other fields
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
function onChangeMcqOptions(value) {
    addRemoveMcqAnaswers(value, mcqAnswers);
}
async function onSelectQuestionType(questionType) {
    // console.log(questionType)
    if (questionType == 1) {
        $('#mcq_options').val(4);
        $('#mcq_options').removeAttr('disabled');
        // put answers html into mcqpanel
        addRemoveMcqAnaswers(4, 0);
        // show #mcq_answers
    }
    if (!questionType || questionType == 2) {
        $('#mcq_options').val(0);
        $('#mcq_options').attr('disabled', 'disabled');
        addRemoveMcqAnaswers(0, 5);
    }
}

function addRemoveMcqAnaswers(val1, val2) {
    const newValue = val1;
    const oldValue = val2;
    // console.log(newValue);
    // console.log(oldValue);
    return;
    if (newValue < oldValue) {
        for (var i = newValue; i < oldValue; i++) {
            removeDynamicAnswer();
            // console.log(newValue);
            // console.log(oldValue);
        }
    } else {
        for (var i = newValue; i > oldValue; i++) {
            console.log(newValue);
            console.log(oldValue);
            addMcqAnaswer();
        }
    }
}

function removeDynamicAnswer() {
    if ($('.mcq_answer_panel').length) {
        $('.mcq_answer_panel').last().remove();
        decreaseMcqAnswers();
    }
}

function addMcqAnaswer() {
    const html = $('#mcqAnswersDiv');
    var template = jQuery.validator.format(
        $.trim(html.html())
    );
    increaseMcqAnswers();
    if (mcqAnswers == 0) {
        $(template(mcqAnswers)).append($('#mcq_answers'));
    } else {
        $(template(mcqAnswers)).insertAfter($('.mcq_answer_panel').last());
    }
}