<?php
  require_once 'database/database.php';

  $users = getAllUsers();

  if(isset($_POST["deleteBtn"])){
    deleteUser($_POST);
    header("Location: index.php");
  }

  if (isset($_POST["addBtn"])){
    addUser($_POST, $_FILES["file"]);
    header("Location: index.php");
  }

  if(isset($_POST["updateBtn"])){
    updateUser($_POST, $_FILES["file"]);
    header("Location: index.php");
  }

  $admins = getAdmin();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page | owenlimantoro_</title>

    <!-- CSS Link -->
    <link rel="stylesheet" href="style2.css">

    <!-- Font Link -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>
<body class="d-flex flex-column min-vh-100">
    <!-- NavBar -->
    <nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand">Website User</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav mt-auto">
                    <a class="nav-link active" aria-current="page" href="index.php">Dashboard</a>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                      </a>
                      <ul class="dropdown-menu">
                          <?php foreach($admins as $admin):?>
                          <h6 class=" dropdown-item">First Name : <?= $admin["first_name"] ?></h6>
                          <h6 class=" dropdown-item">Last Name : <?= $admin["last_name"] ?></h6>
                          <h6 class=" dropdown-item">Email : <?= $admin["email"] ?></h6>
                          <h6 class=" dropdown-item">Bio : <?= $admin["bio"] ?></h6>
                          <?php endforeach; ?>
                        </li>
                        <li><a class="dropdown-item" href="Logout.php"> <span style="color: red;">Log Out</span></a></li>
                      </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Bar
    <div class="container" data-bs-theme="light" style="padding-top: 100px;">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div> -->

    <!-- Table -->
    <div class="container my-5" style="background-color: rgb(255, 255, 255); color: black;">
        <table class="table table-hover caption-top" style="table-layout: fixed;">
            <caption>List of users</caption>
            <thead class="table-dark">
              <tr>
                <th scope="col" style="width: 50px;">No</th>
                <th scope="col">Photo</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <?php $num = 1 ?>
              <?php foreach($users as $user):?>
              <tr>

                <!-- Nomor -->
                <td scope="row"><?= $num++?></td>

                <!-- Photo -->
                <td class="align-middle">
                    <img src="<?= 'img/' . $user["picture"] ?>" alt="" style="width: 300px;">
                </td>

                <!-- Full Name -->
                <td> <?= $user["first_name"], " ",  $user['last_name'] ?> </td>

                <!-- Email -->
                <td> <?= $user["email"] ?></td>

                <!-- Action -->
                <td>
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary rounded-5" type="button" onclick="openModal('popupView<?= $num?>')">View</button>
                            <dialog class="popupView" id="popupView<?= $num?>">

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
                          <dialog class="editView" id="editView<?=$num?>">
                            <form method="POST" enctype="multipart/form-data">
                              <input type="hidden" name="id" value="<?= $user["id"]?>">
                              <!-- Picture -->
                              <h4>Picture :</h4> 
                              <div class="form-floating my-3">
                                <input type="file" class="form-control" accept="img/*"  id="picture" name="file" required>
                              </div>
                              
                              <h4>First Name :</h4> 
                              <div class="form-group mb-3 ">
                                <input type="text" class="form-control" id="firstname" value=" <?= $user["first_name"] ?>" name="first" required>
                              </div>

                              <h4>Last Name : </h4> 
                              <div class="form-group mb-3 ">
                                <input type="text" class="form-control" id="lastname" value=" <?= $user["last_name"] ?>" name="last" required>
                              </div>
  
                              <h4>Email : </h4> 
                              <div class="form-group mb-3 ">
                                <input type="email" class="form-control" id="email" value=" <?= $user["email"] ?>" name="email" required>
                              </div>
  
                              <h4>Bio : </h4> 
                              <div class="form-description mb-3 "> 
                                <textarea class="form-control" id="bio" rows="4" name="bio"> <?= $user["bio"]?></textarea>
                              </div>

                              <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>
                              <button type="reset" class="btn btn-secondary" style="margin-top: 10px;" onclick="closeModal('editView<?=$num?>')">Cancel</button>
                            </form>
                          </dialog>

                        <!-- Remove Button -->
                        <button class="btn btn-danger rounded-5" type="button" onclick="openModal('warningRemove<?=$num?>')">Remove</button>
                        <dialog class="warningRemove" id="warningRemove<?=$num?>">
                          <form action="" method="POST">
                            <input type="hidden" name="id" value="<?= $user["id"]?>">
                            <h2>Warning!</h2>
                            <h5>Are you sure you want to delete this?</h5>
                            <button type="submit" class="btn btn-outline-danger" name="deleteBtn">Yes</button>
                            <button type="button" class="btn btn-outline-secondary" formmethod="dialog" onclick="closeModal('warningRemove<?=$num?>')">No</button>
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
                  <h4>Picture :</h4> 
                  <div class="form-floating my-3">
                    <input type="file" class="form-control" accept="img/*" name="file" required>
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
        @owenlimantoro_
      </div>
</footer>

<!-- JavaScript Link -->
<script src="script.js"></script>

</html>