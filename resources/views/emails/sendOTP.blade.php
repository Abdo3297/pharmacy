<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Page</title>
    <link rel="stylesheet" href="{{ asset('assets/css/otp.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab">
</head>

<body>
    <div class="body">
        <div class="logo">
            <img src="{{ $logoUrl }}" alt="Pharmacy Logo">
        </div>
        <div class="username">
            <p class="UserName">Hello {{ $name }}</p>
            <p class="text1">Here is your verification code</p>
            <p class="code">{{ $otp }}</p>
            <p class="text2">Please make sure you never share this code with anyone.</p>
            <p class="note">This code will expire in {{ $valid }} minutes.</p>
        </div>
    </div>
</body>

</html>


