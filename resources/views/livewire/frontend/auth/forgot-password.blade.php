<div>
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Forget Password</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">Forget Password</li>
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
                    <form>
                        @csrf
                        <div class="form-group mb-3">
                            <label>Student Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti-user"></i>
                                </span>
                                <input class="form-control" id="forget_email" name="forget_email" type="email"
                                    required placeholder="E-Mail">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button class="btn btn-sm full-width theme-bg text-white"
                                    type="submit">Request</button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <p class="text-end">
                                    <a class="fw-bold theme-cl pointerCursor" href="{{ route('login') }}">
                                        Back to Login
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
