<?php 

if(!isset($_SESSION)){
    session_start();
  }
  //Se a sessão já existir, e o usuario estiver logado, redireciona ele para a página index.php
  if(isset($_SESSION['id'])){
    header("Location: user-settings");
  }

if(isset($_POST['email'])){
    include("connection.php");

    $email = strtolower($_POST['email']);
    $password = $_POST['password'];

    $sql_code = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $sql_exec = $mysqli->query($sql_code) or die($mysqli->error);


    $login = $sql_exec->fetch_assoc();
    if($login != NULL){
        if(password_verify($password, $login['password']))
        {
        
            if(!isset($_SESSION)){
                session_start();

            }
            $_SESSION['id'] = $login['id'];

            header("Location: index");
            //echo "Logado!";
        }
        else
        {
            //AJUSTAR OS ERROS DOS DIE();
            loginError();
        }
    }
    else
    {
        loginError();
    }

}


function loginError()
{
    //echo "Dados incorretos!";

}


?>

<?php include("nav.php");?>
<link rel="stylesheet" href="./css/login.css">
    <style>
        input {
            all: unset;
            padding: 5px;
            border: 1px solid rgb(219, 219, 219);
            margin-bottom: 10px!important;
            cursor: text;
            color: black;
        }
        button{
            cursor: pointer;
            transition-duration: 0.4s;
        }
            button:hover {
            background-color: rgb(30, 195, 241);
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
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" style="
            text-align: center;
            margin-top: 10px;
            border-radius: 5px;
            padding: 10px;
            ">Login</button>

            
          <!--  
            <a style="color: rgb(0, 149, 246, 1);
            text-align: center;
            padding-top: 20px;
            font-weight: 600;" href="recoverPassword.php">Forgot password?</a> -->
            </form>

            <div style="background-color: white;
            border: 1px solid rgb(219, 219, 219);
            text-align: center;
            padding: 20px;
            justify-content: center;
            margin-top: 20px;
            color: black;
            " >
            Don't have an account?
            <a style="color: rgb(0, 149, 246, 1); font-weight: 600" href="register.php">Sign up</a>
            </div>
    
    </div>
</header>
<?php include("copyright.html")?>

    
    