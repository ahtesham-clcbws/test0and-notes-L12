<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body { background-color: #F8F9FA; padding: 15px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        .checkout-container { background: #ffffff; border-radius: 16px; box-shadow: 0 6px 20px rgba(0,0,0,0.06); padding: 24px; margin-top: 15px; border: 1px solid #ECEFF1; }
    </style>
    @yield('css')
</head>
<body>
    <div class="container">
        <div class="checkout-container">
            @yield('main')
        </div>
    </div>
    @yield('javascript')
</body>
</html>
