<div>
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Login</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">Login</li>
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
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12 login-form mx-auto">
                    <form wire:submit.prevent="login">
                        <div class="form-group mb-3">
                            <label>Mobile / Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti-user"></i>
                                </span>
                                <input class="form-control" wire:model="username" id="username" name="username" type="text" required
                                    placeholder="Mobile or email">
                            </div>
                            @error('username')
                                <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="plan_input">
                            <input name='planclick' type='hidden' value='0'>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti-unlock"></i>
                                </span>
                                <input class="form-control" wire:model="password" id="userpass" name="password" type="password"
                                    placeholder="">
                                <button class="btn theme-bg togglePassword" type="button" style="width: 42px;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div class="fhg_45">
                                    <p class="musrt">
                                        <input class="checkbox-custom" wire:model="remember_me" id="remember_me" name="remember_me"
                                            type="checkbox">
                                        <label class="checkbox-custom-label" for="remember_me">Remember
                                            Me</label>
                                    </p>
                                </div>
                                <div class="fhg_45">
                                    <p class="musrt">
                                        <a class="text-danger" href="{{ route('forgot_password') }}">Forgot Password?</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button class="btn btn-sm full-width theme-bg text-white" type="submit">Login</button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <p class="text-center">
                                    <a class="modal-title theme-cl pointerCursor" href="{{ route('register') }}">
                                        Don't have account? SignUp
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
