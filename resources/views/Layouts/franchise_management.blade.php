<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }} " rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css" />

    @yield('css')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('super/style.css') }}"> --}}
    <style>
        .franchise-dashboard .custom-dash-card {
            box-shadow: 0px 0px 5px 1px #888888 !important;
            border-radius: 10px !important;
            border: 1px solid black !important;
            margin-bottom: 1rem;
        }
        .franchise-dashboard .custom-dash-card .number,
        .franchise-dashboard .custom-dash-card .action_required a {
            color: red;
        }
    </style>
</head>

<body>

    @include('Dashboard.Franchise.Management.partials.mainheader')

    <div class="container-fluid">
        <div class="row">
            @include('Dashboard.Franchise.Management.partials.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="pt-3 pb-2 custom-dashboard">
                    <div class="w-100 dashboard-header mb-4">
                        <h2 class="d-inline-block">
                            <i class="bi bi-{{ isset($pageicon) ? $pageicon : 'house-fill' }}"></i>
                            {{ isset($data['pagename']) ? $data['pagename'] : 'Contributor Dashboard' }}
                        </h2>
                    </div>
                    @yield('main')
                </div>
            </main>
        </div>
    </div>


    @if (session()->has('loginSuccess'))
        <div class="toast align-items-center text-white bg-primary border-0 position-absolute bottom-0 end-0 mb-3"
            role="alert" aria-live="assertive" aria-atomic="true" id="myToastEl">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('loginSuccess') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif

    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': csrfToken
            }
        });
        feather.replace({
            'aria-hidden': 'true'
        })
        if (document.getElementById('myToastEl')) {
            var myToastEl = document.getElementById('myToastEl');
            var myToast = new bootstrap.Toast(myToastEl)
            myToast.show();
        }
        $(".flatpickr").flatpickr({
            altInput: true,
            altFormat: "j F, Y",
            minDate: "today",
        });
        $(".flatpickrtime").flatpickr({
            altInput: true,
            altFormat: "j F, Y - H:i K",
            enableTime: true,
            minDate: "today",
            minTime: "10:00",
        });
        $('.validate').keyup(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid')
                $(this).removeClass('is-valid')
            } else {
                $(this).removeClass('is-invalid')
                $(this).addClass('is-valid')
            }
        })
    </script>
    @yield('javascript')
</body>

</html>
