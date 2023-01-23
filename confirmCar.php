<?php
include("connection.php");

//Verifica a session, se não estiver logado, redireciona para o login.
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  header("Location: login");
}
//Incluir filtragem caso não haja um carro selecionado para redirecionar para a página de veiculos


//Coleta de dados com o método GET
if(isset($_GET['pickupdate'])){
  $pickupdate = $_GET['pickupdate'];
}
else{
  $pickupdate = '';

}

//
//Colocar por padrão o cálculo de dias para retornar, fazendo a subtração de pickupdate - returndate
//

//Verifica se o usuario entrou com um id de carro, se sim, mantem-se na página.
//Se não, retorna para a vehicles.
if(isset($_GET['id'])){
  $carid = $_GET['id'];
}
else{
  $carid = '';
}


if($carid != null || $carid != ''){
  $sql_query = $mysqli->query("SELECT * FROM cars WHERE id in ('$carid')") or die("Error + $mysqli->error");
}
else{
  header("Location: vehicles");
}

//Se a id não existir, retorna para a vehicles
if(mysqli_num_rows($sql_query) > 0){
}
else if(mysqli_num_rows($sql_query) < 1){
  header("Location: vehicles");

}



//Se a query não retornar um carro disponivel, retorna para a página de veículos
while($arquivo = $sql_query->fetch_assoc())
{
  if($arquivo['available'] == 0){
    header("Location: vehicles");

  }
  else if($arquivo['available'] == 1){

    $carname = $arquivo['model'];
    $priceday = $arquivo['daily_value'];
    $imagepath = $arquivo['filepath'];
    $ownerid = $arquivo['owner_id'];

    $sql_queryOwner = $mysqli->query("SELECT * FROM users WHERE id in ('$ownerid')") or die("Error + $mysqli->error");
    while($novoLoop = $sql_queryOwner->fetch_assoc()){

      $owneremail = $novoLoop['email'];

    }


    $renterid = strval($_SESSION['id']);
    $sql_queryRenter = $mysqli->query("SELECT * FROM users WHERE id in ('$renterid')") or die("Error + $mysqli->error");
    while($novoLoop2 = $sql_queryRenter->fetch_assoc()){

      $renteremail = $novoLoop2['email'];
    }


    $hasvalues = 0;

    //Checa se o get do pickupdate existe
    if(isset($_GET['pickupdate'])){
      $pickupdate = $_GET['pickupdate'];
      if($pickupdate < date('Y-m-d') || $pickupdate == "" || $pickupdate == null){
        $pickupdate = date('Y-m-d');

      }
    }
    else{
      //Se não existir, cria um baseado na data do dia de hoje.
      $pickupdate = date('Y-m-d');
    }

    //Checa se o get do returndate existe
    if(isset($_GET['returndate'])){
      $returndate = $_GET['returndate'];
      if($returndate <= $pickupdate || $returndate == "" || $returndate == null){
        $returndate = date('Y-m-d',  strtotime($pickupdate) + strtotime('5 day', 0));
      }
    }
    else{
            //Se não existir, cria um baseado na data do dia de hoje mais 5 dias.
      $returndate = date('Y-m-d',  strtotime($pickupdate) + strtotime('5 day', 0));
    }

    $hasvalues = 1;


  }
  else{
    header("Location: vehicles");

  }

}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="./css/confirmcar.css">
<style>.form-container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  position: absolute;
  top: 8rem;
  left: 300px;
  background: rgb(0, 0, 0);
  color: white;
  padding: 20px;
  border-radius: 1.5rem;
}
.form-containerinfo {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 5rem;
  position: absolute;
  top: 15rem;
  left: 0px;
  background: rgb(0, 0, 0);
  color: white;
  padding: 20px;
  border-radius: 1.5rem;
}
.input-box{
    flex: 1, 1, 7rem;
    display: flex;
    flex-direction: column;
}

.input-box span {
    font-weight: 500;
}

.input-box input{
    padding: 7px;
    outline: none;
    border: none;
    background: #eeeff1;
    border-radius: 0.5rem;
    font-size: 1rem;
}

.form-container .submits {
    flex: 0 0 7;
    padding: 10px 75px;
    margin-top: 10px;
    border: none;
    border-radius: 0.5rem;
    background: green;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
}
.form-container .calculate {
    flex: 0 0 7;
    margin-top: 10px;
    padding: 10px 75px;
    border: none;
    border-radius: 0.5rem;
    background: blue;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
}
.form-container .pickupdate{
    padding: 7px;
    outline: none;
    border: none;
    background: #eeeff1;
    border-radius: 0.5rem;
    font-size: 1rem;
}
  img {
    max-width: 180px;
    max-height: 100px;
  }
  span {
    text-align: center;
  }
  h3 {
    text-align: center;
  }
</style>

    <?php include ("nav.php")?>
    <header>
    
    <form action="confirmcar" method="GET">
      <div class="form-container">
        <div class="input-box">
            <span><?php echo($carname);  ?></span>
            <img class="image1" src="<?php echo($imagepath); //Fazer a normalização do tamanho da imagem?>">
            <span style="font-weight:300">Price Per Day:</span>
            <span style="font-weight:300">$<?php echo($priceday);  ?></span>
        </div>

        <input type="hidden" name="id" value="<?php echo($carid); ?>">

        <div class="input-box">
        <span>Pick-Up Date</span>
            <input type="date" name="pickupdate" class="pickupdate" id="" value="<?php echo($pickupdate); ?>">
            <span>Return Date</span>
            <input type="date" name="returndate" id="" value="<?php echo($returndate); ?>">
            <input type="submit" value="Calculate Price" class="calculate">


        </div>
        <div class="input-box">
        <span>Price</span>
        <h3>$<?php $subtraction = (strtotime($returndate) - strtotime($pickupdate)) /(24*60*60);  $value = intval($subtraction) * intval($priceday); echo($value); ?> </h3>



    </form>

  <form action="
  
  <?php 
  if($hasvalues == 1)
  {
    echo('create-checkout-session.php');
  }
  else{
    echo('confirmcar');
  }
  ?>"
  
  method="POST">


  <input type="hidden" name="product_id" value="<?php echo($carid); ?>">
  <input type="hidden" name="pickupdate" value="<?php echo($pickupdate); ?>">
  <input type="hidden" name="returndate" value="<?php echo($returndate); ?>">
  <input type="hidden" name="value" value="<?php if(isset($value)){
        $value .= "00";
    echo(intval($value));
  }
  else{
    $subtraction = (strtotime($returndate) - strtotime($pickupdate)) /(24*60*60);  $value = intval($subtraction) * intval($priceday);
    $value .= "00";
    echo(intval($value));
  }?>">

  
  <input type="hidden" name="emailvalue" value="<?php echo(intval($subtraction) * intval($priceday)); ?>">

  <input type="hidden" name="renteremail" value="<?php echo($renteremail); ?>">

  <input type="hidden" name="owneremail" value="<?php echo($owneremail); ?>">

  <input type="hidden" name="carname" value="<?php echo($carname); ?>">

  <input type="hidden" name="pickupdate" value="<?php echo($pickupdate); ?>">
  <input type="hidden" name="returndate" value="<?php echo($returndate); ?>">


  <input type="submit" value="Payment" class="submits">

  </form>
</div>
</form>
</header>
</body>
</html>