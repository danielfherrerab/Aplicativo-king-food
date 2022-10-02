<?php
    require_once ("PHPMailer/clsMail.php");
    $bytes = random_bytes(5);
    $token =bin2hex($bytes);
    $mailSend = new clsMail();
    $codigo= rand(1000,9999);
    $email = '23';
    $bodyHTML = '
    <html>
    <head>
      <title>Restablecer</title>
    </head>
    <body>
        <h1>KING FOOD</h1>
        <div style="text-align:center; background-color:#ccc">
            <p>Restablecer contraseña</p>
            <h3>Su codigo para recuperar '.$codigo.'</h3>
            <p> <a 
                href="http://localhost/logingrijalva/Sistema-de-login-y-registro-con-auth-token/reset.php?email='.$email.'&token='.$token.'"> 
                para restablecer da click aqui </a> </p>
            <p> <small>Si usted no envio este codigo favor de omitir</small> </p>
        </div>
    </body>
    </html>
    ';
    $enviado =  $mailSend->metEnviar("KINGFOOD","Correos Youtube","danielpipe39@gmail.com","VERIFICACION", $bodyHTML);

    if($enviado){
        echo ("Enviado");
    }else {
        echo ("No se pudo enviar el correo");
    }

?>