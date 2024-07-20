<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Complaint Letter</title>
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab">
</head>

<body>
    <div class="body">
        <div class="logo">
            <img src="{{ $logoUrl }}" alt="Pharmacy Logo">
        </div>
        <h1 class="LetterHead">Complaint Letter</h1>
        <div class="LetterForm">
            <p class="UserName"><span>UserName:</span> {{ $name }}</p>
            <p class="Phone"><span>Phone:</span> {{ $phone }}</p>
            <p class="email"><span>Email:</span> {{ $email }}</p>
            <p>Complaint </p>
            <p class="complaintText">
                {{ $complaintMessage }}
            </p>
    
    
        </div>
    </div>
</body>

</html>

