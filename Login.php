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
    <title>Login Page | owenlimantoro_</title>

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>
<body class="">
    <div class="box" id="box">
        <div class="title"> 
            <span>Login Page</span> 
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
                    <input class="form-check-input border border-1 border-black " type="checkbox" value="" id="checkbox" name="checkbox">
                    <label for="checkbox">Remember Me</label>
                </div>
    
                <!-- Login Button -->
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary my-3" name="loginBtn">
                    Login
                    </button>
                </div>
            </div>
        </form>

    </div>
</body>
</html>