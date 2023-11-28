<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>

<body>
    <p>
        Hello {{ $user->name }},
    </p>
    <p>
        Thank you for registering. Please click the following link to verify your email:
        <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
    </p>
    <p>
        If you did not create an account, no further action is required.
    </p>
</body>

</html>