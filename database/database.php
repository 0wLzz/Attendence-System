<?php

session_start();
$conn = "";
$stmt = "";

function connectToDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "attendance_database";
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

    closeConnection();
    return $users;
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

function generateId()
{
    $conn = connectToDB();

    $stmt = $conn->prepare("SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) AS maxNumber FROM users");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $currentMax = $row['maxNumber'];

    $currentLetter = 'T';
    $nextLetter = chr(ord($currentLetter) + 1);
    $nextNumber = ($currentMax % 999) + 1;

    $newID = $nextLetter . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    
    return $newID;
}

function addUser($data, $img)
{ 
    $conn = connectToDB();

    $email = $data["email"];
    $stmt = $conn -> prepare("SELECT email FROM users WHERE email = '$email'");
    $stmt->execute();
    $result = $stmt->fetchColumn();
    
    if($result > 0){
        echo '<script>alert("Email Already Registered!"); window.location.href = "index.php"; </script>';
        return 'error';
    }
    else{
        move_uploaded_file($img['tmp_name'], 'img/' . $img['name']);
        $password = md5($data["first"] . "123");
        $id = generateId();
        $stmt = $conn->prepare("INSERT INTO users (id, picture, first_name, last_name, email, bio, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $id,
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

function updateUser($data, $img)
{
    $conn = connectToDB();
    if(empty($img['name'])){   
        $img['name'] = $data['lastPicture'];
    }

    $lastEmail = $data['lastEmail'];
    $email = $data["email"];

    if($lastEmail === $email){
        $stmt = $conn->prepare("UPDATE users SET picture = ?, first_name = ?, last_name = ?, email = ?, bio = ? WHERE id = ?");
        $stmt->execute([
            $img["name"],
            $data["first"],
            $data["last"],
            $data["email"],
            $data["bio"],
            $data["id"]
        ]);
        header("Location: index.php");

    }else{
        $stmt = $conn -> prepare("SELECT email FROM users WHERE email = '$email'");
        $stmt->execute();
        $result = $stmt->fetchColumn();
        
        if($result > 0){
            echo '<script>alert("Email Already Registered!"); window.location.href = "index.php"; </script>';
        }
        else{
            $stmt = $conn->prepare("UPDATE users SET picture = ?, first_name = ?, last_name = ?, email = ?, bio = ? WHERE id = ?");
            $stmt->execute([
                $img["name"],
                $data["first"],
                $data["last"],
                $data["email"],
                $data["bio"],
                $data["id"]
            ]);
            header("Location: index.php");
        }
    }
    closeConnection();
}

function searchUser($value)
{
    $conn = connectToDB();

    $stmt = $conn->prepare("SELECT * FROM users WHERE CONCAT(first_name, last_name, email) LIKE :value");
    $stmt->bindValue(':value', '%' . $value . '%', PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) > 0){
        return $result;
    } else {
        echo '<script>';
        echo 'alert("Data Not Found!");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
        
        
        closeConnection();        
        return getAllUsers();

    }
}
