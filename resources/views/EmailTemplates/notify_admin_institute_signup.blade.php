<!DOCTYPE html>
<html>

<head>
    <title>Test and Notes.com</title>
</head>

<body>
    <p>Hello, </p>
    <p>Institue {{ $details['fullname'] }} with email id {{ $details['email_id'] }}  <?php if($details['institute_code']) echo 'with institute code '.$details['institute_code']?> registered</p>
    <p>
        Thank you <br>
        Team, Test and Notes
    </p>
</body>

</html>