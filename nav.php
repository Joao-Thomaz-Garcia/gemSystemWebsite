<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEM - Car Rental</title>

    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="./css/nav.css">

</head>
<body>
    <nav> <!-- NAV -->
        <div class="container nav_container">
            <a href="index"> <img class="logo" src="./images/Branco.png"> </a>
            <ul class="nav__menu">
                <li><a href="index">Home</a></li>
                <li><a href="about">About us</a></li>
                <li><a href="vehicles">Vehicles</a></li>
                <li><a href="contact">Contact</a></li>
                <li><a style="border: 1px solid ;
                    padding: 1rem 1rem;"href="host">Become a Host</a></li>
                      <div class="dropdown">
                        <span><img src="images/user-circle.svg"style="max-width: 30px;"></i></span>
                        <div class="dropdown-content">
                          
<?php
if(!isset($_SESSION)){
  session_start();
  $isLogged = true;
  $userId = $_SESSION['id'];
}
if(isset($_SESSION['id'])){
  $isLogged = true;
  $userId = $_SESSION['id'];
}
if(!isset($_SESSION['id'])){
  $isLogged = false;
  //header("Location: login");
} ?>

                    <?php if($isLogged){
                          ?>
                          <a href="user-settings.php"><p>User Settings</p></a>
                          <a href="logout.php"><p>Logout</p></a>
                    <?php } else if(!$isLogged){ ?>
                          <a href="login.php"><p>Login</p></a>
                          <a href="register.php"><p>Sign Up</p></a>
                    <?php } ?> 
                    <?php if(isset($userId)){ 
                      if($userId == 42){ ?> 
                      <a href="edit-users.php"><p>Edit Users</p></a>

                    <?php }} ?>

                        </div>
                    </div>
            </ul>
            <div class="dropdown-phone">
                        <span><img src="images/menu.svg" style="max-width: 30px;"></i></span>
                        <div class="dropdown-content-phone">
                        <li><a href="index">Home</a></li>
                <li><a href="about">About us</a></li>
                <li><a href="vehicles">Vehicles</a></li>
                <li><a href="contact">Contact</a></li>
                <li><a href="host">Become a Host</a></li>
</div>
</div>
                    <div class="dropdown-phone2">
                        <span><img src="images/user-circle.svg"style="max-width: 30px;"></i></span>
                        <div class="dropdown-content-phone2">
                        <?php if($isLogged){
                          ?>
                          <a href="user-settings.php"><p>User Settings</p></a>
                          <a href="logout.php"><p>Logout</p></a>
                    <?php } else if(!$isLogged){ ?>
                          <a href="login.php"><p>Login</p></a>
                          <a href="register.php"><p>Sign Up</p></a>
                    <?php } ?>
                        </div>
                      </div>
          </div>
      </nav>
    </body>