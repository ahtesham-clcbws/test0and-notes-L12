<div>
    <style>
        .form-group {
            margin-bottom: 10px;
        }
    </style>
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Contributor Sign up</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">Contributor Sign up</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-6">
                    <div class="crs_log_wrap pb-4 pt-4" style="margin-top:-50px;border: 1px solid #03b97c;">
                        <form class="crs_log__caption" wire:submit.prevent="register">
                            <fieldset class="rcs_log_124" wire:target="register" wire:loading.attr="disabled">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group smalls">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-user"></i>
                                                </span>
                                                <input class="form-control" type="text" wire:model="name"
                                                    placeholder="Contributor name">
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group smalls">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-email"></i>
                                                </span>
                                                <input class="form-control" id="email_new" type="email"
                                                    wire:model="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                    placeholder="E-mail">
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group smalls flex-nowrap">
                                            <div class="box-input">
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i
                                                            class="ti-mobile"></i></span>
                                                    <input class="form-control" id="mobile_register" type="number"
                                                        wire:model="mobile" min="10" placeholder="Mobile number"
                                                        {{ $otpVerificationStatus && $isOtpSend ? ' readonly ' : '' }}>
                                                    <button class="btn theme-bg-dark append text-white" type="button"
                                                        style="padding:0; width: 90px; {{ $isOtpSend ? ' background-color: #07ad7f !important; ' : '' }}" wire:click="getOtp">
                                                        <span wire:target="getOtp" wire:loading>Sending OTP...</span>
                                                        <span wire:target="getOtp" wire:loading.remove>{{ $isOtpSend ? 'Sent OTP' : 'Get OTP' }}</span>
                                                    </button>
                                                </div>
                                                @error('mobile')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group smalls flex-nowrap">
                                            <div class="box-input">
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text">
                                                        <i class="ti-key"></i>
                                                    </span>
                                                    <input class="form-control" id="mobile_otp_register" type="number"
                                                        wire:model="mobile_otp" minlength="6" maxlength="6"
                                                        placeholder="Input OTP"
                                                        {{ $otpVerificationStatus && $isOtpSend ? ' readonly ' : '' }}>
                                                    <button class="btn theme-bg-dark append text-white" type="button"
                                                        style="padding:0;width: 90px; {{ $otpVerificationStatus && $isOtpSend ? ' background-color: #07ad7f !important; ' : '' }}" wire:click="verifyOtp">
                                                        <span wire:target="verifyOtp" wire:loading>Verifying
                                                            OTP...</span>
                                                        <span wire:target="verifyOtp"
                                                            wire:loading.remove>{{ $otpVerificationStatus && $isOtpSend ? 'Verified' : 'Verify' }}</span>
                                                    </button>
                                                </div>
                                                @error('mobile_otp')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group smalls flex-nowrap">
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text">
                                                    <i class="ti-unlock"></i>
                                                </span>
                                                <input class="form-control" id="password" type="password"
                                                    value="" wire:model="password" placeholder="Password">
                                                <button class="btn btn-dark togglePassword" type="button"
                                                    style="width: 42px;">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group smalls">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-unlock"></i>
                                                </span>
                                                <input class="form-control" id="confirm_password_new" type="password"
                                                    wire:model="confirm_password" placeholder="Confirm Password"
                                                    minlength="5">
                                                <button class="btn btn-dark togglePassword" type="button"
                                                    style="width: 42px;">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('confirm_password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group smalls">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-ink-pen"></i>
                                                </span>
                                                <input class="form-control" id="branch_code_new" type="text"
                                                    wire:model="institute_code" placeholder="Branch Code"
                                                    {{ $institute_name ? ' readonly ' : '' }}>
                                                <button class="btn theme-bg-dark append text-white" type="button"
                                                    style="width: 90px; {{ $institute_name ? ' background-color: #07ad7f !important; ' : '' }}" wire:click="verifyInstitute"
                                                    {{ $institute_name ? ' disabled ' : '' }}>
                                                    <span wire:target="verifyInstitute"
                                                        wire:loading>Verifying...</span>
                                                    <span wire:target="verifyInstitute"
                                                        wire:loading.remove>{{ $institute_name ? 'Verified' : 'Verify' }}</span>
                                                </button>

                                            </div>
                                            @if ($institute_name)
                                                <div class="mt-2">
                                                    <input class="form-control" type="text"
                                                        value="{{ $institute_name }}" readonly disabled>
                                                </div>
                                            @endif
                                            @error('institute_code')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group smalls">
                                        <label>You can attach jpeg / png files (max size: 200 kb)</label>
                                        <input class="form-control" id="user_logo" type="file"
                                            wire:model="user_logo">
                                        @error('user_logo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <input class="checkbox-custom" id="required_check_registration"
                                            type="checkbox" wire:model="required_check_registration">
                                        <label class="checkbox-custom-label" for="required_check_registration">I agree
                                            to The
                                            gyanology's <a class="theme-cl" target="_target" href="{{  route('policy-page', ['terms-and-conditions']) }}">Terms of
                                                Services</a></label>
                                    </div>
                                    @error('required_check_registration')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-sm full-width theme-bg text-white" type="submit"
                                        style="margin-top:10px;margin-bottom:10px;">Register</button>
                                </div>

                                <div class="col">
                                    <p class="text-center">
                                        <a class="modal-title theme-cl pointerCursor" href="{{ route('management_login') }}">
                                            Already have an account? Login
                                        </a>
                                    </p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
