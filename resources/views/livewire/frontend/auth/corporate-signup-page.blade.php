<section>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                <div class="crs_log_wrap">
                    <form class="crs_log__caption" wire:submit.prevent="register">
                        <div class="rcs_log_124">
                            <div class="row py-3">
                                <div class="col">
                                    <h4 class="theme-cl">Corporate Signup</h4>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Institute / School Code *</label>
                                        <input
                                            class="form-control @if (!empty($school_code)) {{ $validSchoolCode ? 'is-valid' : 'is-invalid' }} @endif"
                                            id="school_code" type="text" wire:model.live.debounce.500ms="school_code"
                                            required />
                                    </div>
                                    @error('school_code')
                                        <p class="invalid-feedback d-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Verified Mobile No *</label>
                                        <input
                                            class="form-control @if (!empty($mobile_no)) {{ $validMobileNo ? 'is-valid' : 'is-invalid' }} @endif"
                                            id="Verified_Mobile" type="number" maxlength="10"
                                            wire:model.live.debounce.500ms="mobile_no" required />
                                    </div>
                                    @error('mobile_no')
                                        <p class="invalid-feedback d-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Verified E-mail ID *</label>
                                        <input
                                            class="form-control @if (!empty($verify_email)) {{ $validVerifyEmail ? 'is-valid' : 'is-invalid' }} @endif"
                                            id="verify_email" type="email"
                                            wire:model.live.debounce.500ms="verify_email" required />
                                    </div>
                                    @error('verify_email')
                                        <p class="invalid-feedback d-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Create password *</label>
                                        <div class="input-group mb-3">
                                            <input
                                                class="form-control @if (!empty($password)) {{ $validPassword ? 'is-valid' : 'is-invalid' }} @endif"
                                                id="password" type="password" wire:model.live.debounce.500ms="password"
                                                minlength="5" required />
                                            <button class="btn btn-dark togglePassword" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <p class="invalid-feedback d-block">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group smalls">
                                        <label>Confirm password *</label>
                                        <div class="input-group mb-3">
                                            <input
                                                class="form-control @if (!empty($confirm_password)) {{ $validConfirmPassword ? 'is-valid' : 'is-invalid' }} @endif"
                                                id="confirm_password" type="password"
                                                wire:model.live.debounce.500ms="confirm_password" minlength="5"
                                                required />
                                            <button class="btn btn-dark togglePassword" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('confirm_password')
                                        <p class="invalid-feedback d-block">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn full-width btn-md theme-bg text-white" id="corporate_submit_button"
                                    type="submit">
                                    <span wire:loading.remove wire:target='register'>Submit</span>
                                    <div wire:loading wire:target='register' class="spinner-border spinner-border-sm"
                                        role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span wire:loading wire:target='register'> Submitting...</span>
                                </button>
                            </div>
                            <div class="form-group mt-3">
                                <p class="text-center">
                                    Already have an account? <a class="modal-title theme-cl pointerCursor"
                                        href="{{ route('franchise.login') }}">Login Here</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@script
    <script>
        $wire.on('registration-success', () => {
            if (typeof showAlert === 'function') {
                showAlert("Thank you, we will activated your account once reviewed.").then(() => {
                    window.location.href = '{{ route('home_page') }}';
                });
            } else {
                // Fallback if showAlert is not defined
                alert("Thank you, we will activated your account once reviewed.");
                window.location.href = '{{ route('home_page') }}';
            }
        });
    </script>
@endscript
