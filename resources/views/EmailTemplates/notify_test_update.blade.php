<!DOCTYPE html>
<html>

    <head>
        <title>Gyanology.com</title>
    </head>

    <body>
        <h3>Hello, </h3>
        <p>You have assigned a new test</p>
        <br />
        <br />
        <p>Subject: {{ $details['subject'] }}</p>
        <br />
        <p>Test Name: {{ $details['test_name'] }}</p>
        <br />
        @if (isset($details['institute_name']) && !empty(trim($details['institute_name'])))
            <p>By: {{ $details['institute_name'] }}</p>
            <br />
        @endif
        <br />
        <br />
        <p>
            Thank you <br>
            Team, Test & Notes
        </p>
    </body>

</html>
