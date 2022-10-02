<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="vi/ewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/micss.css">
</head>
<?php
	$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
	$editar_id 	= $_GET['editar'];
	$consulta 	= "SELECT * FROM usuarios WHERE id_usuarios = '$editar_id'";
	$ejecutar		= mysqli_query($conexion,$consulta);
	$filas			= mysqli_fetch_array($ejecutar);
		$actu_nombre_usuario 	= $filas['nombre_usuario'];
		$actu_direccion 			= $filas['direccion_usuario'];
		$actu_foto 						= $filas['foto_usuario'];
		$actu_telefono 				= $filas['telefono_usuario'];
?>
<section class="modal-container" id="modal_container">
  <div class="modal"><div id="cruz"><a href="javascript:history.back()"><img src="imagenes/equis.png" alt="" width="30px"></a></div>
  <form action="#" method="post" enctype="multipart/form-data">
    <h4>Actualizacion de datos</h4>
    <p>Nombre								</p><input class="controlsn" type="text" name="nombre"   		id="nombre"    placeholder="<?php echo $actu_nombre_usuario; ?>" required>
    <p>Foto de perfil				</p><input class="controlsn" type="file" name="cambio_foto" id="localidad" accept="image/*" required>
    <p>Direccion						</p><input class="controlsn" type="text" name="direccion" 	id="direccion" placeholder="<?php echo $actu_direccion; ?>" required>
    <p>Telefono de contacto	</p><input class="controlsn" type="text" name="telefono"    id="correo"    placeholder="<?php echo $actu_telefono; ?>" required>
		<input class="controls1" id="close" type="submit" value="Realizado" name="actualizar_datos">      		
	</form>
</section>