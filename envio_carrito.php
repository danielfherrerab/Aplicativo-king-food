<?php
	$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
  require_once ("PHPMailer/clsMail.php");
  $mailSend = new clsMail();
  $email = '23';
  $consul = "SELECT carrito.id_carrito,carrito.id_usuarios,id_producto,cantidad_producto,cantidad_producto*productos.precio precio_subtotal, productos.id_productos,productos.id_usuarios as num_usuario,nombre_producto,descripcion,precio,cantidad as maximo,foto_producto, usuarios.nombre_usuario FROM carrito INNER JOIN productos INNER JOIN usuarios ON carrito.id_producto = productos.id_productos and productos.id_usuarios = usuarios.id_usuarios where carrito.id_usuarios = $id_usuario order by nombre_usuario ASC";
  $correr = mysqli_query($conexion,$consul);
    
  $bodyHTML = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>';

  $bodyHTML .= '
    <style>
    	*{
        color:white;
    	}
      body {
        border-top:3px solid #ffdfbb;
        border-width: 100%;
        background: rgb(230,39,39);
        background: linear-gradient(90deg, rgba(230,39,39,1) 10%, rgba(255,59,43,1) 50%, rgba(230,39,39,1) 90%);
        padding:10px;
      }
      .seccion-factura {
        width: 100%;margin:auto;
        max-width:600px;
        background: #24303c;
				height: 700px;
				border-radius:5px;
				font-family: "calibri";
				box-shadow: 7px 13px 37px #000;
        border-top:solid 2px rgb(255, 88, 88);
	    }
			.seccion-factura p{
				text-align: center;
				font-size: 18px;
				line-height: 40px;
				color: rgb(252, 197, 197); 
			}
			.tabla-factura{
				background-color: #202a34;
				width: 100%;
				height: 300px;
				overflow-y:auto;
				overflow-x: hidden;
				border-radius: 10px;
			}
			.articulos-factura{
				width: 100%;
				padding: 10px;
				max-height:260px;
				overflow-y:auto;
				color:white;
				max-height: 2px;
				height:2px;
			}
			.articulos-factura td{
				border-bottom: solid 1px black;
			}
			.articulos-factura th{
				border-bottom: solid 1px black;
				text-align:left;
				padding-bottom:10px;
				color:#dcdddd;
				max-width: 50px;
			}
    	.vistageneral{
				background-color:rgb(255, 113, 113);
			  border-top:3px solid rgb(245, 77, 77);
        color:white;
			}
			a{
				text-decoration:none;
				color: rgb(252, 197, 197); 
			}
			@media screen and (max-width: 800px){
        .vistageneral{
          font-size:10px;
        }
      }
    </style>';

  $bodyHTML .= '
    </head>
    <body>
      <div class="vistageneral">
				<h2>Buen dia usuario '.$nomusuario.' '.$apellido_usuario.'<h2>
				<h2>Su codigo de verificacion de pedido es: '.$codigo_verificacion.'
				<h3>el presente mensaje es para verificarle que acaba de realizar una compra con los siguientes detalles:</h3>
				<div>
					<div class="seccion-factura">
						<center><h1>FACTURA</h1><br>
						<p>Nombre: '.$nomusuario.'</p>
						<p>Direccion: '.$direccion_usuario.'</p>
						<p>Numero Telefonico: '.$telefono.'</p>
						<p>Correo electronico: '.$correo_usuario.'</p><br>

						<div class="tabla-factura">
							<p>Articulos</p>
							<table class="articulos-factura" border="0" cellspacing="0">
								<thead>
									<tr>
										<td>Producto</td>
										<td>Cantidad</td>
										<td>Precio</td>
										<th class="no-exceder">Restaurante</th>
									</tr>
								</thead>

								<tbody>';

									while ($fila1 = mysqli_fetch_array($correr)) {
										$id_producto    			= $fila1['id_producto'];
										$nombre_producto 			= $fila1['nombre_producto'];
										$cantidad_producto		= $fila1['cantidad_producto'];
										$precio_subtotal			= $fila1['precio_subtotal'];
										$precio_uni 					= $fila1['precio'];
										$descripcion_producto = $fila1['descripcion'];
										$nombre_restaurante   = $fila1['nombre_usuario'];

  $bodyHTML .= '
									<tr>
										<td> '.$nombre_producto.'</td>
										<td> X'.$cantidad_producto.'</td>
										<td> $ '.$precio_subtotal.'</td>
										<td class="no-exceder">'.$nombre_restaurante.'</td>
									</tr>';

									}

  $bodyHTML .= '
								</tbody>
							</table>
						</div>
    			</div>
          <p><small>Si usted no realizo esta compra favor de comunicar de revisar su cuenta y comunicar al personal encargado</small></p>
        </div>
      </div>
    </body>
  </html>';
  $enviado =  $mailSend->metEnviar("KINGFOOD","Correos king food",$correo_usuario,"VERIFICACION", $bodyHTML);

  if($enviado){
    echo "<script>alert('revise su correo para ver la factura'); </script>";
  }
	else {
    echo "<script>alert('No se pudo enviar el correo'); </script>";
  }
    // echo "<script> 
    // javascript:history.back()</script>";
?>