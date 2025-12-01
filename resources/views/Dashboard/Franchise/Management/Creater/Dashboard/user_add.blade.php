@extends('Layouts.Management.creater')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .corporate-cards .content-wrapper .card {
            border: solid 1px black;
            margin: 10px 20px;
        }

        .corporate-cards td.userImageCell {
            width: 96px !important;
        }

        .corporate-cards .card .card-header {
            height: 40px;
            display: flex;
            justify-content: space-between;
            background-color: #19467a;
            border: 0px !important;
            height: 42px;
        }

        .corporate-cards textarea {
            margin: 10px 20px;
        }

        .corporate-cards .dropdown-label {
            font-size: 12px;
        }

        .corporate-cards input,
        .corporate-cards select {
            margin-left: auto;
            height: 30px;
            padding: 6px 12px;
            font-size: 12px;
            color: black;
        }

        .corporate-cards select {
            color: black;
            font-size: 12px;
        }

        .corporate-cards .input-group-text {
            height: 30px;
            width: 40px;
            border-radius: 0px;
        }

        .corporate-cards .status {
            background-color: #18c968;
            width: 100%;
        }

        .corporate-cards .btn-status {
            color: white !important;
            font-size: 15px !important;
            font-weight: 500 !important;
        }

        .corporate-cards .information-txt {
            font-size: 14px;
            font-weight: 500;
            padding-left: 22px !important;
        }

        .corporate-cards .btn-link {
            font-weight: 500 !important;
            font-size: 15px !important;
            text-decoration: underline;
        }

        .corporate-cards td b {
            font-size: 14px;
            text-align: right;
        }

        .corporate-cards .table {
            margin-bottom: 0px !important;
        }

        .corporate-cards td .btn {
            padding: 0 9px !important;
        }

        .corporate-cards .box {
            display: flex;
            margin-bottom: 10px;
        }

        .corporate-cards label.box-heading {
            width: 150px;
            display: flex;
            align-items: center;
            font-size: 12px;
            margin: auto;
            margin-left: auto;
            margin-right: 20px;
        }

        .corporate-cards .box-input {
            width: 100%;
            display: flex;
        }

        .corporate-cards .box-icon {
            width: 20px;
            height: 100%;
            background-color: gray;
        }

        .corporate-cards td .btn-link {
            font-size: 14px !important;
            text-decoration: none;
        }

        .corporate-cards .dropdown {
            position: relative;
            font-size: 14px;
            color: #333;
            width: 100%;
        }

        .corporate-cards .dropdown .dropdown-list {
            padding: 12px;
            background: #fff;
            position: absolute;
            top: 30px;
            z-index: 222;
            left: 2px;
            right: 2px;
            box-shadow: 0 1px 2px 1px rgba(0, 0, 0, 0.15);
            transform-origin: 50% 0;
            transform: scale(1, 0);
            transition: transform 0.15s ease-in-out 0.15s;
            overflow-y: scroll;
        }

        .corporate-cards .dropdown .dropdown-option {
            display: block;
            padding: 4px 12px;
            opacity: 0;
            transition: opacity 0.15s ease-in-out;
        }

        .corporate-cards .dropdown .dropdown-label {
            display: block;
            height: 30px;
            background: #fff;
            border: 1px solid #ccc;
            padding: 6px 12px;
            line-height: 1;
            cursor: pointer;
        }

        .corporate-cards .dropdown .dropdown-label:before {
            content: "";
            float: right;
        }

        .corporate-cards .dropdown.on .dropdown-list {
            transform: scale(1, 1);
            transition-delay: 0s;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .corporate-cards .dropdown-list a {
            margin-left: 17px;
        }

        .corporate-cards .dropdown.on .dropdown-list .dropdown-option {
            opacity: 1;
            display: flex;
            text-decoration: none;
            float: left;
            width: 100%;
            transition-delay: 0.2s;
            margin: 0px;
        }

        .corporate-cards .dropdown.on .dropdown-label:before {
            content: "";
        }

        .corporate-cards .dropdown [type="checkbox"] {
            position: relative;
            top: -4px;
            margin-right: 4px;
            margin-left: 0px !important;
        }

        .corporate-cards #get_otp {
            color: white;
            position: absolute;
            margin-top: -43px;
            margin-left: 147px;

            height: 33px;
            background-color: #2e3092;
        }

        .corporate-cards #verifyotp .a {
            align-items: center;
            color: blue;
            color: white;
            font-size: 16px;
            position: absolute;
            margin-top: -13px;
            margin-left: -75px;
            border-radius: 5px;
            padding: 2px 19px;
            /* height: 33px; */
            background-color: #2e3092;
        }

        .corporate-cards .contactsubmitbtn4 {
            color: white;
            position: absolute;
            margin-top: -43px;
            margin-left: 380px;
            width: 105px;
            font-size: 17px;
            height: 33px;
            background-color: #2e3092;
        }

        .corporate-cards .btn-primary {
            color: #fff;
            background-color: #2e3092;
            width: 110px;
            border-color: #2e3092;
        }

        .corporate-cards #profile_img {
            margin-right: -48px !important;
        }

        .corporate-cards select option {
            width: 250px !important;
            height: 10px !important;
        }

        .corporate-cards .bootstrap-select.btn-group .dropdown-menu.open {
            width: 250px !important;
            overflow: auto !important;
            background-color: red !important;
        }

        .corporate-cards .btn-new {
            background-color: #626f7c !important;
        }

        .corporate-cards .select-hidden {
            visibility: hidden;
            padding-right: 10px;
        }

        .corporate-cards .select {
            cursor: pointer;
            display: inline-block;
            position: relative;
            font-size: 12px;
            flex: 1;
            color: black;
        }

        .corporate-cards .select-styled {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            border: 1px solid #ced4da;
            padding: 2px 15px;
        }

        .corporate-cards .select-styled:after {
            content: "";
            width: 0;
            height: 0;
            border: 5px solid transparent;
            border-color: black transparent transparent transparent;
            position: absolute;
            top: 9px;
            right: 10px;
        }

        .corporate-cards .select-styled:hover {
            background-color: white;
        }

        .corporate-cards .select-styled:active,
        .corporate-cards .select-styled.active {
            background-color: white;
        }

        .corporate-cards .select-styled:active:after,
        .corporate-cards .select-styled.active:after {
            top: 5px;
            border-color: transparent transparent black transparent;
        }

        .corporate-cards .select-options {
            position: absolute;
            top: 100%;
            right: 0;
            left: 0;
            z-index: 999;
            margin: 0;
            padding: 2px 0px;
            list-style: none;
            background-color: white;
            box-shadow: 0 1px 2px 1px rgb(0 0 0 / 15%);
        }

        .corporate-cards .select-options li {
            margin: 0;
            padding: 6px 0;
            text-indent: 16px;
            /* border-top: 1px solid #19467a ; */
        }

        .corporate-cards .select-options li:hover {
            color: black;
            background: #fff;
        }

        .corporate-cards .select-options,
        .corporate-cards .select-hidden,
        .corporate-cards .select-options li[rel="hide"],
        .corporate-cards #reply-show,
        .corporate-cards #approved-show,
        .corporate-cards #pending-show,
        .corporate-cards #reject-show {
            display: none;
        }

        .corporate-cards .mid-content textarea {
            margin: 0px;
            width: 100%;
            height: 464px;
            border: 1px solid lightgray !important;
        }

        .corporate-cards .control-area {
            margin-left: auto;
            margin-top: 10px;
        }

        .action-button:not(:last-shild):after {
            content: " | "
        }

    </style>
