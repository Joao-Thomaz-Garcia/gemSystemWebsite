<?php include("nav.php")?>
<link rel="stylesheet" href="css/usersettings.css">
<?php

//Verifica a session, se não estiver logado, redireciona para o login.
if(!isset($_SESSION)){
    session_start();
  }
  if(!isset($_SESSION['id'])){
    header("Location: login.php");
  }

  include('connection.php');


  $owner_id = $_SESSION['id'];


  $sql_car_query = $mysqli->query("SELECT * FROM cars WHERE owner_id = '$owner_id'") or die("Error + $mysqli->error");


  $user_query = $mysqli->query("SELECT * FROM users WHERE id = '$owner_id'") or die("Error + $mysqli->error");

  while($user_loop = $user_query->fetch_assoc()){
    $user_mail = $user_loop['email'];
    $user_name = $user_loop['fullname'];
  }

$erro = false;
if(count($_POST) > 0){

    if(isset($_POST['senha'])){
        $password = $_POST['senha'];

        //Query para verificar se a senha existe, ai começar a fazer alterações



        $sql_code = "SELECT * FROM users WHERE id = '$owner_id' LIMIT 1";
        $sql_exec = $mysqli->query($sql_code) or die($mysqli->error);

        $login = $sql_exec->fetch_assoc();
        if($login != NULL){
            if(password_verify($password, $login['password']))
            {
                //Verifica a sessão novamente, e cria uma se for preciso.
                if(!isset($_SESSION)){
                    session_start();
                }
                $_SESSION['id'] = $login['id'];
    
                //Alteração dos dados cadastrados.
                $new_password = $_POST['nova_senha'];

                $name = $_POST['nome'];
                $email = strtolower($_POST['email_usuario']);
        
                //Verificar e criar uma query especializada na mudança de dados
                //Cada caso deve ter um $sql_code baseado na requisição.


                //If new password != null && != ''; -> change password
                if(strlen($new_password) < 6 || strlen($new_password) > 16){
                    $erro = true;
                }
                else{
                    $erro = false;
                }            


                //Verifica o nome, se for nulo ou vazio, mantem o anterior.
                if($name == '' && $name == null){
                    $name = $user_name;
                }

                //Verifica o e-mail do usuario, se for nulo, invalido ou vazio, mantém o anterior.
                if($email == null){

                    $mail_error = true;
                }
                else if($email != null && !filter_var($email, FILTER_VALIDATE_EMAIL)){

                    $mail_error = true;
                }

                if($mail_error)
                {
                    $email = $user_mail;
                }

                
                if($erro){
                    $sql_code = "UPDATE users 
                    SET fullname = '$name',
                    email = '$email'
                    WHERE id = '$owner_id'";
                }
                else if(!$erro){
                    $cryptoPassword = password_hash($new_password, PASSWORD_DEFAULT);

                    $sql_code = "UPDATE users 
                    SET fullname = '$name',
                    email = '$email',
                    password = '$cryptoPassword'
                    WHERE id = '$owner_id'";
                }


        
                $user_update = $mysqli->query($sql_code) or die($mysqli->error);
                if($user_update){
                    header("Location: user-settings");
                }




            }
            else
            {
                //AJUSTAR OS ERROS DOS DIE();
                //$login_error = "Failed to confirm your password, please try again.";
            }
        }
        else
        {
            //$login_error = "Failed to confirm your password, please try again.";
        }
    
    }

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
            SET address = '$exploded',
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
            header("Location: index");
        }

    }




    }

}






    //Colocar as mensagens e disparos de erro antes de enviar para o banco de dados.

?>

<style>
            input {
            all: unset;
            padding: 5px;
            border: 1px solid rgb(219, 219, 219);
            margin-bottom: 10px!important;
            border-radius: 5px;         
            width: 100%;  
        }

        button{
            background-color:rgb(0, 149,246,0.3);
            cursor: pointer;
            transition-duration: 0.4s;
            color: white;
            }
            button:hover {
            background-color:rgb(0, 149,246,20.3);
            color: black;
            }
            select {
            
            padding: 5px;
            border: 1px solid rgb(219, 219, 219);
            margin-bottom: 10px!important;
        }

</style>
<header>
<form style="border: 0px solid" action="" method="POST">
    <div style="display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem">
<div style="display: grid;
align-items: center;
justify-content: center;">
    Name: <br></break><input style="width: 400px;" type="text" value="<?php 
    if(isset($user_name)){
        echo($user_name); 
    }  ?>" name="nome" />

    <Br>E-mail:<br><input type="email" value="<?php 
    if(isset($user_mail)){
        echo($user_mail); 
    }  ?>" name="email_usuario" />
    
    <br>Password: <br><input type="password" name="senha" />
    <Br>New Password: <br><input type="password" name="nova_senha" />
    
    <br>
    <button type="submit" style="
    text-align: center;
    align-items: center;
    margin-top: 5px;
    border-radius: 5px;
    padding: 10px 77px;
    cursor: pointer;
"><i class="uil uil-save"></i>Save</button> </form>
    </div>
    <div style="display: grid;
    align-items center;
    justify-content: center;
    border: 1px solid rgb(219, 219, 219);">
    </div>
    </div>
<link rel="stylesheet" href="./css/host.css">
    <style>
        input {
            all: unset;
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
    <div class="middle">
        <div style="display:grid;
        align-content: center;
        justify-content: center;
        background-color: white;
        padding: 20px;">


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


<?php while($car_loop = $sql_car_query->fetch_assoc()){
  ?>


        <form method="POST" enctype="multipart/form-data" action="">
            <h2 style="text-align: center;">EDIT CAR INFO</h2>
            
    
            <input type="hidden" name="carid" value="<?php echo $car_loop['id']; ?>">
            
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
<?php }?>


    </div>
    <style>
</header>
</html>