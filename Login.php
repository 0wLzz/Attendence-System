<?php
    require_once "database/database.php";
    if(isset($_COOKIE["email"])){
        $_SESSION["login"] = true;
    }
    
    if(isset($_SESSION["login"])){
        header("Location: index.php");
    }
    
    if(isset($_POST["loginBtn"])){
        login($_POST);
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <title>Login Page | Owen Limantoro || Michella Anjani || Stefani Maria</title>

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            font-family: 'Montserrat', sans-serif; /* Use the Montserrat font */
            overflow: hidden; /* Hide overflow to prevent scrolling */
            position: relative;
            margin: 0;
        }

        .background-animation {
            height: 100%;
            width: 100%;
            background-image: url('https://www.architecture.com.au/wp-content/uploads/06_5777_educational_binuscampusmalang_dcm-jakarta_binus.jpg');
            background-size: cover; /* Make the background image cover the entire container */
            background-position: center; /* Center the background image */
            position: absolute;
        }

        .wrapper {
            height: 100%;
            width: 100%;
            position: absolute;
            overflow: hidden;
        }

        .wrapper h1 {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            position: absolute;
            font-family: sans-serif;
            letter-spacing: 1px;
            word-spacing: 2px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .wrapper div {
            height: 60px;
            width: 60px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            position: absolute;
            top: 10%;
            left: 10%;
            animation: animate 4s linear infinite;
        }

        .wrapper div .dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            position: absolute;
            top: 20%;
            right: 20%;
        }

        .wrapper div:nth-child(1) {
            top: 20%;
            left: 20%;
            animation: animate 8s linear infinite;
        }

        .wrapper div:nth-child(2) {
            top: 60%;
            left: 80%;
            animation: animate 10s linear infinite;
        }

        .wrapper div:nth-child(3) {
            top: 40%;
            left: 40%;
            animation: animate 3s linear infinite;
        }

        .wrapper div:nth-child(4) {
            top: 66%;
            left: 30%;
            animation: animate 7s linear infinite;
        }

        .wrapper div:nth-child(5) {
            top: 90%;
            left: 10%;
            animation: animate 9s linear infinite;
        }

        .wrapper div:nth-child(6) {
            top: 30%;
            left: 60%;
            animation: animate 5s linear infinite;
        }

        .wrapper div:nth-child(7) {
            top: 70%;
            left: 20%;
            animation: animate 8s linear infinite;
        }

        .wrapper div:nth-child(8) {
            top: 75%;
            left: 60%;
            animation: animate 10s linear infinite;
        }

        .wrapper div:nth-child(9) {
            top: 50%;
            left: 50%;
            animation: animate 6s linear infinite;
        }

        .wrapper div:nth-child(10) {
            top: 45%;
            left: 20%;
            animation: animate 10s linear infinite;
        }

        .wrapper div:nth-child(11) {
            top: 10%;
            left: 90%;
            animation: animate 9s linear infinite;
        }

        .wrapper div:nth-child(12) {
            top: 20%;
            left: 70%;
            animation: animate 7s linear infinite;
        }

        .wrapper div:nth-child(13) {
            top: 20%;
            left: 20%;
            animation: animate 8s linear infinite;
        }

        .wrapper div:nth-child(14) {
            top: 60%;
            left: 5%;
            animation: animate 6s linear infinite;
        }

        .wrapper div:nth-child(15) {
            top: 90%;
            left: 80%;
            animation: animate 9s linear infinite;
        }

        @keyframes animate {
            0% {
                transform: scale(0) translateY(0) rotate(70deg);
            }

            100% {
                transform: scale(1.3) translateY(-100px) rotate(360deg);
            }
        }

        .box {
            max-width: 400px;
            margin: auto;
            margin-top: 10%;
            background-color: #ffffff; /* White box background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
            position: absolute;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #007bff; /* Bootstrap primary color */
            margin-bottom: 20px;
        }

        .container {
            margin-top: 20px;
        }

        .form-floating input {
            border-radius: 5px;
        }

        .form-check-input {
            margin-top: 4px;
        }

        .btn-primary {
            width: 100%;
            border-radius: 15px;
        }
    </style>
</head>

<body class="">

    <div class="background-animation"></div>
    <div class="wrapper">
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
    </div>
    <div class="box" id="box" style="margin-top: 20px;">
        <div class="title">
            <span style="text-align: center; font-size: 45px;">Login Page</span>
        </div>

        <form action="" method="POST">
            <div class="container">
                <div class="form-floating my-3">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                    <label for="email">Email address</label>
                </div>

                <!-- Password -->
                <div class="form-floating my-3">
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                    <label for="password">Password</label>
                </div>

                <!-- CheckBox -->
                <div class="my-3">
                    <input class="form-check-input" type="checkbox" value="" id="checkbox" name="checkbox">
                    <label class="form-check-label" for="checkbox">Remember Me</label>
                </div>

                <!-- Login Button -->
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary my-3" name="loginBtn">Login</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