@endsection
@section('main')
    <section class="content admin-1">
        <div class="row corporate-cards">
            <div class="col-md-6 col-12">
                <form class="card" id="reply-hidden" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header" style="background-color:#19467a; color: #fff;">
                        <h5>Create Contributor</h5>
                    </div>
                    <div class="card-body">
                        @error('userError')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        {{-- roles --}}
                        <div id="franchise_roles_div">
                            <div class="d-flex mb-2">

                                <label class="box-heading text-end">
                                    Select Role
                                </label>

                                <div class="box-input" id="franchiseRoleDiv">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-gear-fill"></i></span>
                                    <div class="dropdown" data-control="checkbox-dropdown">
                                        <label id="label2" class="dropdown-label">Select</label>

                                        <div class="dropdown-list">
                                            <label for="" class="dropdown-option">
                                                <input type="checkbox" value="Selection 0" data-toggle="check-all" />
                                                <a href="#" data-toggle="check-all" class="dropdown-option"
                                                    style="margin-left: -12px;color: #19467a;margin-top: -4px;">
                                                    Select all
                                                </a>
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]"
                                                    value="manager" />
                                                Manager
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]"
                                                    value="creator" />
                                                Creator
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]"
                                                    value="publisher" />
                                                Publisher
                                            </label>

                                            <!-- <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]"
                                                    value="verifier" />
                                                Verifier
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]"
                                                    value="reviewer" />
                                                Reviewer
                                            </label> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- institute --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Institute
                            </label>
                            <div class="box-input">
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect02">
                                        <i class="bi bi-intersect"></i>
                                    </label>
                                    <select class="form-select" id="inputGroupSelect02" name="institute_code" required>
                                        @foreach ($data['franchiseCodes'] as $franchiseCode)
                                            <option selected value="{{ $franchiseCode['branch_code'] }}">
                                                {{ $franchiseCode['institute_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- full name --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                User Image
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-image"></i></span>
                                    <input type="file" accept="image/jpeg,image/jpg,image/png" name="user_logo"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        {{-- full name --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Person name
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-person-fill"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Person name"
                                        required>
                                </div>
                            </div>
                        </div>
                        {{-- username --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Username
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" name="username"
                                        id="contributor_username">
                                </div>
                            </div>
                        </div>
                        {{-- subscription --}}
                        {{-- <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Duration
                            </label>
                            <div class="box-input">
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect01"><i
                                            class="bi bi-clock-fill"></i></label>
                                    <select class="form-select" id="inputGroupSelect01" name="days" data-style="btn-new"
                                        required>
                                        <option value="0">No subscription</option>
                                        <option value="3">3 days</option>
                                        <option value="7">7 days</option>
                                        <option value="15">15 days</option>
                                        <option value="30">30 days</option>
                                        <option value="60">60 days</option>
                                        <option value="90">3 months</option>
                                        <option value="120">4 months</option>
                                        <option value="150">5 months</option>
                                        <option value="180">6 months</option>
                                        <option value="270">9 months</option>
                                        <option value="365">1 year</option>
                                        <option value="730">2 year</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                        {{-- mobile --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Mobile
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-phone-fill"></i></span>
                                    <input type="number" min="2222222222" max="9999999999" class="form-control"
                                        placeholder="Mobile number" name="mobile" id="contributor_mobile" required>
                                </div>
                            </div>
                        </div>
                        {{-- email --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                E-mail
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control" placeholder="E-mail" id="contributor_email"
                                        name="email" required>
                                </div>
                            </div>
                        </div>
                        {{-- password --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Password
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control" placeholder="Password" name="password"
                                        required>
                                </div>
                            </div>
                        </div>
                        {{-- notes --}}
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Notes
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <i class="bi bi-compass-fill"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Required box">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Allowed content
                            </label>
                            <div class="box-input">
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect02">
                                        <i class="bi bi-intersect"></i>
                                    </label>
                                    <select class="form-select" id="inputGroupSelect02" name="allowed_to_upload"
                                        required>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                        {{-- status --}}
                        <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Status
                            </label>

                            <div class="box-input">
                                <!-- <div class="box-icon"></div> -->
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect03"><i
                                            class="bi bi-person-badge-fill"></i></label>
                                    <select class="form-select" id="inputGroupSelect03" name="status">
                                        <!-- <option selected>Select Option</option> -->
                                        <option value="inactive">
                                            Inactive</option>
                                        <option value="active">
                                            Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                            </label>

                            <div class="box-input">
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="toast align-items-center text-white border-0 position-absolute bottom-0 end-0 mb-3" data-delay="5000"
        role="alert" aria-live="assertive" aria-atomic="true" id="responseToast">
        <div class="d-flex">
            <div class="toast-body" id="responseToastMessage">
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();

        // async function checkCredentials(type, value) {
        //     var formData = new FormData();
        //     formData.append(type, value);
        //     formData.append('form_name', 'credentials_check');

        //     var returnResponse = true;

        //     await $.ajax({
        //         url: '/',
        //         type: 'post',
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //     }).done(function(response, textStatus) {
        //         console.log(response);
        //         returnResponse = response == 'true' ? true : false;
        //         console.log(textStatus);
        //     })
        //     return returnResponse;
        // }

        // function checkValidation() {
        //     var contributor_username = $('#contributor_username');
        //     var contributor_mobile = $('#contributor_mobile');
        //     var contributor_email = $('#contributor_email');
        //     if (contributor_username.val() !== '') {
        //         var response = checkCredentials('username', contributor_username.val());
        //         if (response) {
        //             alert('username already available');
        //         return false;
        //         }
        //     }
        //     if (contributor_mobile.val() !== '') {
        //         var response = checkCredentials('mobile', contributor_mobile.val());
        //         if (response) {
        //             alert('mobile already available');
        //         return false;
        //         }
        //     }
        //     if (contributor_email.val() !== '') {
        //         var response = checkCredentials('email', contributor_email.val());
        //         if (response) {
        //             alert('email already available');
        //         return false;
        //         }
        //     }
        // }
    </script>

    <script>
        (function($) {
            var CheckboxDropdown = function(el) {
                var _this = this;
                this.isOpen = false;
                this.areAllChecked = false;
                this.$el = $(el);
                this.$label = this.$el.find('.dropdown-label')
                this.$label1 = this.$el.find('#label1');
                this.$label2 = this.$el.find('#label2');
                this.$checkAll = this.$el.find('[data-toggle="check-all"]'); //first()
                this.$inputs = this.$el.find('[type="checkbox"]');

                this.onCheckBox();

                this.$label.on('click', function(e) {
                    e.preventDefault();
                    _this.toggleOpen();
                });

                this.$checkAll.on('click', function(e) {
                    e.preventDefault();
                    _this.onCheckAll();
                });

                this.$inputs.on('change', function(e) {
                    _this.onCheckBox();
                });
            };

            CheckboxDropdown.prototype.onCheckBox = function() {
                this.updateStatus();
            };

            CheckboxDropdown.prototype.updateStatus = function() {
                var checked = this.$el.find(':checked');

                this.areAllChecked = false;
                this.$checkAll.html('Select All');

                if (checked.length <= 0) {
                    this.$label1.html(
                        'Select Franchise <i class="fa fa-angle-down" style="float: right; font-size: 17px; font-weight: bold;"></i>'
                    );
                    this.$label2.html(
                        'Select role <i class="fa fa-angle-down" style="float: right; font-size: 17px; font-weight: bold;"></i>'
                    );
                } else if (checked.length === 1) {
                    this.$label.html(checked.parent('label').text());
                } else if (checked.length === this.$inputs.length) {
                    this.$label.html('All Selected');
                    this.areAllChecked = true;
                    this.$checkAll.html('Unselect All');
                } else {
                    this.$label.html(checked.length +
                        " selected <i class='fa fa-angle-down' style='float: right; font-size: 17px; font-weight: bold;'></i>"
                    );
                }

                // else {
                //   this.$label.html(checked.length + ' Selected');
                // }
            };

            CheckboxDropdown.prototype.onCheckAll = function(checkAll) {
                if (!this.areAllChecked || checkAll) {
                    this.areAllChecked = true;
                    this.$checkAll.html('Uncheck All');
                    this.$inputs.prop('checked', true);
                } else {
                    this.areAllChecked = false;
                    this.$checkAll.html('Check All');
                    this.$inputs.prop('checked', false);
                }

                this.updateStatus();
            };

            CheckboxDropdown.prototype.toggleOpen = function(forceOpen) {
                var _this = this;

                if (!this.isOpen || forceOpen) {
                    this.isOpen = true;
                    this.$el.addClass('on');
                    $(document).on('click', function(e) {
                        if (!$(e.target).closest('[data-control]').length) {
                            _this.toggleOpen();
                        }
                    });
                } else {
                    this.isOpen = false;
                    this.$el.removeClass('on');
                    $(document).off('click');
                }
            };

            var checkboxesDropdowns = document.querySelectorAll('[data-control="checkbox-dropdown"]');
            for (var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
                new CheckboxDropdown(checkboxesDropdowns[i]);
            }
        })(jQuery);

        $('.select').each(function() {
            var $this = $(this),
                numberOfOptions = $(this).children('option').length;

            $this.addClass('select-hidden');
            $this.wrap('<div class="select"></div>');
            $this.after('<div class="select-styled"></div>');

            var $styledSelect = $this.next('div.select-styled');
            $styledSelect.text($this.children('option').eq(0).text());

            var $list = $('<ul />', {
                'class': 'select-options'
            }).insertAfter($styledSelect);

            for (var i = 0; i < numberOfOptions; i++) {
                $('<li />', {
                    text: $this.children('option').eq(i).text(),
                    rel: $this.children('option').eq(i).val()
                }).appendTo($list);
            }

            var $listItems = $list.children('li');

            $styledSelect.click(function(e) {
                e.stopPropagation();
                $('div.select-styled.active').not(this).each(function() {
                    $(this).removeClass('active').next('ul.select-options').hide();
                });
                $(this).toggleClass('active').next('ul.select-options').toggle();
            });

            $listItems.click(function(e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));
                $list.hide();
                //console.log($this.val());
            });

            $(document).click(function() {
                $styledSelect.removeClass('active');
                $list.hide();
            });

        });
    </script>

@endsection
