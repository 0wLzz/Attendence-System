<?php

session_start();
$conn = "";
$stmt = "";

function connectToDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "company_database";
    $dataSourceName = "mysql:host=" . $servername . ";dbname=" . $dbName;

    try{
        $conn = new PDO($dataSourceName, $username, $password);
    
        return $conn;

    }

    catch(PDOException $e){
        echo $e->getMessage();
        return null;
    }
}

function closeConnection()
{
    $conn = null;
    $stmt = null;
}

function login($data)
{
    $conn = connectToDB();
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([
        $data["email"]
    ]);
    $user = $stmt->fetch();
    if($user){
        $validated = (md5($data["password"]) === $user["password"]);
        if($validated){
            $_SESSION["login"] = "true";
            if(isset($data["checkbox"])){
            setcookie("email", $data["email"], time()*60);
            }
            header("Location: index.php");
        }else{
            echo '<script>alert("Your PASSWORD is Incorrect!!!");</script>';
        }
    }
    else{
        echo '<script>alert("Your EMAIL address is unregistered!!!");</script>';
    }    
    closeConnection();   
}

function getAllUsers()
{
    $conn = connectToDB();
    $stmt = $conn -> query("SELECT * FROM users");
    $users = [];
    while($user = $stmt -> fetch(PDO::FETCH_ASSOC)){
        array_push($users, $user);
    }
    return $users;

    closeConnection();
}

function getAdmin()
{
    $conn = connectToDB();
    $stmt = $conn->prepare("SELECT * FROM admin");
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    closeConnection();
    return $admins;
}

function deleteUser($data)
{
    $conn = connectToDB();
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([
        $data["id"]
    ]);
    closeConnection();
}

function addUser($data, $img)
{ 
    $conn = connectToDB();
    $email = $data["email"];
    $stmt = $conn -> prepare("SELECT email FROM users WHERE email = '$email'");
    $stmt->execute();
    $result = $stmt->fetchColumn();
    
    if($result > 0){
        $error = "Email Already Exist!";
        return $error;
    }
    else{
        move_uploaded_file($img['tmp_name'], 'img/' . $img['name']);
        $password = md5($data["first"] . "123");
        $stmt = $conn->prepare("INSERT INTO users (picture, first_name, last_name, email, bio, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $img["name"],
            $data["first"],
            $data["last"],
            $data["email"],
            $data["bio"],
            $password
        ]);
    }
    closeConnection();
}

function updateUser($data)
{
    $conn = connectToDB();
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, bio = ? WHERE id = ?");
    $stmt->execute([
        $data["first"],
        $data["last"],
        $data["email"],
        $data["bio"],
        $data["id"]
    ]);
    closeConnection();
}

function updatePhotoUser($data, $img)
{
    $conn = connectToDB();
    move_uploaded_file($img["tmp_name"], 'img/' . $img["name"]);
    $stmt = $conn->prepare("UPDATE users SET picture = ? WHERE id = ?");
    $stmt->execute([
        $img["name"],
        $data["id"]
    ]);
    closeConnection();
}
