<!DOCTYPE html>
<html>

<head>
    <title>Test and Notes.com</title>
</head>

<body>
    <p>
        Dear <br>
        Director / Manager <br>
        {{ $details['institute_name'] }}
    </p>

    <p>
        We are glad to inform you that your business request is approved by our Authorisation Team. <br>
        We alloted a unique code for your institute whish is required to sign up / registration process. <br>
        <a href="http://testandnotes.com">www.testandnotes.com</a> <br>
        Your institute code is: <br>
        <b>{{ $details['institute_code'] }}</b> <br>
        Please sign up with this unique code.
    </p>

    <p>
        Regards: <br>
        Sales Team <br>
        XXXXXXXXXXXXXXXXXXXX <br>
        0000000000 <br>
        <a href="http://testandnotes.com">www.testandnotes.com</a>
    </p>

</body>

</html>
