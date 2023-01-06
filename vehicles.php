<?php include("nav.php")?>
<?php
include("connection.php");

//Verifica a session, se não estiver logado, redireciona para o login.
//RETIRAR A NECESSIDADE DE LOGIN PARA ENTRAR NA PÁGINA DOS VEICULOS
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['id'])){
  //header("Location: login");
}
//


//Faz a filtragem para o envio de dados.
if(isset($_GET['cityaddress'])){
  $exploded = explode(',', $_GET['cityaddress']);
  $cityaddress = $exploded[0];
}
else{
  $cityaddress = '';
}

//Filtragem das datas. *COLOCAR UM METODO DE SEGURANÇA NISSO*
if(isset($_GET['pickupdate'])){
  $pickupdate = $_GET['pickupdate'];
}
else{
  $pickupdate = date('Y-m-d');
}
if(isset($_GET['returndate'])){
  $returndate = $_GET['returndate'];
}
else{
  $returndate = date('Y-m-d',  strtotime($pickupdate) + strtotime('5 day', 0));
}


//FILTRAGEM DE ENDEREÇO
if($cityaddress == '' || $cityaddress == null){
  $sql_query = $mysqli->query("SELECT * FROM cars") or die("Error + $mysqli->error");
}
else if($cityaddress != '')
{
  $sql_query = $mysqli->query("SELECT * FROM cars WHERE address in ('$cityaddress')") or die("Error + $mysqli->error");

}
else{
  //CASO ALGO ERRADO ACONTEÇA ENVIA PARA A PÁGINA INICIAL
  die(header("Location: index"));
}

?>


<link rel="stylesheet" href="./css/mandar.css">
<style>
  .grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(200px, 540px));
    grid-gap: 20px;
    align-items: stretch;
    overflow: hidden;
  }

  .grid>form {
    border: 1px solid #ccc;
    box-shadow: 2px 2px 6px 0px rgba(0, 0, 0, 0.3);
    border-radius: 4px;
  }
  
  .grid>form img {
    cursor: pointer;
    max-width: 100%;
    max-height: 210px;
    transition-duration: 0.5s;
    border-radius: 4px;
  }
  .grid>form img:hover {
    opacity: 0.5;
  }
  .grid h3 {
    padding: 5px 0px 0px 5px;
    text-align: center;
  }
  .grid>form button{
    width: 100%;
}
.form-container form {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  position: absolute;
  top: 1rem;
  left: 500px;
  background: rgb(0, 0, 0);
  color: white;
  padding: 21px;
  border-radius: 0.5rem;
}

.input-box{
    flex: 1 1 7rem;
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
    padding: 10px 44px;
    border: none;
    border-radius: 0.5rem;
    background: rgb(30, 195, 241);
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
}
@media only screen and (max-width:1440px){
  .form-container form {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
    position: absolute;
    top: 1rem;
    left: 269px;
    background: rgb(0, 0, 0);
    color: white;
    padding: 21px;
    border-radius: 0.5rem;
}
}
@media only screen and (max-width:1360px){

  .form-container form {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  position: absolute;
  top: 1rem;
  left: 232px;
  background: rgb(0, 0, 0);
  color: white;
  padding: 21px;
  border-radius: 0.5rem;
}
.grid>form img {
    cursor: pointer;
    max-width: 440px;
    max-height: 250px;
    transition-duration: 0.5s;
    border-radius: 4px;
  }

.grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(100px, 440px));
    grid-gap: 20px;
    align-items: stretch;
    
  }
}
@media only screen and (max-width:600px){
  header {
    position: relative;
    top: 5rem!important;
    height: 95vh;
}
  .form-container form {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  position: absolute;
  top: -1rem;
  left: 0px;
  background: rgb(0, 0, 0);
  color: white;
  padding: 7px;
  border-radius: 0rem;
}
.grid {
  display: grid;
    grid-template-columns: repeat(1, minmax(100px, 440px));
    grid-gap: 20px;
    position: absolute;
    top: 12rem;
    align-items: stretch;
    left: 0px;
    
  }
}
  </style>
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
            <input style="width: 365px; type="search" name="cityaddress" id="autocomplete" value="<?php echo $cityaddress ?>" placeholder="City or address">
        </div>
        <div class="input-box">
            <span>Pick-Up Date</span>
            <input type="date" name="pickupdate" id="" value="<?php echo $pickupdate ?>">
        </div>
        <div class="input-box">
            <span>Return Date</span>
            <input type="date" name="returndate" id="" value="<?php echo $returndate ?>">
        </div>
        <input type="submit" value="Search for Cars" class="submits">
    </form>
</div>
<br><br><br><br><br><br>
<div id="app" class="container">
  <div class="grid">
    

  <?php
    while($arquivo = $sql_query->fetch_assoc())
    {
      if($arquivo['available'] != 0){
        ?>


          <form action="<?php 
  if(!isset($_SESSION['id']))
{
  echo('login');
}
  else{
  echo('confirmCar');
} ?>" 
method="GET">
          <button name="" value="" type="submit"><img src="<?php echo $arquivo['filepath'];  ?>" alt="carro1"></button>
          <input type="hidden" name="id" value="<?php echo $arquivo['id']; ?>">

          <input type="hidden" name="pickupdate" value="<?php echo($pickupdate); ?>">
          <input type="hidden" name="returndate" value="<?php echo($returndate); ?>">

          <div class="title">
            <h3><?php echo $arquivo['model']; ?></h3>
          </div>
          <div class="description">
            R$<?php echo $arquivo['daily_value']; //SUBSTITUIR O BANCO DE DADOS O QUANTO ANTES!!?> Per Day
          </div>
      </form>
<?php } else{}?>

  <?php
    }
    ?>
  
</div>
</div>


</header>
</body>
</head>

    
    