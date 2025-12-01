<!DOCTYPE html>
<html>

<head>
    <title>Gyanology.com</title>
</head>

<body>
    <p>Hello, </p>
    <p>User {{ $details['fullname'] }} with email id {{ $details['email_id'] }} account is updated <?php if($details['institute_code']) echo 'with institute code '.$details['institute_code']?></p>
    <p>
        Thank you <br>
        Team, Gyanology
    </p>
</body>

</html>