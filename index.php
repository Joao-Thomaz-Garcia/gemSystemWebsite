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
<?php include('nav.php')?>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXw2c6-8CqOr5IWg9Lx-oxv7NRB8KoXhM&libraries=places&callback=initMap" async defer></script>


    
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
                    <p class="text">
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