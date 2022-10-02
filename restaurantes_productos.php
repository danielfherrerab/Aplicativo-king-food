<!DOCTYPE html>
<html lang="es">

	<?php
		include_once 'conexion.php';error_reporting(0);
		$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
		session_start();

		$id_sesion 				= $_SESSION['id_usuarios'];
		$id_usuario 			= $_SESSION['id_usuarios'];
		$foto_usuario 		= $_SESSION['foto_usuario'];
		$nomusuario 			= $_SESSION['nombre_usuario'];
		$apellido_usuario = $_SESSION['apellido_usuario'];
		$correo_usuario 	= $_SESSION['correo_usuario'];

		$id_restaurante = $_GET['restaurantes'];
		$consulta = "SELECT * FROM productos WHERE id_usuarios = '$id_restaurante'";

		$verificar_productos = mysqli_query($conexion,"SELECT * FROM productos WHERE id_usuarios = '$id_restaurante'");
		$info_restaurantes = "SELECT * FROM usuarios WHERE id_usuarios = '$id_restaurante'";

		if(mysqli_num_rows($verificar_productos) > 0){
			$ejecutar=mysqli_query($conexion,$consulta);
			$filas=mysqli_fetch_array($ejecutar);
				$id_productos 		= $filas['id_productos'];
				$id_usuarios 			= $filas['id_usuarios'];
				$nombre_producto 	= $filas['nombre_producto'];
				$descripcion 			= $filas['descripcion'];
				$precio 					= $filas['precio'];
				$cantidad 				= $filas['cantidad'];
				$foto_producto 		= $filas['foto_producto'];
		}

		$imprimir=mysqli_query($conexion,$info_restaurantes);
		$filas=mysqli_fetch_array($imprimir);
			$nombre_usuario 	= $filas['nombre_usuario'];
			$foto_restaurante = $filas['foto_usuario'];		
	?>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vi/ewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/micss.css">
    <title>Principal</title>
  </head>

  <body background="imagenes/fondo-web.png" class="img">
		<nav class="barra-navegacion">
			<div class="contenedor-nav">
				<div class="contenedor-logo">
					<?php if(!isset($_SESSION['id_rol'])){?><a href="index.php"><img src="imagenes/logo5.png" width="125"></a><?php } else{?><a href="iniciosesion-cliente.php"><img src="imagenes/logo5.png" width="125"></a><?php } ?>
				</div>

				<ul class="links">
					<li class="link"><a href="productos.php" class="delineado">Productos</a></li>
					<li class="link"><a href="restaurantes.php" class="delineado">Restaurantes</a></li>
					<?php if($_SESSION['id_rol'] == 3){ echo '<li class="link"><a href="carrito.php" class="delineado">Mi carrito</a></li><li class="link"><a href="cuenta_personal.php" class="delineado">Mi perfil</a></li>';}?>
					<?php if($_SESSION['id_rol'] == 2){ echo "<li class='link'><a href='administracion_productos.php' class='delineado'>Mis productos</a></li><li class='link'><a href='cuenta_proveedores.php' class='delineado'>Mi perfil</a></li>"; } ?>
				</ul>
			</div>

			<?php 
				if(!isset($_SESSION['id_rol'])){}
				else{
			?>

			<div class="submenu">
				<a href="cuenta_personal.php"><?php echo "<img src='imagenes/$foto_usuario ?>' class='foto-perfil' alt=''  title='Mi perfil'>";?></a>
				<div id="info-perfil">
					<a href="#" class="datos-usuario">	<?php echo $nomusuario."<br>".$apellido_usuario; ?></a>
					<a href="#" class="datos-usuario">	<?php echo $correo_usuario; 										 ?></a>
					<form action="iniciosesion-cliente.php" method="POST">
						<input type="submit" name="cerrar_sesion" value="Cerrar sesion" class="datos-usuario">
					</form>
				</div>
			</div>

			<?php
				}
			?>

			<div id="toggle" class="boton-menu"></div>
		</nav>

		<br><br>

		<p class="nom_restaurante" align="center"><?php echo $nombre_usuario; ?></p><br>
		<div align="center"><?php echo "<img src='imagenes/$foto_restaurante ?>' class='logo_restaurante' alt=''>"; ?></div>
		<br><br>

		<div class="fondo_res">
			<br>
				<div class="lista-multi2">

					<?php
						$observar = "SELECT * FROM productos where id_usuarios = '$id_restaurante'";
						$ejecutar=mysqli_query($conexion,$observar);
						$id = $_GET['restaurantes'];

						while ($filas=mysqli_fetch_array($ejecutar)) {
							$id_producto = $filas['id_productos'];
							$nombre_producto =  $filas['nombre_producto'];
							$precio = $filas['precio'];
							$foto_producto =    $filas['foto_producto'];

					?>

					<div class="articulos2">
						<a href="#"><?php echo "<img src='imagenes/$foto_producto ?>'>";?></a>
						<p>$ 				<?php echo $precio ?></p>
						<button class="boton"><a href="restaurantes_productos.php? agregar= <?php echo $id_producto; ?>">Agregar</a></button>
					</div>

					<?php
						}
						if(isset($_GET['agregar'])){
							if(!isset($_SESSION['id_rol'])){
								echo "<script> alert ('Debe iniciar sesion para agregar productos');</script>";
								echo "<script> javascript:history.back() </script>";
							}
							else{
								$agre_id_producto = $_GET['agregar'];
								if($_SESSION['id_rol'] == 2){
									echo '<script> alert("Debe iniciar sesion como cliente para agregar productos al carrito"); </script>';
									echo "<script> javascript:history.back() </script>";
								}
								else{
									$verificar_lista = "SELECT carrito.id_usuarios,carrito.id_producto,productos.id_productos,precio FROM carrito inner join productos on carrito.id_producto = productos.id_productos WHERE carrito.id_usuarios = $id_sesion and carrito.id_producto = $agre_id_producto";
									$buscar_product = "SELECT * from productos where id_productos = $agre_id_producto";
									$rebuscar = mysqli_query($conexion,$verificar_lista);
									$consultar = mysqli_query($conexion,$buscar_product);

									while ($linea1=mysqli_fetch_array($consultar)) {
										$precio_busqueda 		 	= $linea1['precio'];
									}

									if(mysqli_num_rows($rebuscar) == 0){
										$subir = "INSERT INTO carrito (id_usuarios,id_producto,precio_subtotal) values ($id_sesion,$agre_id_producto,$precio_busqueda)";
										$carrito = mysqli_query($conexion,$subir);
										echo '<script>alert("Producto agregado al carrito, puede verlo en el boton de la corona");</script>';
										echo "<script> javascript:history.back() </script>";
									}
									else{
										echo "<script> alert ('ya esta este producto ');</script>";
										echo "<script> javascript:history.back() </script>";
									}
								}
							}
						}
					?>

			</div>
			<br>
		</div>

		<div class="logo-carrito"></div>	
		<img src="imagenes/logo-simbolo.png" id="carro" class="carrito-logo">

			<?php
				if($_SESSION['id_rol'] == 3){
				$verificar_carrito = mysqli_query($conexion,"SELECT * FROM carrito WHERE id_usuarios = '$id_sesion'");

				if(mysqli_num_rows($verificar_carrito) > 0){
			?>

			<div class="carrito">
				<p>articulos</p>
				<table class="articulos-carrito" border="0" cellspacing="0">
					<thead>
						<tr>
							<td class="tr">Imagen</td>
							<td class="tr">Producto</td>
							<td class="tr">Cantidad</td>
							<td class="tr">Precio</td>
						</tr>
					</thead>

					<tbody>

						<?php
							$investigar = "SELECT carrito.id_carrito,carrito.id_usuarios,id_producto,cantidad_producto, productos.id_productos,nombre_producto,precio,foto_producto FROM carrito INNER JOIN productos ON carrito.id_producto = productos.id_productos where carrito.id_usuarios = $id_sesion";
							$run = mysqli_query($conexion,$investigar);

							while ($fila = mysqli_fetch_array($run)) {
								$id_producto    	= $fila['id_producto'];
								$nombre_producto 	= $fila['nombre_producto'];
								$precio 					= $fila['precio'];
								$foto_producto 		= $fila['foto_producto'];
								$cantidad_producto = $fila['cantidad_producto'];
						?>

						<tr>
							<td class="imagen-carrito"><?php echo "<img src='imagenes/$foto_producto ?>' width='50px' class='foto'>";?></td>
							<td><?php echo $nombre_producto; ?></td>
							<td class="imagen-carrito">X<?php echo $cantidad_producto; ?></td>
							<td id="foto" >$ <?php echo $precio; ?></td>
							<td class="eliminar"><a href="restaurantes_productos.php? eliminar= <?php echo $id_producto; ?>" class="eliminar"> X </a></td>
						</tr>

						<?php
							if(isset($_GET['eliminar'])){
								$id_producto = $_GET['eliminar'];
								$eliminar = "DELETE FROM carrito where id_usuarios = $id_usuario and id_producto = $id_producto";
								$carrito = mysqli_query($conexion,$eliminar);

								echo "<script>
												javascript:history.back() </script>;
											</script> ";
							}
						}
						?>
							
					</tbody>
				</table>
				<table cellspacing="0" class="confirmar">
					<tr>
						<td><button class="izquierda-carrito"><a href="carrito.php">Comprar/Modificar</a></button></td>
						<td><button class="derecha-carrito">Vaciar</button></td>
					</tr>
				</table>
			</div>

			<?php
				}
			}
			else{

			?>

			<div class="carrito">
				<p>articulos</p>
				<div class="carrito-vacio">
					<img src="imagenes/carrito-vacio.png" alt="" width="100px"><br>
					<p class="nada">Aun no hay nada, no se ha añadido ningun producto regrese cuando añada algun producto</p>
				</div>
			</div>
			
			<?php
			}
			?>

		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
		<script src="js/main.js"></script>
	</body>
</html>