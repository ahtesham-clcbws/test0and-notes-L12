@extends('Layouts.frontend')

@section('css')
<style>
    #corporate .input-group .btn {
        min-width: 85px;
    }
    .custom-multi-select .multi-select-btn {
        background-color: #fff;
        min-height: 48px;
        border: 1px solid #e0e6ed;
        border-radius: 4px;
        padding: 10px 14px;
        cursor: pointer;
        width: 100%;
        text-align: left;
    }
    .custom-multi-select .multi-select-btn:after {
        display: none;
    }
    .custom-multi-select .dropdown-menu {
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .custom-multi-select .multi-select-option {
        transition: background-color 0.15s ease-in-out;
        white-space: normal;
        user-select: none;
        cursor: pointer;
    }
    .custom-multi-select .multi-select-option:hover {
        background-color: #f1f5f9;
    }
    .custom-multi-select .multi-select-option input[type="checkbox"] {
        cursor: pointer;
        width: 16px;
        height: 16px;
    }
</style>
@endsection
@section('main')

<section>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                <div class="crs_log_wrap">
                    <form class="crs_log__caption" id="corporate" method="POST" action="{{ route('bussines_enquiry') }}" onsubmit="return false;" enctype="multipart/form-data" style="z-index: 1;">
                        <div class="rcs_log_124">
                            <div class="row py-3">
                                <div class="col">
                                    <h4 class="theme-cl">Corporate Enquiry</h4>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Full Name *</label>
                                        <input type="text" class="form-control" name="name" id="fname_corporate" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Institute / School / Brand Name *</label>
                                        <input type="text" class="form-control" name="institute_name"
                                            id="institute_name_corporate" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Mobile No *</label>
                                        <div class="input-group">
                                            <input type="number" id="mobile_corporate"
                                                oninput="mobileNumberCheck(this, 'corporate')" name="contact_mobile"
                                                class="form-control" minlength="10" maxlength="10" required>
                                            <button class="btn theme-bg-dark text-white" type="button"
                                                id="button-mobile-otp" onclick="sendOtp('corporate')">Get OTP</button>
                                        </div>
                                    </div>
                                </div>
                                <input id="verifystatus_corporate" name="verifystatus_corporate" class="d-none"
                                    value="0">

                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Input OTP *</label>
                                        <div class="input-group">
                                            <input type="number" minlength="6" maxlength="6"
                                                name="mobile_corporate_otp_new" id="mobile_otp_corporate"
                                                class="form-control" required>
                                            <button class="btn theme-bg-dark text-white" type="button"
                                                id="button-mobile-otp-verify"
                                                onclick="verifyOtp('corporate')">Verify</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Type of Institution *</label>
                                        <div class="dropdown custom-multi-select" id="multi_select_institute_type" data-max="3" data-placeholder="Select Type of Institution">
                                            <button class="form-control text-start d-flex justify-content-between align-items-center dropdown-toggle multi-select-btn"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    data-bs-auto-close="outside"
                                                    aria-expanded="false">
                                                <span class="multi-select-label text-truncate text-muted">Select Type of Institution</span>
                                                <i class="ti-angle-down ms-2 small"></i>
                                            </button>
                                            <div class="dropdown-menu p-2 w-100" style="max-height: 260px; overflow-y: auto;">
                                                <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom px-1">
                                                    <small class="text-muted count-indicator">Select up to 3</small>
                                                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 clear-btn text-danger small">Clear</button>
                                                </div>
                                                @foreach (franchiseTypes() as $institute)
                                                <label class="dropdown-item d-flex align-items-center py-2 px-2 rounded multi-select-option">
                                                    <input type="checkbox" name="institute_type[]" value="{{ $institute['name'] }}" class="form-check-input me-2 mt-0">
                                                    <span class="small">{{ $institute['name'] }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Interested For *</label>
                                        <div class="dropdown custom-multi-select" id="multi_select_interested_for" data-max="3" data-placeholder="Select Interested For">
                                            <button class="form-control text-start d-flex justify-content-between align-items-center dropdown-toggle multi-select-btn"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    data-bs-auto-close="outside"
                                                    aria-expanded="false">
                                                <span class="multi-select-label text-truncate text-muted">Select Interested For</span>
                                                <i class="ti-angle-down ms-2 small"></i>
                                            </button>
                                            <div class="dropdown-menu p-2 w-100" style="max-height: 260px; overflow-y: auto;">
                                                <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom px-1">
                                                    <small class="text-muted count-indicator">Select up to 3</small>
                                                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 clear-btn text-danger small">Clear</button>
                                                </div>
                                                @foreach (corporateInterests() as $corporate)
                                                <label class="dropdown-item d-flex align-items-center py-2 px-2 rounded multi-select-option">
                                                    <input type="checkbox" name="interested_for[]" value="{{ $corporate['name'] }}" class="form-check-input me-2 mt-0">
                                                    <span class="small">{{ $corporate['name'] }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Established Year *</label>
                                        <div class="input-group">
                                            <select class="form-control selectTwo" name="established_year"
                                                id="established_year" required>
                                                <option value=""></option>
                                                @for ($i = date('Y'); $i > 1999; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                                <option value="1999">Before 2000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Email *</label>
                                        <input type="email" class="form-control" name="email" id="email_corporate"
                                            required oninput="uniqueEmailCheck(this, 'corporate')" />
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group smalls">
                                                <label>Select State *</label>
                                                <div class="input-group">
                                                    <select class="form-control selectTwo" id="state_id_franchise"
                                                        name="state_id" onchange="franchiseStateSelected(this)"
                                                        required>
                                                        <option selected value=""></option>
                                                        @foreach (getStates() as $state)
                                                        <option value="{{ $state['id'] }}">{{ $state['name'] }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12" id="citiesDiv">
                                            <div class="form-group smalls">
                                                <label>Select City *</label>
                                                <div class="input-group">
                                                    <select class="form-control selectTwo" id="city_id_franchise"
                                                        name="city_id">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group smalls">
                                                <label>Pincode *</label>
                                                <div class="input-group">
                                                    <input name="pincode" id="pincode_corporate" class="form-control"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group mb-3">
                                        <label>You can attach jpeg / png files (max size: 200 kb)</label>
                                        <div class="custom-file">
                                            <input name="corporate_logo" id="corporate_logo" type="file"
                                                class="custom-file-input">
                                            <label class="custom-file-label" for="corporate_logo">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group mb-3">
                                        <label>Institute images pdf</label>
                                        <div class="custom-file">
                                            <input name="institute_images_pdf" id="institute_images_pdf" type="file"
                                                class="custom-file-input" accept="application/pdf">
                                            <label class="custom-file-label" for="institute_images_pdf">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <input id="terms_checkbox" type="checkbox" required>
                                        <label for="terms_checkbox">I agree to <a href="https://testandnotes.com/terms-and-conditions" target="_blank">Terms & Conditions</a></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" id="corporate_submit_button"
                                    class="btn full-width btn-md theme-bg text-white">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('js')
<script>
    function initCustomMultiSelect(selector) {
        var $el = $(selector);
        var placeholder = $el.data('placeholder') || 'Select options';
        var max = parseInt($el.data('max')) || 3;
        var $label = $el.find('.multi-select-label');
        var $indicator = $el.find('.count-indicator');
        var $checkboxes = $el.find('input[type="checkbox"]');
        var $clearBtn = $el.find('.clear-btn');

        function syncUI() {
            var $checked = $checkboxes.filter(':checked');
            var count = $checked.length;

            if (count === 0) {
                $label.text(placeholder).addClass('text-muted').removeClass('text-dark fw-medium');
                $indicator.text('Select up to ' + max);
            } else {
                var firstText = $checked.first().next('span').text().trim();
                if (count === 1) {
                    $label.html('<span class="text-truncate">' + firstText + '</span>')
                          .removeClass('text-muted').addClass('text-dark fw-medium');
                } else {
                    var extra = count - 1;
                    $label.html('<span class="text-truncate">' + firstText + '</span> <span class="badge bg-secondary ms-1">+' + extra + '</span>')
                          .removeClass('text-muted').addClass('text-dark fw-medium');
                }
                $indicator.text(count + ' of ' + max + ' selected');
            }

            if (count >= max) {
                $checkboxes.not(':checked').prop('disabled', true).closest('.multi-select-option').addClass('text-muted opacity-50');
            } else {
                $checkboxes.prop('disabled', false).closest('.multi-select-option').removeClass('text-muted opacity-50');
            }
        }

        $checkboxes.on('change', function() {
            syncUI();
        });

        $clearBtn.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $checkboxes.prop('checked', false);
            syncUI();
        });

        syncUI();
    }

    $(document).ready(function() {
        initCustomMultiSelect('#multi_select_institute_type');
        initCustomMultiSelect('#multi_select_interested_for');
    });

    $("#corporate_logo").change(function() {
        var fileInput = this;
        if (!fileInput.files || !fileInput.files[0]) {
            return;
        }
        var file = fileInput.files[0];
        var ext = file.name.split('.').pop().toLowerCase();
        if ($.inArray(ext, ['jpg', 'jpeg', 'png']) == -1) {
            showAlert("Only JPG, JPEG, and PNG files are allowed.", "Invalid File", "error");
            $(fileInput).val("");
            $(fileInput).closest('.custom-file').find('.custom-file-label').html('Choose File');
            return;
        }

        if (file.size > 200 * 1024) {
            showAlert("Image size must be under 200 KB.", "File Too Large", "error");
            $(fileInput).val("");
            $(fileInput).closest('.custom-file').find('.custom-file-label').html('Choose File');
            return;
        }

        $(fileInput).closest('.custom-file').find('.custom-file-label').html(file.name);
    });

    $("#institute_images_pdf").change(function() {
        var fileInput = this;
        if (!fileInput.files || !fileInput.files[0]) {
            return;
        }
        var file = fileInput.files[0];
        var ext = file.name.split('.').pop().toLowerCase();
        if (ext !== 'pdf') {
            showAlert("Only PDF files are allowed.", "Invalid File", "error");
            $(fileInput).val("");
            $(fileInput).closest('.custom-file').find('.custom-file-label').html('Choose File');
            return;
        }
        $(fileInput).closest('.custom-file').find('.custom-file-label').html(file.name);
    });

    var corporateEmailValid = false;
    var corporateMobileValid = false;

    function franchiseStateSelected(event) {
        var stateId = $(event).val();
        if (!stateId) {
            $('#city_id_franchise').html('<option value="">Select City</option>');
            return;
        }
        var formData = new FormData();
        formData.append('form_name', 'get_cities');
        formData.append('state_id', stateId);
        $.ajax({
            url: '/',
            data: formData,
            type: 'post',
            processData: false,
            contentType: false
        }).done(function(data) {
            if (data && data != 'false') {
                var options = '<option value="">Select City</option>';
                var cities = (typeof data === 'string') ? JSON.parse(data) : data;
                if (cities && cities.length) {
                    $.each(cities, function(index, city) {
                        options += '<option value="' + city.id + '">' + city.name + '</option>';
                    });
                    $('#city_id_franchise').html(options);
                    $('#city_id_franchise').attr('required', 'required');
                    $('#citiesDiv').show();
                    if (typeof initSelect2 === 'function') {
                        initSelect2();
                    }
                } else {
                    $('#citiesDiv').hide();
                    $('#city_id_franchise').html('');
                    $('#city_id_franchise').removeAttr('required');
                }
            } else {
                $('#citiesDiv').hide();
                $('#city_id_franchise').html('');
                $('#city_id_franchise').removeAttr('required');
            }
        }).fail(function(xhr) {
            console.error('Failed to load cities:', xhr);
        });
    }

    $('#corporate').on('submit', function(event) {
        event.preventDefault();

        if ($('#verifystatus_corporate').val() != 1) {
            showAlert('Please verify your mobile number with OTP before continuing.', 'Verification Required', 'warning');
            return false;
        }

        if ($('#multi_select_institute_type input[type="checkbox"]:checked').length === 0) {
            showAlert('Please select at least one Type of Institution.', 'Required Field', 'warning');
            return false;
        }

        if ($('#multi_select_interested_for input[type="checkbox"]:checked').length === 0) {
            showAlert('Please select at least one option you are Interested For.', 'Required Field', 'warning');
            return false;
        }

        var submitBtn = $('#corporate_submit_button');
        submitBtn.prop('disabled', true).html('Submitting...');
        var formEl = this;
        var formData = new FormData(formEl);
        formData.append('form_name', 'corporate_form');

        $.ajax({
            url: "{{ route('bussines_enquiry') }}",
            data: formData,
            processData: false,
            type: 'POST',
            contentType: false
        }).done(function(data) {
            console.log('Submission response:', data);
            if (data == true || (data && data.success)) {
                showAlert("Thank you! We will reach back to you within 72 hours.", "Success", "success").then(() => {
                    window.location.href = "{{ route('home_page') }}";
                });
            } else {
                submitBtn.prop('disabled', false).html('Submit');
                showAlert('Server issue, please try again later.', 'Error', 'error');
            }
        }).fail(function(xhr) {
            submitBtn.prop('disabled', false).html('Submit');
            var errorMsg = 'An error occurred. Please check the form and try again.';
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                var firstKey = Object.keys(xhr.responseJSON.errors)[0];
                errorMsg = xhr.responseJSON.errors[firstKey][0];
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            showAlert(errorMsg, 'Validation Error', 'error');
            console.error('Submission error:', xhr);
        });

        return false;
    });
</script>
@endsection
