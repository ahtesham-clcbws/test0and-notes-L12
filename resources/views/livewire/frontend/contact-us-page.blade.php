<div>
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
                <div class="col-xl-7 col-md-12 col-sm-12">
                    <div class="border p-3 rounded">
                    <div class="form-group">
                        <h4>We'd love to here from you</h4>
                        <span>Send a message and we'll responed as soos as possible </span>
                    </div>
                    <form class="row mt-4" wire:submit="sendContact">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <input class="form-control @error('form.name') is-invalid @enderror" type="text" placeholder="Full Name" wire:model="form.name" />
                                @error('form.name')
                                    <div class="d-block invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <input class="form-control @error('form.phone') is-invalid @enderror" type="text" placeholder="Valid Mobile Number"
                                    wire:model="form.phone" />
                                @error('form.phone')
                                    <div class="d-block invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <input class="form-control @error('form.email') is-invalid @enderror" type="text" placeholder="Valid Email"
                                    wire:model="form.email" />
                                @error('form.email')
                                    <div class="d-block invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <input class="form-control @error('form.city') is-invalid @enderror" type="text" placeholder="City/District/State"
                                    wire:model="form.city" />
                                @error('form.city')
                                    <div class="d-block invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <select class="form-control @error('form.subject') is-invalid @enderror" wire:model="form.subject">
                                    <option value="">Select Reason to Contact</option>
                                    <option value="Student's Application Related Issue">Student's Application
                                        Related Issue</option>
                                    <option value="Student's Admit Card Related Issue">Student's Admit Card
                                        Related Issue</option>
                                    <option value="Student's Result Related Issue">Student's Result Related
                                        Issue</option>
                                    <option value="Institutional Enquiry / Signup">Institutional Enquiry /
                                        Signup</option>
                                    <option value="Institutional Login Issue">Institutional Login Issue
                                    </option>
                                    <option value="Other Issues">Other Issues</option>
                                </select>
                                @error('form.subject')
                                    <div class="d-block invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <textarea class="form-control @error('form.query') is-invalid @enderror" placeholder="Your Query ..." wire:model="form.query"></textarea>
                                @error('form.query')
                                    <div class="d-block invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button class="btn theme-bg btn-md fw-bold text-white" type="submit"
                                    wire:loading.attr="disabled" wire:target="sendContact">
                                    <div class="spinner-border spinner-border-sm" role="status" wire:loading
                                        wire:target="sendContact">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span wire:loading wire:target="sendContact">Sending ...</span>
                                    <span wire:loading.remove wire:target="sendContact">Send Message</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>

                <div class="col-xl-5 col-md-12 col-sm-12">
                    <div class="lmp_caption pl-lg-5">
                        <ol class="list-unstyled p-0">
                            <li class="d-flex align-items-start my-md-4 my-3">
                                <div
                                    class="rounded-circle p-sm-4 d-flex align-items-center justify-content-center theme-bg-light p-3">
                                    <div class="position-absolute theme-cl h5 mb-0"><i class="fas fa-home"></i></div>
                                </div>
                                <div class="ms-md-4 ms-3">
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
                                <div class="ms-md-4 ms-3">
                                    <h4>Drop A Mail</h4>
                                    <p>
                                        support@Rikada.com<br>Rikada@gmail.com
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start my-md-4 my-3">
                                <div
                                    class="rounded-circle p-sm-4 d-flex align-items-center justify-content-center theme-bg-light p-3">
                                    <div class="position-absolute theme-cl h5 mb-0"><i class="fas fa-phone-alt"></i>
                                    </div>
                                </div>
                                <div class="ms-md-4 ms-3">
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
</div>
