<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

function send_email($destinatario, $assunto, $mensagemHTML){


    require_once 'vendor/autoload.php';
    
    $mail = new PHPMailer(true);
    
    
    //Dados para autenticar o e-mail
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 1;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    
    $mail->Username = 'keikovon@gmail.com';
    $mail->Password = 'onggullbudldgwct';
    
    $mail->SMTPSecure = "ss1";
    
    //E-mail e remetente, sempre usar o que foi autenticado para evitar problemas.
    $mail->setFrom('keikovon@gmail.com');
    
    //Endereço a ser enviado
    $mail->addAddress($destinatario);
    
    $mail->isHTML(true);
    
    $mail->Subject = $assunto;
    $mail->Body = $mensagemHTML;
    
    if($mail->send()){
        //echo "Envio de e-mail concluido!";
    }
    else{
        //echo "Falha no envio.";
    }
}