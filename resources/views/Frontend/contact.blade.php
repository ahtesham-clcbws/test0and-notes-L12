@extends('Layouts.frontend')

@section('main')
    <!-- ============================ Page Title Start================================== -->
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Get In Touch</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">Contact Us</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Page Title End ================================== -->

    <!-- ============================ Contact Detail ================================== -->
    <section>
        <div class="container">
            <div class="row align-items-start">
                <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                    <div class="form-group">
                        <h4>We'd love to here from you</h4>
                        <span>Send a message and we'll responed as soos as possible </span>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" placeholder="Name" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" placeholder="Email" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Company</label>
                                <input class="form-control" type="text" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" type="text" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button class="btn theme-bg btn-md text-white" type="button">Send Message</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="lmp_caption pl-lg-5">
                        <ol class="list-unstyled p-0">
                            <li class="d-flex align-items-start my-md-4 my-3">
                                <div
                                    class="rounded-circle p-sm-4 d-flex align-items-center justify-content-center theme-bg-light p-3">
                                    <div class="position-absolute theme-cl h5 mb-0"><i class="fas fa-home"></i></div>
                                </div>
                                <div class="ml-md-4 ml-3">
                                    <h4>Reach Us</h4>
                                    <p>
                                        2512, New Market,<br>Eliza Road, Sincher 80 CA,<br>Canada, USA
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start my-md-4 my-3">
                                <div
                                    class="rounded-circle p-sm-4 d-flex align-items-center justify-content-center theme-bg-light p-3">
                                    <div class="position-absolute theme-cl h5 mb-0"><i class="fas fa-at"></i></div>
                                </div>
                                <div class="ml-md-4 ml-3">
                                    <h4>Drop A Mail</h4>
                                    <p>
                                        support@Rikada.com<br>Rikada@gmail.com
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start my-md-4 my-3">
                                <div
                                    class="rounded-circle p-sm-4 d-flex align-items-center justify-content-center theme-bg-light p-3">
                                    <div class="position-absolute theme-cl h5 mb-0"><i class="fas fa-phone-alt"></i></div>
                                </div>
                                <div class="ml-md-4 ml-3">
                                    <h4>Make a Call</h4>
                                    <p>
                                        (41) 123 521 458<br>+91 235 548 7548
                                    </p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Contact Detail ================================== -->

    <!-- ============================ map Start ================================== -->
    <section class="p-0">
        <iframe class="full-width"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7566.724875278171!2d73.91609277175066!3d18.5125167233502!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c1d12884d373%3A0xbc0a8429b1a695dd!2sPentagon%202!5e0!3m2!1sen!2sin!4v1659693901421!5m2!1sen!2sin"
            style="border:0;" height="450" allowfullscreen="" loading="lazy"></iframe>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ map End ================================== -->
@endsection
