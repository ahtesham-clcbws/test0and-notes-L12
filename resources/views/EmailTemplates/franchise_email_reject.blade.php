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
        We are sorry to inform you that your business request is rejected by our Authorisation Team. <br>
        The rejection was made, due to insufficient/wrong information while physical inspection by the authorisation
        team. <br>
        You may contact on our whatsapp no for further enquiry. <br>
        Our bussiness whatsapp no is: <br>
        {{ env('BUSSINESS_WHATSAPP') }}
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
