<?php
  //Agregamos la libreria para genera códigos QR
	require_once "phpqrcode/qrlib.php";    

    $contenido = 'Usuario: '.$nomusuario.' codigo_comprobacion: '.$codigo_verificacion;
    $filename="prueba.png";
    $level="QR_ECLEVEL_A";
    $tamaño="6";

    if(!extension_loaded("GD")) {
        die('<html><body><p>No esta habilitada la extencion GD</p></body></html>');
    }
	
	
        //Enviamos los parametros a la Función para generar código QR 
	QRcode::png(
        $contenido, 
        $filename, 
        $level, 
        $tamaño); 

    $originalQR=@imagecreatefrompng("prueba.png");
    if (FALSE===$originalQR) {
        die('<html><body><img alt="QR" src="prueba.png"></body></html>');
    }
    $logoYT=@imagecreatefrompng("imagenes/logoT.png");
    if (FALSE===$logoYT) {
        die('<html><body><img alt="QR" src="prueba.png"></body></html>');
    }

    $dataQR=getimagesize("prueba.png");
    $dataYT=getimagesize("imagenes/logoT.png");

    list($width, $height) = getimagesize("prueba.png"); 
    list($ywidth, $yheight) = getimagesize("imagenes/logoT.png"); 
    $ywidth="51";
    $yheight="50";

    $newQR = imagecreatetruecolor($width, $height);

    imagecopy(
        $newQR,
        $originalQR,
        0,
        0,
        0,
        0,
        $width,
        $height
    );

    imagecopy(
        $newQR,
        $logoYT,
        ($width/2)-($ywidth/2),
        ($height/2)-($yheight/2),
        10,
        0,
        $ywidth,
        $yheight
    );
    $compra = time();
    $fecha_compra = date("YmdHi",$compra);
    $paciente = "compra_".$fecha_compra;
    imagepng($newQR,"codigo_qr/$paciente.png",1);
?>
<!DOCTYPE html>
<html lang="es">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vi/ewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/micss.css">
    <title>Principal</title>
  </head>

  <body background="imagenes/fondo-web.png" class="img">
    <div class="compra_realizada">
    <?php echo "<img src='codigo_qr/$paciente.png ?>' alt='QR Con Logo' class='qr'> ";?>
      <p>!Gracias por su compra¡<i> Debe presentar este codigo qr al encargado de entrega para verificar el pedido</i></p>
      <div class="descarga"><?php echo "<a href='codigo_qr/$paciente.png' download>"; ?><button>Descargar QR</button></a></div>
      <button class="volver"><a href="principal.php">Ir al inicio</a></button>
    </div>
    <script>
      async function downloadImage(imageSrc) {
        const image = await fetch(imageSrc)
        const imageBlog = await image.blob()
        const imageURL = URL.createObjectURL(imageBlog)

        const link = document.createElement('a')
        link.href = imageURL
        link.download = 'image file name here'
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
      }
    </script>
  </body>
</html>