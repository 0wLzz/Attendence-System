<?php

  require_once 'database/database.php';
  $users = getAllUsers();
  $admins = getAdmin();

  if(isset($_POST["deleteBtn"])){
    deleteUser($_POST);
    header("Location: index.php");
  }

  if(isset($_POST["addBtn"])){
    $error = addUser($_POST, $_FILES["file"]);
    if(!isset($error)){
      header("Location: index.php");
    }
  }

  if(isset($_POST["updateBtn"])){
    updateUser($_POST, $_FILES["file"]);
  }

  if(isset($_GET["search"])){
    $users = searchUser($_GET["search"]);

  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>

    <!-- CSS Link -->
    <link rel="stylesheet" href="style2.css">

    <!-- Font Link -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Load icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .search-input {
            display: none;
        }

        .container {
            margin-top: 20px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100" style="background-color:#f2f2f2">
    
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" >
  <div class="container-fluid" style="padding-left: 16%; padding-right: 16%; display: flex; justify-content: space-between; align-items: center;">
    <a class="navbar-brand fw-bold">Attendence System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse ms-auto navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link ms-auto" aria-current="page" href="index.php">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ADMIN
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" type="button" onclick="openModal('profileView')">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="Logout.php"><span style="color: red;">Log Out</span></a></li>
          </ul>
        </li>
      </ul>
        <dialog class="editView" id="profileView">
            <?php foreach ($admins as $admin):?>
                <div class="text-center">
                    <img src="https://tse4.mm.bing.net/th?id=OIP.fMZwCAaBPntZ1NmSRhU6MQHaHa&pid=Api&P=0&h=220" alt="" style="width: 300px; margin: auto;">
                </div>
                <h4 class="mt-3 text-center fw-bold text-uppercase text-muted">Administrator</h4>

                <h4>First Name : </h4>
                <span> <?= $admin["first_name"] ?></span>

                <h4>Last Name : </h4>
                <span> <?= $admin["last_name"] ?> </span>

                <h4>Email : </h4>
                <span> <?= $admin["email"] ?> </span>

                <h4>Bio : </h4>
                <span> <?= $admin["bio"] ?> </span>
            <?php endforeach; ?>

            <button type="button" class="btn btn-secondary" onclick="closeModal('profileView')">Close</button>
        </dialog>
      <form class="d-flex ms-auto" style="max-width: 300px;" role="search" method="GET" action="">
        <input class="form-control me-2 search-input " type="text" name="search" 
               style="border-radius: 20px;min-width: 100px;" placeholder="Search" aria-label="Search" 
               value="<?php if (isset($_GET["search"])) echo $_GET["search"];?>" required>
        <button class="btn btn-light ms-auto" style="border-radius: 20px;" type="button" id="searchIcon"><i class="fa fa-search" aria-hidden="false"></i>
        </button>       
        <button class="btn btn-outline-secondary fw-bold shadow" type="submit" id="submitBtn" style="display: none; border-radius: 20px;">Search</button>
      </form>
      <script>
        $(document).ready(function () {
          $("#searchIcon").click(function () {
            $(".search-input").toggle(); // Toggle visibility of the input
            $("#submitBtn").toggle(); // Toggle visibility of the submit button
            $(this).toggle(); // Toggle visibility of the icon
          });
        });
      </script>
    </div>
  </div>
</nav>

    <!-- Table -->
    <div class="container my-5" style="background-color: rgb(255, 255, 255); width: 98%; color: black; overflow-x: auto; margin-left: auto; margin-right: auto;">
      <table class="table table-hover caption-top" style="min-width: auto;">
            <br><br>
            <caption><h3>List of users</h3></caption>
            <thead class="table-dark" style="text-align: center;"> 
                <tr>
                    <th scope="col" style="width: 50px;">No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" style="text-align: center; width: auto">
                <?php $num = 1 ?>
                <?php foreach ($users as $user):?>
                    <tr>

                        <!-- Nomor -->
                        <td scope="row"><?= $num++?></td>

                        <!-- Photo -->
                        <td class="align-middle">
                            <img src="<?= 'img/' . $user["picture"] ?>" alt="" style="width: 300px;">
                        </td>

                        <!-- Full Name -->
                        <td style="min-width: auto;"> <?= $user["first_name"], " ",  $user['last_name'] ?> </td>

                        <!-- Email -->
                        <td> <?= $user["email"] ?></td>

                        <!-- Action -->
                        <td>
                            <div class="d-grid gap-2 d-md-block">
                                <button class="btn btn-primary rounded-5" type="button" onclick="openModal('popupView<?= $num?>')">View</button>
                                <dialog class="popupView" id="popupView<?= $num?>" style="text-align: left">

                                    <div class="circular">
                                        <img src="<?= 'img/' . $user["picture"] ?>" alt="">
                                    </div>

                                    <h4>First Name : </h4>
                                    <span> <?= $user["first_name"] ?></span>

                                    <h4>Last Name : </h4>
                                    <span> <?= $user["last_name"] ?> </span>

                                    <h4>Email : </h4>
                                    <span> <?= $user["email"] ?> </span>

                                    <h4>Bio : </h4>
                                    <span> <?= $user["bio"] ?> </span>

                                    <button type="button" class="btn btn-secondary" onclick="closeModal('popupView<?= $num?>')">Close</button>
                                </dialog>

                                <!-- Edit Button -->
                                <button class="btn btn-warning rounded-5" type="button" onclick="openModal('editView<?=$num?>')">Edit</button>
                          <dialog class="editView" id="editView<?=$num?>" style="text-align: left">
                            <form method="POST" enctype="multipart/form-data">
                              <input type="hidden" name="id" value="<?= $user["id"]?>">
                              <input type="hidden" name="lastEmail" value="<?= $user["email"]?>">
                              <input type="hidden" name="lastPicture" value="<?= $user["picture"]?>">

                              <!-- Picture -->
                              <h4>Picture :</h4> 
                              <div class="mb-3">
                                <input type="file" class="form-control" accept="img/*"  id="picture" name="file">
                              </div>
                            
                              <h4>First Name :</h4> 
                              <div class="form-group mb-3 ">
                                <input type="text" class="form-control" id="firstname" value="<?= $user["first_name"] ?>" name="first" required>
                              </div>

                              <h4>Last Name : </h4> 
                              <div class="form-group mb-3 ">
                                <input type="text" class="form-control" id="lastname" value="<?= $user["last_name"] ?>" name="last" required>
                              </div>
  
                              <h4>Email : </h4> 
                              <div class="form-group mb-3 ">
                                <input type="email" class="form-control" id="email" value="<?= $user["email"] ?>" name="email" required>
                              </div>
  
                              <h4>Bio : </h4> 
                              <div class="form-description mb-3 "> 
                                <textarea class="form-control" id="bio" rows="4" name="bio"><?= $user["bio"]?></textarea>
                              </div>

                              <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>
                              <button type="reset" class="btn btn-secondary" style="margin-top: 10px;" onclick="closeModal('editView<?=$num?>')">Cancel</button>
                            </form>
                          </dialog>

                                <!-- Remove Button -->
                                <button class="btn btn-danger rounded-5" type="button" onclick="openModal('warningRemove<?=$num?>')">Remove</button>
                                <dialog class="warningRemove" id="warningRemove<?=$num?>" style="text-align: left">
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?= $user["id"]?>">
                                        <h2>Warning!</h2>
                                        <h5>Are you sure you want to delete this?</h5>
                                        <button type="submit" class="btn btn-danger" name="deleteBtn">Yes</button>
                                        <button type="button" class="btn btn-secondary" formmethod="dialog" onclick="closeModal('warningRemove<?=$num?>')">No</button>
                                    </form>
                                </dialog>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add User -->
        <div class="container my-3 text-center">
            <button class="btn btn-primary" type="button" onclick="openModal('addView')"> + Add User </button>
            <dialog class="addView" id="addView">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Picture -->
                    <div class="mb-3">
                      <input type="file" class="form-control" accept="img/*"  id="picture" name="file" required>
                    </div>

                    <h4>First Name :</h4>
                    <div class="form-group mb-3 ">
                        <input type="text" class="form-control" id="firstname" value="" name="first" required>
                    </div>

                    <h4>Last Name : </h4>
                    <div class="form-group mb-3 ">
                        <input type="text" class="form-control" id="lastname" value="" name="last" required>
                    </div>

                    <h4>Email : </h4>
                    <div class="form-group mb-3 ">
                        <input type="email" class="form-control" id="email" value="" name="email" required>
                    </div>

                    <h4>Bio : </h4>
                    <div class="form-description mb-3 ">
                        <textarea class="form-control" id="bio" rows="4" name="bio" placeholder="Tuliskan biografi Anda (opsional)"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" name="addBtn">Add User</button>
                    <button type="reset" class="btn btn-warning" style="margin-top: 10px;" onclick="closeModal('editView')">Reset</button>
                </form>
            </dialog>
        </div>
    </div>
</body>

<footer class="bg-body-tertiary text-center mt-auto">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
        Owen Limantoro || Michella Maria A.
    </div>
</footer>

<!-- JavaScript Link -->
<script src="script.js"></script>

</html>
