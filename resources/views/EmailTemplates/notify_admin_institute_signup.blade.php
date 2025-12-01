<!DOCTYPE html>
<html>

<head>
    <title>Gyanology.com</title>
</head>

<body>
    <p>Hello, </p>
    <p>Institue {{ $details['fullname'] }} with email id {{ $details['email_id'] }}  <?php if($details['institute_code']) echo 'with institute code '.$details['institute_code']?> registered</p>
    <p>
        Thank you <br>
        Team, Gyanology
    </p>
</body>

</html>