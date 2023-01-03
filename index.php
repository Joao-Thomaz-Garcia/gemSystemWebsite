<?php
$pickupDate = date('Y-m-d');
$returnDate = date('Y-m-d',  strtotime($pickupDate) + strtotime('5 day', 0));

?>

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
    <link rel="stylesheet" href="./css/style.css">
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
                          <a href="login.php"><p class=".">Login</p></a>
                          <a href="register.php"><p class=".">Sign Up</p></a>
                          <a href="user-settings.php"><p class=".">User Settings</p></a>
                          <a href="logout.php"><p class=".">Logout</p></a>

                        </div>
                      </div>
            </ul>
            <button id="open-menu-btn"><i class="uil uil-bars"></i></button>
            <button id="close-menu-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- END OF NAV -->

    <!-- HEADER -->
    <header>

<script>
        //Inicia o mapa e o sistema de autocomplete.
function initMap() {
  var input = document.getElementById('autocomplete');
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    document.getElementById("address").value = JSON.stringify(place.address_components);
  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDm-1kjUs_NKnKccu2orORsvRaOMFp5Sn4&libraries=places&callback=initMap" async defer></script>


    
    <div class="form-container">
    <form action="vehicles" method="GET">
        <div class="input-box">
            <span>Location</span>
            <input style="width: 365px; type="search" name="cityaddress" id="autocomplete" placeholder="Insert a City">
        </div>
        <div class="input-box">
            <span>Pick-Up Date</span>
            <input type="date" value="<?php echo($pickupDate); ?>" name="pickupdate" id="">
        </div>
        <div class="input-box">
            <span>Return Date</span>
            <input type="date" value="<?php echo( $returnDate); ?>" name="returndate"  id="">
        </div>
        <input type="submit" value="Search for Cars" class="submits">
    </form>
</div>
</section>
        <div class="container header__container">
            <div class="header__left">
                <h1>BETTER THAN JUST A RENTAL CAR</h1>
                    <p>
"I was impressed by how easy it was to get the I needed in no time. GEM system is very intuitive and responsive. When I brought it back, I was greeted with a big smile by the host, and the touchless return was a stress-free experience. I'll be back for sure!"</p>
            </div>
            <div class="header__right">
                <div class="header__right-image">
                    <img class="image1"src="./images/bmw2.png">
                    <img class="image2"src="./images/gradientt.png" alt="">
                </div>
            </div>
        </div>
    </header>
    <!-- END OF HEADER-->
</body>
</html>