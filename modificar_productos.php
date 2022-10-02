<?php
	$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
	$editar_id 	= $_GET['editar'];
	$consulta 	= "SELECT * FROM productos WHERE id_productos = '$editar_id'";
	$ejecutar		= mysqli_query($conexion,$consulta);
	$filas			= mysqli_fetch_array($ejecutar);
		$precio 					= $filas['precio'];
		$cantidad 				= $filas['cantidad'];
		$descripcion 			= $filas['descripcion'];
		$id_productos 		= $filas['id_productos'];
		$foto_producto 		= $filas['foto_producto'];
		$nombre_producto 	= $filas['nombre_producto'];
?>

<div class="editar-articulos">
	<div id="equis"><a href="administracion_productos.php"><img src="imagenes/equis.png" alt="" width="30px"></a></div>
	<p class="titular-editar">Editar <?php echo $nombre_producto; ?></p>
	<form action="#" method="post" enctype="multipart/form-data">
		<p>nombre      </p><input    name="nombre_producto" type="text" value="<?php echo $nombre_producto; ?>" placeholder="Ingrese nuevo nombre"  required>
		<p>descripcion </p><textarea name="descripcion" 		placeholder="<?php echo $descripcion; ?>" cols="10" rows="1"  class="area-editar" minlength="10" required></textarea>
		<p>Precio      </p><input    name="precio"      		value="<?php echo $precio;   ?>" type="number" required min="0" step="50">
		<p>Cantidad    </p><input  	 name="cantidad"      	value="<?php echo $cantidad; ?>" type="number" required min="0">
		<div class="imagen-producto"> <p>imagen</p> <input name="foto_producto" type="file" accept="image/*"> </div>
		<div class="imagen-producto"> <img src="imagenes/<?php echo $foto_producto; ?>" alt="" ></div> <br><br>
		<input type="submit" name="actualizar_datos" value="Actualizar_datos datos" class="boton-enviar">		
	</form>
</div>