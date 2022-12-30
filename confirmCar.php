<?php
    include ('connection.php');
    //Checar sessão, se não estiver logado redirecionar para o login

    $id = intval($_GET['id']);

    $returnDate = $_GET['returnal'];
    $initialDate = date("Y-m-d"); //Retorna o dia atual.

    $difference = strtotime($returnDate)-strtotime($initialDate); //Compara e retorna o valor em dias
    $difference = $difference/(24*60*60);

    if(isset($_POST['amountOfDays']))
        $difference = intval( $_POST['amountOfDays']);

    //Equaliza os dias para que o minimo seja 1.
    if($difference < 1)
        $difference = 1;

    echo "Difference is: ".$difference." days";



    //Query, que checa o carro selecionado 
    $sql_cliente = "SELECT * FROM cars WHERE id = '$id'";
    $query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
    $cliente = $query_cliente->fetch_assoc();

 
    //Checa se a variavel retornou algo.
    if(!($cliente == null)){

        if(!$cliente['available'] > 0){
            $carFinalValue = $cliente['daily_value'];
            //Carro disponivel
            echo "The car value is: " . $difference * $carFinalValue;
    
    
    
        }
        else{
            //Carro indisponivel
            echo "Sorry, this car is not available at the moment...";
            //Link para o seletor de veículos.
            die();
        }
        
    }
    else{
        //Carro não encontrado
        echo "Sorry, there is no car in here...";
        //Link para o seletor de veículos.
        die();
    }

    
//Carro com valor diario e opção de aumentar o tempo de locação
//Após isso enviar o usuario para o pagamento
//Botão com metodo post


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="" method="POST">
        <input type="text" name="amountOfDays" value=<?php $difference?>>
        <button type="submit">CALCULATOR</button>
    </form>
</body>
</html>