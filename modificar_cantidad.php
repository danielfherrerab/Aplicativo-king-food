<?php
  if(isset($_GET['aumentar'])){
    $conexion             = mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
    $num_carrito 	        = $_GET['aumentar'];
    $actualizar_cantidad 	= "SELECT carrito.id_carrito,carrito.id_usuarios,id_producto,cantidad_producto,cantidad_producto*productos.precio precio_subtotal, productos.id_productos,productos.id_usuarios as num_usuario,nombre_producto,descripcion,precio,cantidad as maximo,foto_producto FROM carrito INNER JOIN productos ON carrito.id_producto = productos.id_productos WHERE id_carrito = $num_carrito";
    $ejecutar		          = mysqli_query($conexion,$actualizar_cantidad);

    $filas = mysqli_fetch_array($ejecutar);
    $cantidad_maxima      = $filas['maximo'];  
    $actu_precio 			    = $filas['precio'];
    $actu_restaurante     = $filas['num_usuario'];  
    $actu_descripcion 		= $filas['descripcion'];
    $actu_id_productos 		= $filas['id_productos'];
    $actu_foto_producto 	= $filas['foto_producto'];
    $actu_nombre_producto = $filas['nombre_producto'];
    $actu_cantidad 		    = $filas['cantidad_producto'];

    $mirar = mysqli_query($conexion,"SELECT productos.id_usuarios, usuarios.nombre_usuario from productos inner join usuarios on productos.id_usuarios = usuarios.id_usuarios where usuarios.id_usuarios = $actu_restaurante");
    while ($solo_restaurante=mysqli_fetch_array($mirar)) {
      $actu_restaurante 	= $solo_restaurante['nombre_usuario'];
    }
  }
?>

<div class="modificar">
	<?php echo "<img src='imagenes/$actu_foto_producto ?>' class='muestra'>"?>
	<span class="info"><p class="nombre"><?php echo $actu_nombre_producto; ?></p><p><?php echo $actu_descripcion; ?></p>Precio unitario: <b><?php echo $precio_uni; ?></b>
    <form action="#" method="post">
      Cantidad a comprar: <input type="number" name="cambiar" value="<?php echo $actu_cantidad; ?>" min="1" max="<?php echo $cantidad_maxima; ?>">
      <input type="submit" value="+/-" name="seguro">
    </form>
    <p>(Para cambiar la cantidad correctamente pulse sobre el boton morado)</p>
    <p class="ultimo"><?php echo $actu_restaurante; ?></p><br>
  </span>
  <div class="equis"><a href="carrito.php"><img src="imagenes/equis.png" alt="" width="30px"></a></div>
</div>