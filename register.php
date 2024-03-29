<?php 

//
//SETAR ARQUIVOS DE PDF PARA O REGISTER DA CARTEIRA DE MOTORISTA
//ENVIAR ESSES ARQUIVOS POR E-MAIL
//

if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['id'])){
    header("Location: index.php");
  }

include("connection.php");
include("lib/mail.php");

if(isset($_POST['fullName'])){
//Verificar as duas senhas e as outras formas de erro, se tudo der certo, enviar e-mail
    $fullName = $_POST['fullName'];
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if(strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16){
        $erro = "Please insert a valid password, it must contain from 6 to 16 characters.";
    }


    if($fullName == null){
        $erro = "Please fill the name field.";
        //die();
    }
    if($email == null){
        //Lembrar de setar a comparação de e-mail para toLower para não ter erro.
        //Inplode e explode para garantir que seja um email de fato

        $erro = "Please fill the email field.";
        //die();
    }
    else if($email != null && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro = "Please fill the email field.";

        //die("Not a valid e-mail!");
    }
    

    
    //https://dev.to/codeanddeploy/check-if-email-address-is-already-exists-in-the-database-4jf7
    //Verifica se o e-mail esta na database.
    $sql = "SELECT * FROM users WHERE email='".$email."'";
    $results = $mysqli->query($sql) or die($mysqli->error);
    $row = $results->fetch_assoc();
    if((is_array($row) && count($row)>0)){
        $erro = "Email already in database";
        //die("Email already in database");
    }
    //


    if($password == null){
        $erro = "Please insert a valid password, it must contain from 6 to 16 characters.";
        //die();
    }
    else{
        if($password != $confirmPassword){
            $erro = "The passwords don't match, try again.";
            //die();
        }
        else if($password == $confirmPassword && !isset($erro)){
            $cryptoPassword = password_hash($password, PASSWORD_DEFAULT);
            //FAZER A VERIFICAÇÃO DO TIPO E DO TAMANHO DA DRIVER LICENSE E DPS FAZER UMA QUERY ESPECIFICA PRA ISSO
            $sql_code = "INSERT INTO users (fullname, email, password, driver_license, can_drive, register_time) VALUES('$fullName', '$email', '$cryptoPassword', 'NULL', 0, NOW())";
            $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);

            if($deu_certo){
                send_email($email, "Welcome to Gem!!", "
                <h1>Congratulations!!</h1>
                <p>You are now a member of Gem!!</p>
                ");
                
                
                header("Location: login.php");
            }


        }
        
    }
    
}

?>

<?php include("nav.php");?>
<link rel="stylesheet" href="./css/login.css">
    <style>
        .error{
            font-size: 14px;
            color: red;
        }
        input {
            all: unset;
            padding: 5px;
            border: 1px solid rgb(219, 219, 219);
            margin-bottom: 10px!important;
        }
        button{
            cursor: pointer;
            transition-duration: 0.4s;
        }
            button:hover {
            background-color: rgb(30, 195, 241);
        }
        @media only screen and (max-width:600px){
         
               div .left{
                display: none;
            }
        }
    </style>

    <!-- HEADER - LOGIN -->
<header style="background-color: rgba(239,238,241,255);">
    <div style="
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: center;
    align-items: center;"
 >
    <div class="left"
    style="height: 990px;
           width: 700px;
           background-image: url(images/gem.jfif);
           background-repeat: no-repeat;
           ">
    </div>
    <div class="right">
        <form style="display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        align-content: center;
        align-items: stretch;
        justify-content: center;
        max-width: 350px;
        background-color: white;
        border: 1px solid rgb(219, 219, 219);
        padding: 40px;" action="" method="POST">
                    <img src="images/logoGEM.png" style="padding: 0px 70px 30px 70px" alt="">

                <input type="text" name="fullName" placeholder="Full Name">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirmPassword" placeholder="Repeat Your Password">
                <label for="">Driver license:</label>
                    <input name="arquivo" type="file">

                <button type="submit" style="
            text-align: center;
            margin-top: 10px;
            border-radius: 5px;
            padding: 10px;
            ">Register</button>
            <p class="error" >
                <?php 
                if(isset($erro)){
            echo($erro);
            }
            else{
                echo('');
            }
            
            ?></p>


            </form>

            <div style="background-color: white;
            border: 1px solid rgb(219, 219, 219);
            text-align: center;
            padding: 20px;
            justify-content: center;
            margin-top: 20px;
            " >
            Have an account?
            <a style="color: rgb(0, 149, 246, 1); font-weight: 600" href="login.php">Log in</a>
            </div>
    
    </div>
</header>