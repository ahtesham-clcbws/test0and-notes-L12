<!DOCTYPE html>
<html>

<head>
    <title>Test and Notes.com</title>
</head>

<body>
    <div style="font-family: Helvetica,Arial,sans-serif;min-width:200px;overflow:auto;line-height:2">
        <div style="margin:50px auto;width:70%;padding:20px 0">
            <div style="border-bottom:1px solid #eee">
                <span style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Test and Notes</span>
            </div>
            <p style="font-size:1.1em">Hi, {{ $details['name'] }}</p>
            <p>Please use below link to verify and reset your password, or input below code manually.</p>
            <p><a href='{{ $details['verifyLink'] }}'></a>{{ $details['verifyLink'] }}</p>
            {{-- <h2
                style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">
                {{ $details['resetCode'] }}
            </h2> --}}
            <p style="font-size:0.9em;">Thank You,<br />Team Test and Notes</p>
        </div>
    </div>
</body>

</html>
