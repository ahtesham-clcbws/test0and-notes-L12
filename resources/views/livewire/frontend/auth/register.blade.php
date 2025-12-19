<div>
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Register</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">Register</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">

            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-8 col-sm-12 login-form mx-auto">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input class="form-control" id="fname_new" name="full_name" type="text"
                                            placeholder="Student's name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input class="form-control" id="email_new" name="email" type="email"
                                            oninput="uniqueEmailCheck(this)"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="E-mail"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input class="form-control" id="mobile_register" name="mobile_number"
                                            type="number" oninput="mobileNumberCheck(this, 'register')" minlength="10"
                                            maxlength="10" required placeholder="Mobile">
                                        <button class="btn theme-bg append text-white" type="button"
                                            style="width: 70px;" onclick="sendOtp('register')">
                                            Get OTP
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input class="d-none" id="verifystatus_register" name="verifystatus_register"
                                value="0">
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti-key"></i>
                                        </span>
                                        <input class="form-control" id="mobile_otp_register" name="mobile_otp"
                                            type="number" minlength="6" maxlength="6" required
                                            placeholder="Input OTP">
                                        <button class="btn theme-bg append text-white" type="button"
                                            style="width: 70px;" onclick="verifyOtp('register')">
                                            Verify
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti-unlock"></i>
                                        </span>
                                        <input class="form-control" id="password" name="password" type="password"
                                            type="password" placeholder="Password" required minlength="5"
                                            oninput="validatePassword(this)">
                                        <button class="btn theme-bg togglePassword" type="button" style="width: 70px;">
                                            <i class="fas fa-eye text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti-unlock"></i>
                                        </span>
                                        <input class="form-control" id="confirm_password_new" name="confirm_password"
                                            type="password" placeholder="Confirm Password" required minlength="5"
                                            oninput="inputConfirmPassword(this)">
                                        <button class="btn theme-bg togglePassword" type="button"
                                            style="width: 70px;">
                                            <i class="fas fa-eye text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input class="d-none" id="verifystatus_institute" value="0">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti-ink-pen"></i>
                                        </span>
                                        <input class="form-control" id="branch_code_new" name="institute_code"
                                            type="text" placeholder="Your institute code (If any)">
                                        <button class="btn theme-bg append text-white" type="button"
                                            style="width: 70px;" onclick="verifyInstitute()">
                                            Verify
                                        </button>
                                    </div>
                                    <input class="form-control" id="institute_name" type="text"
                                        style="display: none;" readonly disabled>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <!-- <label>Education Type</label> -->
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                        </span>
                                        <select class="form-control" id="education_type_id" name="education_type_id"
                                            onchange="getClassesByEducation(this.value)" required>
                                            <option value="" selected>Education Type</option>
                                            @if (isset($gn_EduTypes))
                                                @foreach ($gn_EduTypes as $u)
                                                    <option value="{{ $u->id }}">
                                                        {{ $u->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <!-- <label>Education Type</label> -->
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                        </span>
                                        <select class="form-control" id="class_group_exam_id"
                                            name="class_group_exam_id" required>
                                            <option value="" selected>Class/Group/Exam Name</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label>You can attach jpeg / png files (max size: 200 kb)</label>
                                    <input class="form-control" id="user_logo" name="user_logo" type="file">
                                </div>
                            </div>
                            <div class="form-group col-6 mb-2">
                                <input class="checkbox-custom" id="required_check_registration" type="checkbox"
                                    required>
                                @if (isset($pdf))
                                    <label class="checkbox-custom-label" for="required_check_registration">I agree
                                        to The
                                        gyanology's <a class="theme-cl" href="{{ url('public/' . $pdf->url) }}"
                                            target="_blank">Terms
                                            of
                                            Services</a></label>
                                @else
                                    <label class="checkbox-custom-label" for="required_check_registration">I agree
                                        to The
                                        gyanology's <a class="theme-cl" href="#">Terms of
                                            Services</a></label>
                                @endif
                            </div>
                            <div class="col-6 mb-2 text-end">
                                <small>
                                    <a class="theme-cl pointerCursor fw-bold" href="{{ route('login') }}">
                                        Already have account? Login
                                    </a>
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-sm full-width theme-bg text-white" type="submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
