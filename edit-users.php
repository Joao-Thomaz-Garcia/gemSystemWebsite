<?php include("nav.php")?>
<link rel="stylesheet" href="css/usersettings.css">
<?php

//Verifica a session, se não estiver logado, redireciona para o login.
if(!isset($_SESSION)){
    session_start();
    header("Location: login.php");
  }
  if(!isset($_SESSION['id'])){
    header("Location: login.php");
    die();
  }
  
  if(isset($_SESSION['id']) && $_SESSION['id'] != 20){
    header("Location: user-settings.php");
  }

  include('connection.php');



  $sql_car_query = $mysqli->query("SELECT * FROM cars") or die("Error + $mysqli->error");



$erro = false;
if(count($_POST) > 0){

    if(isset($_POST['address'])){
        $address = $_POST['address'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $color = $_POST['color'];
        $seats = $_POST['seats'];
        $seats = $_POST['seats'];
        $fuel = $_POST['fuel'];
        $daily_values = $_POST['priceperday'];
    
        $available = $_POST['available'];


        $carid = $_POST['carid'];

        //

        //ARQUIVOS
        if(isset($_FILES['arquivo'])){
            $arquivo = $_FILES['arquivo'];

        }

        $error_file = false;
        if(empty($arquivo)){
            $error_file = true;

        }
        else
        {
        if($arquivo['size'] > 2099900 )
            $error_file = true;
        else{
            $error_file = false;
        }

        $pasta = "files/";
        $nomeDoArquivo = $arquivo['name'];
        $novoNomeDoArquivo = uniqid();
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

        if($extensao != "jpg" && $extensao != 'png' && $extensao != 'jpeg'){
            $error_file = true;
            //die("Tipo de arquivo não aceito + $extensao");
        }


        //Coleta só a cidade
        $exploded = explode(',', $address);
        $cityaddress = $exploded[0];
        //

        if($error_file){
            $sql_carcode = "UPDATE cars 
            SET address = '$cityaddress',
            brand = '$brand',
            model = '$model',
            year = '$year',
            color = '$color',
            fuel = '$fuel',
            seats = '$seats',
            daily_value = '$daily_values',
            available = '$available'
            WHERE id = '$carid'";

        }
        else if(!$error_file){
            $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
            $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);

            $sql_carcode = "UPDATE cars 
            SET address = '$cityaddress',
            brand = '$brand',
            model = '$model',
            year = '$year',
            color = '$color',
            fuel = '$fuel',
            seats = '$seats',
            daily_value = '$daily_values',
            available = '$available',
            filepath = '$path'
            WHERE id = '$carid'";

        }

        //Update no banco de dados.



        $user_carupdate = $mysqli->query($sql_carcode) or die($mysqli->error);
        if($user_carupdate){
            //header("Location: edit-users");
        }

    }




    }

}






    //Colocar as mensagens e disparos de erro antes de enviar para o banco de dados.

?>

<header>
    </div>
    <div style="display: grid;
    align-items center;
    justify-content: center;
    border: 1px solid rgb(219, 219, 219);">
    </div>
    </div>

    <div class="middle">
        <div class="middlediv">
<form>
    <input type="name" class="searchid" placeholder="Search ID Here">
        </form>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd7CXePhjNu76LACTt5Jufoh5X5tCbuTg&libraries=places&callback=initMap" async defer></script>


<?php while($car_loop = $sql_car_query->fetch_assoc()){

$owner_id = $car_loop['owner_id'];

$user_query = $mysqli->query("SELECT * FROM users WHERE id = '$owner_id'") or die("Error + $mysqli->error");

while($user_loop = $user_query->fetch_assoc()){
  $user_mail = $user_loop['email'];
}


  ?>


        <form method="POST" enctype="multipart/form-data" action="" class="form">
            <h2 style="text-align: center;">EDIT CAR INFO</h2>
            
            
            <input type="hidden" name="carid" value="<?php echo $car_loop['id']; ?>">
            
            <input type="email" readonly name="" value="<?php echo($user_mail); ?>">

            <input value="<?php echo($car_loop['address']); ?>" name ="address" id="autocomplete" type="text" placeholder="Pick up address">
            <input value="<?php echo($car_loop['brand']); ?>" name ="brand" type="text" placeholder="Car brand">
            <input value="<?php echo($car_loop['model']); ?>" name ="model" type="text" placeholder="Car model">
            <input value="<?php echo($car_loop['year']); ?>" name ="year" type="text" placeholder="Car year">
            <input value="<?php echo($car_loop['color']); ?>" name ="color" type="text" placeholder="Car color">
            

            <div style="">
            <select name="seats" id="seat-select">
                <option value disabled>How many seats?</option>
                <option <?php if($car_loop['seats'] == 2) echo 'selected'; ?> value="2">2</option>
                <option <?php if($car_loop['seats'] == 3) echo 'selected'; ?> value="3">3</option>
                <option <?php if($car_loop['seats'] == 4) echo 'selected'; ?> value="4">4</option>
                <option <?php if($car_loop['seats'] == 5) echo 'selected'; ?> value="5">5</option>
                <option <?php if($car_loop['seats'] == 6) echo 'selected'; ?> value="6">6 or more</option> </select>
                <select name="fuel" id="fuel-select">
                    <option value disabled>Type of fuel?</option>
                    <option <?php if($car_loop['fuel'] == 'regular') echo 'selected';?> value="regular">Regular</option>
                    <option <?php if($car_loop['fuel'] == 'premium') echo 'selected';?> value="premium">Premium</option> 
                    <option <?php if($car_loop['fuel'] == 'electricity') echo 'selected';?> value="electricity">Electricity</option>
                    <option <?php if($car_loop['fuel'] == 'hybrid') echo 'selected';?> value="hybrid">Hybrid</option> </select> </div>
            <select name="available" id="">
                <option <?php if($car_loop['available'] >= 1) echo 'selected'; ?> value="1">Available</option>
                <option <?php if($car_loop['available'] <= 0) echo 'selected'; ?> value="0">Not available</option>
            </select>
                <input value="<?php echo($car_loop['daily_value']); ?>" name="priceperday" type="number" min="1" step="any" placeholder="Price per day">

            <!--BOTÃO DE ENVIO -->
            <label for="">Best photo of your car:</label>
                    <input name="arquivo" type="file">

            <!--BOTÃO DE ENVIO -->



            <button type="submit" style="
                text-align: center;
                margin-top: 10px;
                border-radius: 5px;
                padding: 10px;
            ">Send data</button>

        </form>
        <br>
<?php }?>


    </div>
    <style>
</header>
</html>