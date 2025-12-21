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
                    <form wire:submit.prevent="register">

                        <fieldset wire:target="register" wire:loading.attr="disabled">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-user"></i>
                                            </span>
                                            <input class="form-control" type="text" wire:model="form.full_name"
                                                placeholder="Student's name">
                                        </div>
                                        @error('form.full_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
 
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-email"></i>
                                            </span>
                                            <input class="form-control" type="email"placeholder="E-mail"
                                                wire:model="form.email">
                                        </div>
                                        @error('form.email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
 
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-mobile"></i>
                                            </span>
                                            <input class="form-control" type="number" wire:model="form.mobile_number"
                                                minlength="10" maxlength="10" placeholder="Mobile"
                                                {{ $otpVerificationStatus && $isOtpSend ? ' readonly ' : '' }}>
                                            <button class="btn theme-bg append text-white" type="button"
                                                style="min-width: 70px;" wire:click="getOtp">
                                                <span wire:target="getOtp" wire:loading>Sending OTP...</span>
                                                <span wire:target="getOtp" wire:loading.remove>Get OTP</span>
                                            </button>
                                        </div>
                                        @error('form.mobile_number')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-key"></i>
                                            </span>
                                            <input class="form-control" type="number" wire:model="form.mobile_otp"
                                                minlength="6" maxlength="6" placeholder="Input OTP"
                                                {{ $otpVerificationStatus && $isOtpSend ? ' readonly ' : '' }}>
                                            <button class="btn theme-bg append text-white" type="button"
                                                style="min-width: 70px;" wire:click="verifyOtp">
                                                <span wire:target="verifyOtp" wire:loading>Verifying OTP...</span>
                                                <span wire:target="verifyOtp" wire:loading.remove>{{ $otpVerificationStatus && $isOtpSend ? 'Verified' : 'Verify' }}</span>
                                            </button>
                                        </div>
                                        @error('form.mobile_otp')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-unlock"></i>
                                            </span>
                                            <input class="form-control" type="password" wire:model="form.password"
                                                placeholder="Password" minlength="8">
                                            <button class="btn theme-bg togglePassword" type="button"
                                                style="width: 70px;">
                                                <i class="fas fa-eye text-white"></i>
                                            </button>
                                        </div>
                                        @error('form.password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-unlock"></i>
                                            </span>
                                            <input class="form-control" type="password"
                                                wire:model="form.confirm_password" placeholder="Confirm Password"
                                                minlength="8">
                                            <button class="btn theme-bg togglePassword" type="button"
                                                style="width: 70px;">
                                                <i class="fas fa-eye text-white"></i>
                                            </button>
                                        </div>
                                        @error('form.confirm_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-ink-pen"></i>
                                            </span>
                                            <input class="form-control" type="text"
                                                wire:model="form.institute_code"
                                                placeholder="Your institute code (If any)"
                                                {{ $institute_name ? ' readonly ' : '' }}>
                                            <button class="btn theme-bg append text-white" type="button"
                                                style="min-width: 70px;" wire:click="verifyInstitute"
                                                {{ $institute_name ? ' disabled ' : '' }}>
                                                <span wire:target="verifyInstitute" wire:loading>Verifying...</span>
                                                <span wire:target="verifyInstitute" wire:loading.remove>{{ $institute_name ? 'Verified' : 'Verify' }}</span>
                                            </button>
                                        </div>
                                        @if ($institute_name)
                                            <div class="mt-2">
                                                <input class="form-control" type="text"
                                                    value="{{ $institute_name }}" readonly disabled>
                                            </div>
                                        @endif
                                        @error('form.institute_code')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                            </span>
                                            <select class="form-control" wire:model.live="form.education_type_id">
                                                <option value="" selected>Education Type</option>
                                                @foreach (gn_EduTypes() as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form.education_type_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-users" aria-hidden="true"></i>
                                            </span>
                                            <select class="form-control" wire:model="form.class_group_exam_id"
                                                {{ !$form->education_type_id ? ' disabled ' : '' }}>
                                                <option value="" selected>Class/Group/Exam Name</option>
                                                @foreach (App\Models\ClassGoupExamModel::where('education_type_id', $form->education_type_id)->get() as $c)
                                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form.class_group_exam_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label>You can attach jpeg / png file (max size: 200 kb)</label>
                                        <input class="form-control" type="file" wire:model="form.user_logo"
                                            accept=".jpeg,.jpg,.png">
                                        @error('form.user_logo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 d-md-flex justify-content-between">
                                    <div class="form-group mb-2">
                                        <input class="checkbox-custom" id="terms_check_box" type="checkbox"
                                            wire:model="form.required_check_registration">
                                        @if (isset($pdf))
                                            <label class="checkbox-custom-label" for="terms_check_box">I agree
                                                to The
                                                gyanology's <a class="theme-cl"
                                                    href="{{ url('public/' . $pdf->url) }}" target="_blank">Terms
                                                    of
                                                    Services</a></label>
                                        @else
                                            <label class="checkbox-custom-label" for="terms_check_box">I agree
                                                to The
                                                gyanology's <a class="theme-cl" href="#">Terms of
                                                    Services</a></label>
                                        @endif
                                        @error('form.required_check_registration')
                                            <br />
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2 text-end">
                                        <small>
                                            <a class="theme-cl pointerCursor fw-bold" href="{{ route('login') }}">
                                                Already have account? Login
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-sm full-width theme-bg text-white" type="submit">
                                    <span wire:loading wire:target="register">Registering...</span>
                                    <span wire:loading.remove wire:target="register">Register</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
