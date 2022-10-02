<?php
	$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
  $borrar_id 				= $_GET['borrar'];
	$consulta 				= "SELECT * FROM productos WHERE id_productos = '$borrar_id'";
	$ejecutar					= mysqli_query($conexion,$consulta);
	$filas						= mysqli_fetch_array($ejecutar);
	$nombre_producto 	= $filas['nombre_producto'];
?>

<div class="borrar-articulos">
	<form action="#" method="post">
		<p>Desea eliminar <?php echo $nombre_producto; ?>  de su lista de articulos?</p>
		<input type="submit" name="borrar_datos" value="Borrar" class="boton-enviar">
	</form>
</div>