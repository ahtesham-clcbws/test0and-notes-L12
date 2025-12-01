tinyMceOptions = {
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

if($('#questionsTable').length) {
    $('#questionsTable').DataTable({
        responsive: {
            details: true
        }
    })
}
questionsBankTable
if($('#questionsBankTable').length) {
    $('#questionsBankTable').DataTable({
        responsive: {
            details: true
        }
    })
}

$('.tinyMce').tinymce(tinyMceOptions);
var total_question = $('#total_question').val();

var solutionOption = tinyMceOptions;
solutionOption.height = 200;
$('.mcq_answers').tinymce(solutionOption);

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

    for (let key = 0; key < total_question; key++) {
        var validator = $("#questionForm-"+key).submit(function (event) {
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
            // highlight: function(element, errorClass, validClass) {
            //     $(element).closest('div').find('.tox-tinymce').css('border-color', 'red');
            // },
            // unhighlight: function(element, errorClass, validClass) {
            //     console.log(element)
            //     $(element).closest('div').find('tox-tinymce').css('border-color', 'green');
            // }
            submitHandler: function (form) {
                var formData = new FormData($(form)[0]);
                formData.append('form_name', 'submit_question');
                formData.append('form_type', 'edit_question');
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
    }
    
})

async function addQuestion(test_id,section_id,creater_id,question_id){
    var formData = new FormData();
    formData.append('form_name', 'add_questions_from_qb');
    formData.append('test_id', test_id);
    formData.append('section_id', section_id);
    formData.append('creater_id', creater_id);
    formData.append('question_id', question_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log('Question Added');
        location.reload();
    }).fail(function (data) {
        console.log(data);
    })  
}

async function removeQuestion(test_question_id) {
    var formData = new FormData();
    formData.append('form_name', 'remove_questions_from_test');
    formData.append('id', test_question_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log('Question deleted');
        location.reload();
    }).fail(function (data) {
        console.log(data);
    })  
}
// $('#questionForm').submit(function (event) {
//     event.preventDefault();
//     var formData = new FormData($(this)[0]);
//     console.log(Array.from(formData));
// })
// $("#questionForm").validate({
//     submitHandler: function (form) {
//         form.preventDefault();
//         var formData = new FormData($(form)[0]);
//         console.log(Array.from(formData));
//         // $(form).ajaxSubmit();
//     }
// });
// $("#question").closest('div').find('tox-tinymce').rules("add", {
//     required: true,
//     messages: {
//         required: "Required input",
//         minlength: jQuery.validator.format("Please, at least 1 characters are necessary")
//     }
// })
