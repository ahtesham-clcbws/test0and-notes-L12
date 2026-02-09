<div>
    @if ($educationType)
        <section class="page-title gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="breadcrumbs-wrap">
                            <h1 class="breadcrumb-title">{{ $educationType->name }}</h1>
                            <nav class="transparent">
                                <ol class="breadcrumb p-0">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active theme-cl" aria-current="page">{{ $educationType->name }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    @foreach ($classes as $class)
                        <div class="col-xl-2 col-lg-custom col-md-4 col-sm-6 col-12">
                            <div class="education-card">
                                <div class="card-image-wrapper">
                                    @if ($class->image)
                                        <img src="/storage/{{ $class->image }}" alt="{{ $class->name }}" class="card-img-top">
                                    @else
                                        <img src="{{ asset('default.webp') }}" alt="{{ $class->name }}" class="card-img-top">
                                    @endif
                                    <div class="card-overlay">
                                        <div class="overlay-content">
                                            <h5 class="card-title">{{ $class->name }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body-section p-2">
                                    @if($class->summary)
                                        <p class="card-description">{{ $class->summary }}</p>
                                    @endif
                                    <a href="{{ route('course.index', ['edu_type' => $educationType->id, 'class' => $class->id]) }}" class="btn-explore">
                                        Explore <i class="ti-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <style>
            /* Custom 5-column layout for large screens */
            @media (min-width: 992px) and (max-width: 1199px) {
                .col-lg-custom {
                    flex: 0 0 auto;
                    width: 20%;
                }
            }

            .education-card {
                background: #fff;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }

            .education-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0,0,0,0.12);
                border-color: transparent;
            }

            .card-image-wrapper {
                position: relative;
                overflow: hidden;
                height: 200px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .card-image-wrapper img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.3s ease;
            }

            .education-card:hover .card-image-wrapper img {
                transform: scale(1.1);
            }

            .card-overlay {
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.6) 50%, transparent 100%);
                padding: 0.75rem 1rem;
            }

            .overlay-content {
                width: 100%;
                color: white;
            }

            .card-title {
                font-size: 1rem;
                font-weight: 600;
                color: white;
                margin-bottom: 0;
                line-height: 1.3;
            }

            .card-body-section {
                padding: 1rem;
                background: white;
            }

            .card-description {
                color: #4a5568;
                font-size: 0.8rem;
                line-height: 1.4;
                margin-bottom: 0.75rem;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                transition: all 0.3s ease;
            }

            .education-card:hover .card-description {
                display: block;
                -webkit-line-clamp: unset;
                overflow: visible;
            }

            .btn-explore {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 0.75rem 1.25rem;
                background: #ff6600;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.9rem;
                transition: all 0.3s ease;
            }

            .btn-explore:hover {
                background: #e55a00;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
            }

            .btn-explore i {
                transition: transform 0.3s ease;
            }

            .btn-explore:hover i {
                transform: translateX(4px);
            }

            @media (max-width: 768px) {
                .card-image-wrapper {
                    height: 180px;
                }

                .card-content {
                    padding: 1.25rem;
                }
            }
        </style>
    @else
        <section class="page-title gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">

                        <div class="breadcrumbs-wrap">
                            <h1 class="breadcrumb-title">{{ $page->title }}</h1>
                            <nav class="transparent">
                                <ol class="breadcrumb p-0">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active theme-cl" aria-current="page">{{ $page->title }}</li>
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="lmp_caption">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif
</div>
