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
    <link rel="icon" href="{{ asset('logos/logo-white-square.png') }}" type="image/x-icon">
    <link rel="shortcut-icon" href="{{ asset('logos/logo-white-square.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('logos/logo-white-square.png') }}">

    <!-- Bootstrap core CSS -->
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <style>
        html,
        body {
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
            font-family: 'Numans', sans-serif;
        }

        .container {
            height: 100%;
            align-content: center;
        }

        .card {
            height: 370px;
            margin-top: auto;
            margin-bottom: auto;
            width: 400px;
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        .card-header h3 {
            color: white;
            font-size: 20px;
        }

        .social_icon {
            position: absolute;
            right: 20px;
            top: -45px;
        }

        .input-group-prepend span {
            width: 50px;
            background-color: #FFC312;
            color: black !important;
            border: 0 !important;
        }

        .btn-link {
            color: #FFC312; !important;
        }
        .btn-link:hover {
            color: red; !important;
        }

        input:focus {
            outline: 0 0 0 0 !important;
            box-shadow: 0 0 0 0 !important;
        }

        .social_icon img {
            max-height: 65px;
        }

        .remember {
            color: white;
        }

        .remember input {
            width: 20px;
            height: 20px;
            margin-left: 15px;
            margin-right: 5px;
        }

        .login_btn {
            color: black;
            background-color: #FFC312;
            width: 100px;
            font-weight: 700;
        }

        .login_btn:hover {
            color: black;
            background-color: white;
        }

        .links {
            color: white;
        }

        .links a {
            margin-left: 4px;
        }

        #loginLink,
        #forgetForm {
            display: none;
        }

        /* // yellow - admin / red - institute / purple - contributer / green - student */

    </style>

</head>

<body style="background-image: url({{ asset('login-background.jpg') }});">

    <div class="container">
        <div class="d-flex justify-content-center h-100">
            @yield('form')
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <!-- <script src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script> -->

    <script>
        function showForget() {
            $('#forgetForm').toggle();
            $('#loginForm').toggle();
            $('#forgetLink').toggle();
            $('#loginLink').toggle();
        }

        function hideForget() {
            var url_string = window.location.href;
            var arr = url_string.split('?');
            if (arr.length > 1) {
                window.location.href = '{{ route('franchise.login') }}'
            } else {
                showForget();
            }
        }

        $('.togglePassword').on('click', function() {
            var passwordInput = $(this).closest('.input-group').find('.form-control');
            var icon = $(this).find('.fas');
            if (passwordInput.attr('type') == 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye');
                icon.addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash');
                icon.addClass('fa-eye');
            }
        })
    </script>

    @if (isset($_GET['password_reset']))
        <script>
            $('#forgetForm').toggle();
            $('#loginForm').toggle();
            $('#forgetLink').toggle();
            $('#loginLink').toggle();
        </script>
    @endif
    @error('franchiseError')
        <script>
            $('#forgetForm').toggle();
            $('#loginForm').toggle();
            $('#forgetLink').toggle();
            $('#loginLink').toggle();
        </script>
    @enderror
    @error('franchiseSuccess')
        <script>
            $('#forgetForm').toggle();
            $('#loginForm').toggle();
            $('#forgetLink').toggle();
            $('#loginLink').toggle();
        </script>
    @enderror
</body>

</html>
