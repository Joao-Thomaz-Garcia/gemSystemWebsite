<?php

$erro = false;
if(count($_POST) > 0){
    
    include('connection.php');
    
    $fullname = $_POST['fullname'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $color = $_POST['color'];
    $seats = $_POST['seats'];

    if(empty($fullname)){
        $erro = "Insert your name.";
    }
    //FAZER O ERRO DE TELEFONE DA MANEIRA QUE DEVE SER FEITA.
    if(empty($fullname)){
        $erro = "Insert your phone number.";
    }
    if(empty($email)){
        $erro = "Insert your email.";
    }
    if(empty($brand)){
        $erro = "Insert the car brand.";
    }
    if(empty($model)){
        $erro = "Insert the car model.";
    }
    if(empty($year)){
        $erro = "Insert the car year.";
    }
    if(empty($color)){
        $erro = "Insert the car color.";
    }
    if(empty($seats)){
        $erro = "Insert the car seats.";
    }
    //ERRO
    if($erro){
        echo "<p><b>ERRO: $erro</b></p>";
    }
    else{
        //ARQUIVOS
        if(isset($_FILES['arquivo']))
        $arquivo = $_FILES['arquivo'];

    if(empty($arquivo))
        echo("Sem arquivo");
    else
    {
        if($arquivo['error'])
            die("Falha ao enviar arquivo");
        if($arquivo['size'] > 2099900 )
            die("Arquivo muito grande!");

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
            $sql_code = "INSERT INTO renters (fullname, phonenumber, email, brand, model, year, color, seats, filepath,register_time) VALUES ('$fullname', '$phonenumber', '$email', '$brand', '$model' , '$year', '$color', '$seats', '$path' , NOW())";
            $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
            if($deu_certo){
                echo "<p><b>CLIENTE CADASTRADO!!</b></p>";
                UNSET($_POST);
            }
                        echo "<p>Arquivo enviado com sucesso!";
        }
        else
            echo "<p>Falha ao enviar o arquivo.</p>";
    }
    $sql_query = $mysqli->query("SELECT * FROM renters") or die("AAA + $mysqli->error");
        //ARQUIVOS
    }





    //Colocar as mensagens e disparos de erro antes de enviar para o banco de dados.
}
?>

<?php include("nav.html")?>
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

    <div class="middle" style="display:grid;
            grid-template-columns: 1fr 1fr;">
            <div class="left" style="display:grid;
        align-content: center;
        align-items: stretch;
        justify-content: center;">
                <h1 style="text-align: center">BECOME A GEM HOST</h1>       
                <h2>LET US HELP YOU HAVE AN EXTRA INCOME BY RENTING YOUR CAR.</h1>
                <h3>ALL OUR HOSTS ARE HANDPICKED TO ENSURE OUR CLIENT'S SAFETY AND SATISFACTION.</h1>
                    <p style="text-align: center">
"I was impressed by how easy it was to get the I needed in no time. GEM system is very intuitive and responsive.</p>
                </p>
                <p>When I brought it back, I was greeted with a big smile by the host, and the touchless return was a stress-free experience. I'll be back for sure!"</p>
            </div>
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
        
        <form method="POST" enctype="multipart/form-data" action="">
        <img src="images/logoGEM.png" style="padding: 0px 70px 30px 70px" alt="">
            <h2 style="text-align: center;">BECOME A GEM HOST</h2>
            <input value="" name="address" type="text" placeholder="Address">
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
        </div>
    </div>
</header>

</html>

    
    