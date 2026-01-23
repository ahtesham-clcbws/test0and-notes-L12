<!DOCTYPE html>
<html>

<head>
    <title>Test and Notes.com</title>
</head>

<body>
    <p>Hello, </p>
    <p>Student {{ $details['fullname'] }} with email id {{ $details['email_id'] }} registered <?php if($details['institute_code']) echo 'with institute code '.$details['institute_code']?></p>
    <p>
        Thank you <br>
        Team, Test and Notes
    </p>
</body>

</html>