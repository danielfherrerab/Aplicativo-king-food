<!-- <!DOCTYPE html> -->
<html lang="es">

	<?php
		include_once 'conexion.php';
		$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
		session_start();error_reporting(0);

		if(!isset($_SESSION['id_rol'])){
			header('location: iniciosesion-cliente.php');
		}
		else{
			if(($_SESSION['id_rol'] <=0) and ($_SESSION['id_rol'] >=4)){
				header('location: iniciosesion-cliente.php');
			}
		}
		$id_sesion 	= $_SESSION['id_usuarios'];
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
					<?php if($_SESSION['id_rol'] == 2){ echo "<li class='link'><a href='administracion_productos.php' class='delineado'>Mis productos</a></li>"; } ?>
					
				</ul>
			</div>

			<div class="buscar">
				<div class="btn"> <i class="fas fa-search icon"></i> </div>
				<input type="text" placeholder="Buscar">
			</div>

			<div class="submenu">
				<a href="cuenta_personal.php"><?php echo "<img src='imagenes/$foto_usuario ?>' class='foto-perfil' alt=''  title='Mi perfil'>"; ?></a>
				<div id="info-perfil">
					<a href="#" class="datos-usuario">	<?php echo $nomusuario 			?> </a>
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
			<div class="encabezado-productos">productos </div><br>

			<?php
				$seleccionar = "SELECT * FROM usuarios WHERE id_rol = 2";
				$busqueda_restaurantes = mysqli_query($conexion,$seleccionar);

				while ($filas=mysqli_fetch_array($busqueda_restaurantes)) {
					$id_restaurante = $filas['id_usuarios'];
					$nombre_proveedor = $filas['nombre_usuario'];

					$buscar_productos = mysqli_query($conexion,"SELECT * from productos Where id_usuarios = $id_restaurante");
					if(mysqli_num_rows($buscar_productos) > 0){
			?>

			<div class="encabezado">Productos de <?php echo $nombre_proveedor; ?> </div><br>

			<div class="carrusel-multi"><br>
				<div class="lista-multi" id="lista-multi">
					<button class="articulos-arrow flecha-izquierda" id="flecha-izquierda" data-button="flecha-izquierda" onclick="app.processingButton(event)">
						<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path></svg>
					</button>

					<div class="rastreador" id="track">

						<?php
							$observar = "SELECT * FROM productos where id_usuarios = $id_restaurante";
							$ejecutar=mysqli_query($conexion,$observar);

							while ($filas=mysqli_fetch_array($ejecutar)) {
								$id_producto 					= $filas['id_productos'];
								$id_usuarios 					= $filas['id_usuarios'];
								$nombre_producto 			= $filas['nombre_producto'];
								$descripcion_producto = $filas['descripcion'];
								$precio 							= $filas['precio'];
								$foto_producto 				= $filas['foto_producto'];

								$buscar = "SELECT productos.id_productos,productos.id_usuarios,nombre_producto,descripcion,precio,foto_producto, usuarios.id_usuarios,nombre_usuario,direccion_usuario FROM usuarios INNER JOIN productos  ON usuarios.id_usuarios = productos.id_usuarios where productos.id_usuarios = $id_usuarios;";
								$encontrar=mysqli_query($conexion,$buscar);

								if ($fila=mysqli_fetch_array($encontrar)) {
									$nombre_proveedor 		= $fila['nombre_usuario'];
									$direccion_proveedor	= $fila['direccion_usuario'];
						?>

						<div class="secc-artic">
							<div class="articulos2">
								<a href="#"><?php echo "<img src='imagenes/$foto_producto ?>'>";?></a>
								<p class="limite"><?php echo $nombre_producto ?></p>
								<p>$ 				<?php echo $precio ?></p>
								<button class="boton"><a href="productos.php? agregar= <?php echo $id_producto; ?>">Agregar</a></button>
							</div>
							<div class="info-product">
								<span class="imagen">			<?php echo "<img src='imagenes/$foto_producto ?>'>";?></span>
								<span class="info"><p><b>	<?php echo $nombre_producto; ?></b></p><p class="desc"><?php echo $descripcion_producto; ?></p><p class="ultimo"><b><?php echo $nombre_proveedor; ?><br><small><?php echo $direccion_proveedor; ?></small></b></p></span>
							</div>
						</div>

						<?php
								}
							}
						?>
						
					</div>
					<button class="articulos-arrow articulos-next" id="button-next" data-button="button-next" onclick="app.processingButton(event)">
						<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg>
					</button>
				</div>
			</div>

			<?php
					}
				}
				if(isset($_GET['agregar'])){
					$agre_id_producto = $_GET['agregar'];

					if($_SESSION['id_rol'] == 2){
						echo '<div class="iniciar_sesion">Debe iniciar sesion como cliente para agregar productos al carrito<a href="productos.php">X</a></div>';
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
							echo '<div class="agregado">Producto agregado al carrito, puede verlo en el boton de la corona</div>';
							// echo "<script> window.location.href ='productos.php'; </script>";
						}
						else{
							echo "<script> alert ('ya esta este producto ');</script>";
						}
					}
				}
			?>
		
		</main>

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
							<td class="eliminar"><a href="productos.php? eliminar= <?php echo $id_producto; ?>" class="eliminar"> X </a></td>
						</tr>

						<?php
								if(isset($_GET['eliminar'])){
									$id_producto = $_GET['eliminar'];
									$eliminar = "DELETE FROM carrito where id_usuarios = $id_usuario and id_producto = $id_producto";
									$carrito = mysqli_query($conexion,$eliminar);

									echo "<script>
													window.location.href ='principal.php';
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
	

		<center><footer>KING FOOD<br>SENA CME<br>Bogota D.C<br>kingfood.cme@gmail.com</footer><center>
		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
		<script src="js/main.js"></script>
	</body>
</html>
