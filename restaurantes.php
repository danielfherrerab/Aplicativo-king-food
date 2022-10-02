<!-- <!DOCTYPE html> -->
<html lang="es">

	<?php
		include_once 'conexion.php';
		$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
		session_start();

		if(!isset($_SESSION['id_rol'])){
				header('location: iniciosesion-cliente.php');
		}
		else{
			if(($_SESSION['id_rol'] <=0) and ($_SESSION['id_rol'] >=4)){
				header('location: iniciosesion-cliente.php');
			}
		}
		$id_usuario 	= $_SESSION['id_usuarios'];
		$foto_usuario 	= $_SESSION['foto_usuario'];
		$nomusuario 		= $_SESSION['nombre_usuario'];
		$correo_usuario = $_SESSION['correo_usuario'];
	?>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vi/ewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/micss.css">
    <title>Productos</title>
  </head>

  <body background="imagenes/fondo-web.png" class="img">
		<nav class="barra-navegacion">
			<div class="contenedor-nav">
				<div class="contenedor-logo">
					<a href="principal.php"><img src="imagenes/logo5.png" width="125"></a>
				</div>

				<ul class="links">
					<li class="link"><a href="productos.php" class="delineado">Productos</a></li>
					<li class="link"><a href="restaurantes.php" class="delineado">Restaurantes</a></li>
					<?php if($_SESSION['id_rol'] == 3){ echo '<li class="link"><a href="carrito.php" class="delineado">Mi carrito</a></li><li class="link"><a href="cuenta_personal.php" class="delineado">Mi perfil</a></li>';}?>
					<?php if($_SESSION['id_rol'] == 2){ echo '<li class="link"><a href="administracion_productos.php" class="delineado">Mis productos</a></li><li class="link"><a href="cuenta_proveedores.php" class="delineado">Mi perfil</a></li>'; } ?>

				</ul>
			</div>

			<div class="submenu">
				<a href="cuenta_personal.php"><?php echo "<img src='imagenes/$foto_usuario ?>' class='foto-perfil' alt=''  title='Mi perfil'>"; ?></a>

				<div id="info-perfil">
					<a href="#" class="datos-usuario">	<?php echo $nomusuario;			?> </a>
					<p class="datos-usuario"> 					<?php echo $correo_usuario;	?> </p>
					<form action="iniciosesion-cliente.php" method="POST">
						<input type="submit" name="cerrar_sesion" value="Cerrar sesion" class="datos-usuario">
					</form>
				</div>
			</div>
			<div id="toggle" class="boton-menu"></div>
		</nav>

		<br><br>

		<main>
			<div class="encabezado-productos">restaurantes a los que puedes comprar</div>
			<br>
			<div class="lista-multi2">

				<?php
					$observar = "SELECT * FROM usuarios where id_usuarios >= 0 and id_rol = 2";
					$ejecutar=mysqli_query($conexion,$observar);

					while ($filas=mysqli_fetch_array($ejecutar)) {
						$id       			= $filas['id_usuarios'];
						$foto_proveedor = $filas['foto_usuario'];
						$nombre_usuario = $filas['nombre_usuario'];

						$verificar_productos = mysqli_query($conexion,"SELECT * FROM productos WHERE id_usuarios = '$id'");

						if(mysqli_num_rows($verificar_productos) > 0){
				?>

				<div class="articulos2">
					<a href="restaurantes_productos.php? restaurantes= <?php echo $id; ?>"><?php echo "<img src='imagenes/$foto_proveedor ?>' class='foto-proveedor'>";?></a>
					<p> <?php echo $nombre_usuario; ?> </p>
				</div>

				<?php
						}
					}
				?>
			</div>		
		</main>

		<div class="logo-carrito"></div>	
			<img src="imagenes/logo-simbolo.png" id="carro" class="carrito-logo">

			<?php
			if($_SESSION['id_rol'] == 3){
			$verificar_carrito = mysqli_query($conexion,"SELECT * FROM carrito WHERE id_usuarios = '$id_usuario'");

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
							$investigar = "SELECT carrito.id_carrito,carrito.id_usuarios,id_producto,cantidad_producto, productos.id_productos,nombre_producto,precio,foto_producto FROM carrito INNER JOIN productos ON carrito.id_producto = productos.id_productos where carrito.id_usuarios = $id_usuario";
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
								<td class="eliminar"><a href="restaurantes.php? eliminar= <?php echo $id_producto; ?>" class="eliminar"> X </a></td>
							</tr>

						<?php
							if(isset($_GET['eliminar'])){
								$id_producto = $_GET['eliminar'];
								$eliminar = "DELETE FROM carrito where id_usuarios = $id_usuario and id_producto = $id_producto";
								$carrito = mysqli_query($conexion,$eliminar);

								echo "<script>
												window.location.href ='restaurantes.php';
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
							<p class="nada">Aun no hay nada, no se ha añadido ningun producto, regrese cuando añada algun producto</p>
						</tr>
						</div>
				</div>
			<?php
			}
			?>
	
		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
		<script src="js/main.js"></script>
	</body>
</html>
