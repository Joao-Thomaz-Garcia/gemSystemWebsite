<?php

//Verifica a session, se não estiver logado, redireciona para o login.
if(!isset($_SESSION)){
    session_start();
  }
  if(!isset($_SESSION['id'])){
    header("Location: login.php");
  }



$erro = false;
if(count($_POST) > 0){
    
    include('connection.php');
    if(isset($_POST['address'])){
        $address = $_POST['address'];
        //LEMBRAR DE COLOCAR O SISTEMA DO GOOGLE PARA REGISTRAR O ENDEREÇO
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $color = $_POST['color'];
        $seats = $_POST['seats'];
        //Filtrar tipos de combustivel e quantos assentos para não entrar coisas que não devem.
        $seats = $_POST['seats'];
        $fuel = $_POST['fuel'];
        //Filtrar tipos de combustivel e quantos assentos para não entrar coisas que não devem.
        $daily_values = $_POST['priceperday'];
    
    }


    $error_address;
    $error_brand;
    $error_model;
    $error_year;
    $error_color;
    $error_seats;
    $error_fuel;
    $error_file;
    //error_price;

    //TRATAR DOS ERROS DE ALGUMA FORMA
    if(empty($address)){
        $error_address = "Insert your address.";
    }
    else{
        $error_address = null;
    }
    if(empty($brand)){
        $error_brand = "Insert the car brand.";
    }
    else{
        $error_brand = null;
    }
    if(empty($model)){
        $error_model = "Insert the car model.";
    }
    else{
        $error_model = null;
    }
    if(empty($year)){
        $error_year = "Insert the car year.";
    }
    else{
        $error_year = null;
    }
    if(empty($color)){
        $error_color = "Insert the car color.";
    }
    else{
        $error_color = null;
    }
    if(empty($seats)){
        $error_seats = "Insert the car seats.";
    }
    else{
        $error_seats = null;
    }
    //ERRO

    //ARQUIVOS
    if(isset($_FILES['arquivo']))
        $arquivo = $_FILES['arquivo'];

    if(empty($arquivo))
        $error_file = "Insert a .jpg .jpeg or .png file of your car!";
    else
    {
        if($arquivo['size'] > 2099900 )
            $error_file = "The file is too large!";
        else{
            $error_file = null;
        }

        $pasta = "files/";
        $nomeDoArquivo = $arquivo['name'];
        $novoNomeDoArquivo = uniqid();
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
        
        if($extensao != "jpg" && $extensao != 'png' && $extensao != 'jpeg'){

            die("Tipo de arquivo não aceito + $extensao");
        }
        
        $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

        //Lembrar de cortar a imagem depois

        $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);

        if($deu_certo)
        {
            $owner_id = $_SESSION['id'];

            $sql_code = "INSERT INTO cars (owner_id, address, brand, model, year, color, fuel, seats, daily_value, filepath, register_time) VALUES ('$owner_id' , '$address', '$brand', '$model' , '$year', '$color', '$fuel' ,'$seats', '$daily_values' ,'$path' , NOW())";
            
            
            $enviar_bd = $mysqli->query($sql_code) or die($mysqli->error);
            if($enviar_bd){
                //echo "<p><b>CLIENTE CADASTRADO!!</b></p>";
                UNSET($_POST);
                header("Location: index.php");
            }
            //echo "<p>Arquivo enviado com sucesso!";
        }
        /*else
            echo "<p>Falha ao enviar o arquivo.</p>";*/
    }



}


    //Colocar as mensagens e disparos de erro antes de enviar para o banco de dados.

?>

<?php include("nav.html")?>

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


<link rel="stylesheet" href="./css/host.css">
    <style>
        input {
            all: unset;
            padding: 5px;
            border: 1px solid rgb(219, 219, 219);
            margin-bottom: 10px!important;

        }
        select {
            
            padding: 5px;
            border: 1px solid rgb(219, 219, 219);
            margin-bottom: 10px!important;
        }
        button{
            cursor: pointer;
            transition-duration: 0.4s;
            color: black;
            }
            button:hover {
            background-color:rgb(30, 195, 241);
            color: black;
            }
        
    </style>

    <!-- HEADER - LOGIN -->
<header style="background-color: rgba(239,238,241,255);">

    <div class="middle">
        <div style="
        display:grid;
        flex-direction: column;
        flex-wrap: nowrap;
        align-content: center;
        align-items: stretch;
        justify-content: center;
        width: 100%;
        height: 950px;
        background-color: white;
        padding: 60px;
        @media only screen and (max-width:1360px){
        height:100%!important}">

    <!--
        <div style="float: left;">
            <input type="text" placeholder="First Name"> 
            <input type="text" placeholder="Last Name">
    -->
        

        <form method="POST" enctype="multipart/form-data" action="">
        <img src="images/logoGEM.png" style="padding: 0px 70px 30px 70px" alt="">
            <h2 style="text-align: center;">BECOME A GEM HOST</h2>

            <input value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>" name ="address" id="autocomplete" type="text" placeholder="Pick up address">
            <input value="<?php if(isset($_POST['brand'])) echo $_POST['brand']; ?>" name ="brand" type="text" placeholder="Car brand">
            <input value="<?php if(isset($_POST['model'])) echo $_POST['model']; ?>" name ="model" type="text" placeholder="Car model">
            <input value="<?php if(isset($_POST['year'])) echo $_POST['year']; ?>" name ="year" type="text" placeholder="Car year">
            <input value="<?php if(isset($_POST['color'])) echo $_POST['color']; ?>" name ="color" type="text" placeholder="Car color">
            

            <div style="float: left;">
            <select value="<?php if(isset($_POST['seats'])) echo $_POST['seats']; ?>" name="seats" id="seat-select">
                <option value selected="selected">How many seats?</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6 or more</option> </select>
                <select name="fuel" id="fuel-select">
                    <option value selected="selected">Type of fuel?</option>
                    <option value="one">Regular</option>
                    <option value="two">Premium</option> 
                    <option value="three">Electricity</option>
                    <option value="four">Hybrid</option> </select> </div>
                <input name="priceperday" type="number" min="1" step="any" placeholder="Price per day">

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
<!--

            <div style="float: left;">
            <select name="seats" id="seat-select">
                <option value selected="selected">How Many Seats?</option>
                <option value="two">2</option>
                <option value="tree">3</option>
                <option value="four">4</option>
                <option value="five">5</option>
                <option value="six more">6 or more</option> </select>
                <select name="fuel" id="fuel-select">
                    <option value selected="selected">Type of Fuel?</option>
                    <option value="two">Regular</option>
                    <option value="tree">Premium</option> </select> </div>
            <label for="image">Photos of your car:</label>
            <input type="file"
       id="car-images" name="car-img"
       accept="image/png, image/jpeg">
            <label>Max. file size: 40 MB.
                <p></p>Please enter as many detailed images as possible.</p>
            
            <button style="background-color:rgb(0, 149,246,0.3);
            text-align: center;
            color: white;
            margin-top: 10px;
            border-radius: 5px;
            padding: 10px;
            ">Send Your Data</button></label> -->
        </div>
    </div>
</header>

</html>

    
    