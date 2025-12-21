@extends('Layouts.frontend')

@section('css')
<style>
    #corporate .input-group .btn {
        min-width: 85px;
    }
</style>
@endsection
@section('main')

<section>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                <div class="crs_log_wrap">
                    <form class="crs_log__caption" id="corporate" enctype="multipart/form-data" style="z-index: 1;">
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
                                        <label>Type if Institution *</label>
                                        <div class="input-group">
                                            <select name="institute_type[]" id="institute_type" class="form-control"
                                                multiple required>
                                                @foreach (franchiseTypes() as $institute)
                                                <option value="{{ $institute['name'] }}">
                                                    {{ $institute['name'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Interested For *</label>
                                        <div class="input-group">
                                            <select name="interested_for[]" id="interested_for" class="form-control"
                                                multiple required>
                                                @foreach (corporateInterests() as $corporate)
                                                <option value="{{ $corporate['name'] }}">
                                                    {{ $corporate['name'] }}
                                                </option>
                                                @endforeach
                                            </select>
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
                                        <div class="col">
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
                                        <div class="col" id="citiesDiv">
                                            <div class="form-group smalls">
                                                <label>Select City *</label>
                                                <div class="input-group">
                                                    <select class="form-control selectTwo" id="city_id_franchise"
                                                        name="city_id">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
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
    $("#corporate_logo").change(function() {

        var photo = $("#corporate_logo").val();
        var ext = $("#corporate_logo").val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'png']) == -1) {
            swal({
                title: "Oh!Snap",
                text: "Only Accept JPEG/JPG/PNG Files ",
                icon: "error",
                button: "close!",
            });
            $("#corporate_logo").val("");
            $("#corporate_logo").focus();

        } else {
            var file, img, height, width;
            var a = (this.files[0].size);
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    alert("width : " + this.width + " and height : " + this.height);
                    width = this.width;
                    height = this.height;
                    console.log(height);
                    console.log(width);

                };
            }
            if (parseInt(width) > 1000 || parseInt(height) > 1000) {

                swal({
                    title: "Oh!Snap",
                    text: "Image Width & Height Must be 1000px X 1000px",
                    icon: "error",
                    button: "close!",
                });
                $("#corporate_logo").val('');
                $('#corporate_logo').closest('div').find('.custom-file-label').html('Choose File')
                // $("#corporate_logo").focus();

            } else {

                if ((Math.round(a) / 1024) > 200) {

                    swal({
                        title: "Oh!Snap",
                        text: "Image Size Must be under 200 KB",
                        icon: "error",
                        button: "close!",
                    });
                    $("#corporate_logo").val('');
                    $('#corporate_logo').closest('div').find('.custom-file-label').html('Choose File')
                    // $("#corporate_logo").focus();

                } else {

                    //readURL(this);

                }
            }
        }
    });
    var corporateEmailValid = false;
    var corporateMobileValid = false;
    $('#institute_type').select2({
        maximumSelectionLength: 3
    });
    $('#interested_for').select2({
        maximumSelectionLength: 3
    });

    function franchiseStateSelected(event) {
        console.log(event.value);
        var formData = new FormData();
        formData.append('form_name', 'get_cities');
        formData.append('state_id', event.value);
        $.ajax({
            url: '/',
            data: formData,
            type: 'post',
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
            // return;
            if (data != 'false') {
                // var options = '<option value="">Cities</option>';
                var options = '<option selected value=""></option>';
                var cities = JSON.parse(data);
                if (cities.length) {
                    $(cities).each(function(index, city) {
                        options += '<option value="' + city.id + '">' + city.name + '</option>';
                    });
                    $('#city_id_franchise').html(options);
                    $('#city_id_franchise').attr('required', 'required');
                    $('#citiesDiv').show();
                    initSelect2();
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
        }).fail(function(data) {
            $('#citiesDiv').hide();
            $('#city_id_franchise').html('');
            $('#city_id_franchise').removeAttr('required');
            console.log(data);
        });
    }
    $('#corporate').submit(function(event) {
        event.preventDefault();
        $('#corporate_submit_button').html('Submitting...');
        var formData = new FormData($(this)[0]);
        console.log(Array.from(formData));
        formData.append('form_name', 'corporate_form');
        if ($('#verifystatus_corporate').val() == 1) {
            $.ajax({
                // url: '/',
                data: formData,
                processData: false,
                type: 'post',
                contentType: false
            }).done(function(data) {
                console.log(data);
                if (data == true) {
                    showAlert("Thank you, we will reach back to you within 72 hours.").then(() => {
                        // $("#corporateModal").modal('hide');
                        window.location.href = "{{ route('home_page') }}";
                    });
                } else {
                    showAlert('Server issue, please try again later.', 'Error', 'error');
                }
            }).fail(function(data) {
                $('#corporate_submit_button').html('Submit');
                showAlert('Server Error, please try again later.', 'Error', 'error');
                console.log(data)
            })
        } else {
            $('#corporate_submit_button').html('Submit');
            showAlert('Verify your number first before continue.', 'Error', 'warning');
        }
    });
</script>
@endsection
