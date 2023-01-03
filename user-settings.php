<?php include("nav.html")?>
<link rel="stylesheet" href="css/usersettings.css">
<?php

//Verifica a session, se não estiver logado, redireciona para o login.

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
        $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);
        if($deu_certo)
        {
            $owner_id = $_SESSION['id'];

            $sql_code = "INSERT INTO cars (owner_id, address, brand, model, year, color, fuel, seats, daily_value, filepath, register_time) VALUES ('$owner_id' , '$address', '$brand', '$model' , '$year', '$color', '$fuel' ,'$seats', '$daily_values' ,'$path' , NOW())";
            $enviar_bd = $mysqliConnect->query($sql_code) or die($mysqliConnect->error);
            if($enviar_bd){
                echo "<p><b>CLIENTE CADASTRADO!!</b></p>";
                UNSET($_POST);
            }
            echo "<p>Arquivo enviado com sucesso!";
        }
        else
            echo "<p>Falha ao enviar o arquivo.</p>";
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
<form style="border: 0px solid">
    <div style="display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem">
<div style="display: grid;
align-items: center;
justify-content: center;">
    Name: <br></break><input style="width: 400px;" type="text" name="nome" />
    <Br>E-mail:<br><input type="email" name="email_usuario" />
    
    <br>Password: <br><input type="password" name="senha" />
    <Br>Repeat Password: <br><input type="password" name="repitasenha" />
    
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

        <form method="POST" enctype="multipart/form-data" action="">
            <h2 style="text-align: center;">EDIT CAR INFO</h2>
            
            <input value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>" name ="address" type="text" placeholder="Pick up address">
            <input value="<?php if(isset($_POST['brand'])) echo $_POST['brand']; ?>" name ="brand" type="text" placeholder="Car brand">
            <input value="<?php if(isset($_POST['model'])) echo $_POST['model']; ?>" name ="model" type="text" placeholder="Car model">
            <input value="<?php if(isset($_POST['year'])) echo $_POST['year']; ?>" name ="year" type="text" placeholder="Car year">
            <input value="<?php if(isset($_POST['color'])) echo $_POST['color']; ?>" name ="color" type="text" placeholder="Car color">
            

            <div style="">
            <select value="<?php if(isset($_POST['seats'])) echo $_POST['seats']; ?>" name="seats" id="seat-select">
                <option value selected="selected">How many seats?</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6 or more</option> </select>
                <select name="fuel" id="fuel-select">
                    <option value selected="selected">Type of fuel?</option>
                    <option value="regular">Regular</option>
                    <option value="premium">Premium</option> 
                    <option value="electricity">Electricity</option>
                    <option value="hybrid">Hybrid</option> </select> </div>
            <select name="available" id="">
                <option value selected="selected">Available</option>
                <option value="0">Not available</option>
            </select>
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
    </div>
    <style>
</header>
</html>