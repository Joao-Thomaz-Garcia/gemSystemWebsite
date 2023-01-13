<?php 
if(!isset($_SESSION)){
    session_start();
}
?>
<?php

include('lib/mail.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './stripe-service.php';

$owneremail = $_POST['owneremail'];

$email = $_POST['renteremail'];
$emailamount = $_POST['emailvalue'];

$pickupdate = $_POST['pickupdate'];
$returndate = $_POST['returndate'];



$stripe = new StripeService();

// Essas informações devem vir no corpo do formulário

// ID do produto (carro) no banco de dados
$productId = $_POST['product_id'];
// Valor total das diárias, inteiro, positivo e em centavos Ex: para US$ 20,00 deve-se enviar o valor 2000
$amount = intval($_POST['value']); 

// Essas duas infos vem do banco

// Pegar o nome do carro do banco ou qualquer descriçaõ de desejar
$name = $_POST['carname'];
// Incluir uma imagem (não é obrigatório)
//$image = "https://miro.medium.com/max/640/0*i1v1In2Tn4Stnwnl.webp";

// Buscando o produto no Stripe
$product = $stripe->getProduct($productId);
// Caso não exista será cadastrado
if (!isset($product)) {
  // Cadastrando
  $product = $stripe->createProduct($productId, $name);
}

// Criando o preço
$price = $stripe->createPrice($productId, $amount);

//
//CASO DOIS CLIENTES ALUGUEM O MESMO CARRO NÃO HÁ O QUE SER FEITO
//ENVIAR E-MAIL DE INTERESSE POR X CARRO NESSE PONTO SE NÃO FERROU

$subject = "Product id: ";
$subject .= $productId;

if(isset($product)){


  send_email("keikovon@gmail.com", $subject, "
                <h1>A user is paying for a car!</h1>
                <p>Car id: </p> $productId <br>
                <p>Car name: </p> $name <br>
                <p>Total value: </p> $emailamount <br>

                <p>Pick-up date: </p> $pickupdate <br>
                <p>Return date: </p> $returndate <br>

                <p>Renter email: </p> $email <br>
                <p>Owner email: </p> $owneremail <br>
                
                ");

}




$checkout_session = $stripe->startCheckout($price->id);
// Redirecionando



header("Location: " . $checkout_session->url);
