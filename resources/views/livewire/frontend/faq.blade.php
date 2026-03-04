<div>
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">FAQ</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">FAQ</li>
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
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
                    <div class="accordion" id="accordionExample">

                        @foreach ($faqs as $faq)
                            <div class="card">
                                <div class="card-header border-0 bg-white" id="faq_{{ $faq->id }}_heading">
                                    <h6 class="accordion_title mb-0"><a
                                            class="d-block position-relative text-dark collapsible-link collapsed py-2"
                                            data-bs-toggle="collapse" data-bs-target="#collapse_{{ $faq->id }}"
                                            href="#" aria-expanded="false"
                                            aria-controls="collapse_{{ $faq->id }}">{{ $faq->question }}</a></h6>
                                </div>
                                <div class="collapse" id="collapse_{{ $faq->id }}" data-parent="#accordionExample"
                                    aria-labelledby="faq_{{ $faq->id }}_heading" style="">
                                    <div class="card-body pe-3 ps-3 pt-0">{{ $faq->answer }}</div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
