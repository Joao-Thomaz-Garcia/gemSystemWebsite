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
<style>.form-container form {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  position: absolute;
  top: 10rem;
  left: 200px;
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

.form-container form .submits {
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
.form-container form .calculate {
    flex: 0 0 7;
    margin-top: 10px;
    padding: 10px 75px;
    border: none;
    border-radius: 0.5rem;
    background: green;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
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

    <?php include ("nav.html")?>
    <header>
      <div class="form-container">
    <form action="confirmcar" method="GET">
        <div class="input-box">
            <span><?php echo($carname);  ?></span>
            <img class="image1" src="<?php echo($imagepath); //Fazer a normalização do tamanho da imagem?>">
            <span style="font-weight:300">Price Per Day:</span>
            <span style="font-weight:300">$<?php echo($priceday);  ?></span>
        </div>

        <input type="hidden" name="id" value="<?php echo($carid); ?>">

        <div class="input-box">
            <span>Pick-Up Date</span>
            <input type="date" name="pickupdate" id="" value="<?php echo($pickupdate); ?>">
        </div>
        <div class="input-box">
            <span>Return Date</span>
            <input type="date" name="returndate" id="" value="<?php echo($returndate); ?>">
            <input type="submit" value="Calculate" class="calculate">


        </div>
        <div class="input-box">
        <span>Price</span>
        <h3>$<?php $subtraction = (strtotime($returndate) - strtotime($pickupdate)) /(24*60*60);  $value = intval($subtraction) * intval($priceday); echo($value); ?> </h3>

</div>


    </form>

  <form action="
  
  <?php 
  if($hasvalues == 1)
  {
    echo('index');
  }
  else{
    echo('confirmcar');
  }
  ?>"
  
  method="GET">


  <input type="hidden" name="id" value="<?php echo($carid); ?>">
  <input type="hidden" name="pickupdate" value="<?php echo($pickupdate); ?>">
  <input type="hidden" name="returndate" value="<?php echo($returndate); ?>">
  <input type="hidden" name="value" value="<?php if(isset($value)){
    echo($value);
  }
  else{
    $subtraction = (strtotime($returndate) - strtotime($pickupdate)) /(24*60*60);  $value = intval($subtraction) * intval($priceday);
    echo($value);
  }?>">



  <input type="submit" value="Payment" class="submits">

  </form>

</div>
      </form>
</header>
</body>
</html>