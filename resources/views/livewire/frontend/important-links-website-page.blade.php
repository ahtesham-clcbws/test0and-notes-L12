<div>
    <style>
        .small {
            font-size: 80%;
        }

        .important-links-table a {
            color: inherit;
            font-weight: 500;
        }
    </style>
    <section class="page-title gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Important Links</h1>
                        <nav class="transparent">
                            <ol class="breadcrumb p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active theme-cl" aria-current="page">Important Links</li>
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
                    <div class="table-responsive">
                        <table class="table-bordered important-links-table table" style="line-height: 1.4;">
                            <tbody>
                                @foreach ($important_links as $important_link)
                                    <tr valign="middle">
                                        <td class="text-start">
                                            <a href="{{ $important_link->url }}" target="_blank">
                                                <img class="img-fluid" src="{{ '/storage/' . $important_link->image }}"
                                                    style="height: 35px;" />
                                            </a>
                                        </td>
                                        <td valign="middle">
                                            <div style="display: flex;align-items: center;height: 35px;">
                                                <a href="{{ $important_link->url }}" target="_blank">
                                                    {{ $important_link->title }}
                                                </a>
                                            </div>
                                        </td>
                                        <td valign="middle">
                                            <div style="display: flex;align-items: center;height: 35px;">
                                                <a href="{{ $important_link->url }}" target="_blank">
                                                    {{ $important_link->url }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
