<!DOCTYPE html>
<html lang="es">

	<?php
		include_once 'conexion.php';
		$conexion = mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
		session_start();error_reporting(0);
		if(isset($_SESSION['id_rol'])){
			header('location: iniciosesion-cliente.php');
		}
	?>

	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vi/ewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/micss.css">
    <title>Principal</title>
  </head>

	<style type="text/css">
		.fill2:focus,.fill2:hover{
			box-shadow:inset 0 0 0 2em var(--hover);
		}
		.fill2{
			--color:#f8f8f8;
			--hover:#f73636;
		}
		button.fill2{
			color:var(--color);
			transition:.25s;
		}
		button:focus.fill2,button:hover{
			border-color:var(--hover);
			color:rgb(0, 0, 0);
		}

		button.fill2{
			background:0 0;
			border:2px solid;
			font:inherit;
			line-height:1;margin:.5em;
			padding:1px 2px;
			width: 119px;
			height: 40px;
			cursor: pointer;
			border-radius: 3px;
		}
	</style>

	<body background="imagenes/fondo-web.png" class="img">
		<nav class="barra-navegacion">
			<div class="contenedor-nav">
				<div class="contenedor-logo">
					<a href="index.php"><img src="imagenes/logo5.png" width="125"></a>
				</div>

				<ul class="links"><form action="#" method="post">
					<li class="link"><button name="productos"><a class="delineado">Productos</a></button></li>
					<li class="link"><button name="restaurantes"><a class="delineado">Restaurantes</a></button></li>
					</form></ul>
			</div>

			<div class="buscar">				
				<form action="#" method="post">
					<div class="btn1"><i class="fas fa-search icon"></i></div>
					<input type="text" placeholder="pulse enter para buscar" name="buscar" value="">
				</form>
			</div>

			<form action="iniciosesion-cliente.php" method="POST">
				<div class="buttons4"><a href="iniciosesion-cliente.php"><button class="fill2">Iniciar sesión</button></a></div>
			</form>
			<div id="toggle" class="boton-menu"></div>
		</nav>

		<div class="seccion-principal">
			<div class="seccion1">
			<p class="titulo">Bienvenido a King Food</p>
				<p>Los mejores productos los encontraras<br> en un solo lugar<br><br>Si desea agregar sus productos haga click <a href="registro-proveedor.php">aqui</p></a>
			</div>

			<div class="seccion2">
				<p>A continuacion tendra una seleccion de productos que podra observar y añadir a la compra segun su gusto</p><br><img src="imagenes/20220921_140118_0000-removebg-preview.png" alt="">
			</div>
		</div>
		<br><br>
		<main>

			<?php
			if(isset($_POST['productos'])){
				echo '<div class="redireccion">Debe iniciar sesion para acceder a <u>productos</u></div>';
			}
			if(isset($_POST['restaurantes'])){
				echo '<div class="redireccion">Debe iniciar sesion para acceder a <u>restaurantes</u></div>';
			}
				if(isset($_POST['buscar'])){
					$nombre = $_POST["buscar"];
					$observar = "SELECT productos.id_productos,productos.id_usuarios,nombre_producto,descripcion,precio,foto_producto, usuarios.id_usuarios,nombre_usuario FROM productos INNER JOIN usuarios ON productos.id_usuarios = usuarios.id_usuarios WHERE nombre_producto LIKE '%$nombre%'";
					$ejecutar=mysqli_query($conexion,$observar);
					
					if(mysqli_num_rows($ejecutar) >=1){

			?>

			<div class="encabezado">Resultados de la busqueda</div><br>

			<div class="carrusel-multi"><br>
				<div class="lista-multi" id="lista-multi">
					<button class="articulos-arrow flecha-izquierda" id="flecha-izquierda" data-button="flecha-izquierda" onclick="app.processingButton(event)">
						<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path></svg>
					</button>

					<div class="rastreador" id="track">

						<?php
							while ($filas=mysqli_fetch_array($ejecutar)) {
								$id_producto 			= $filas['id_productos'];
								$id_usuarios 			= $filas['id_usuarios'];
								$nombre_producto 	= $filas['nombre_producto'];
								$descripcion_producto = $filas['descripcion'];
								$precio 					= $filas['precio'];
								$foto_producto 		= $filas['foto_producto'];

								$buscar = "SELECT productos.id_productos,productos.id_usuarios,nombre_producto,descripcion,precio,foto_producto, usuarios.id_usuarios,nombre_usuario FROM usuarios INNER JOIN productos  ON usuarios.id_usuarios = productos.id_usuarios where productos.id_usuarios = $id_usuarios;";
								$encontrar=mysqli_query($conexion,$buscar);

								if ($fila=mysqli_fetch_array($encontrar)) {
									$nombre_proveedor 		= $fila['nombre_usuario'];
									$direccion_proveedor	= $fila['direccion_usuario'];
						?>

						<div class="secc-artic">
							<div class="articulos">
								<a href="#"><?php echo "<img src='imagenes/$foto_producto ?>'>";?></a>
								<p class="limite"><?php echo $nombre_producto ?></p>
								<p>$ 				<?php echo $precio ?></p>
								<button class="boton"><a href="index.php? agregar= <?php echo $id_producto; ?>">Agregar</a></button>
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
			?>

			<div class="encabezado">productos recien añadidos</div>

			<div class="carrusel-multi"><br>
				<div class="lista-multi" id="lista-multi">
					<button class="articulos-arrow flecha-izquierda" id="flecha-izquierda" data-button="flecha-izquierda" onclick="app.processingButton(event)">
						<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path></svg>
					</button>

					<div class="rastreador" id="track">

						<?php
							$observar = "SELECT * FROM productos where id_usuarios > 0 ";
							$ejecutar=mysqli_query($conexion,$observar);
							$contador = 0;

							while ($filas=mysqli_fetch_array($ejecutar)) {
								$id_producto 		 			= $filas['id_productos'];
								$id_proveedor 		 		= $filas['id_usuarios'];
								$nombre_producto 			= $filas['nombre_producto'];
								$descripcion_producto = $filas['descripcion'];
								$precio 							= $filas['precio'];
								$foto_producto 				= $filas['foto_producto'];

								$buscar = "SELECT productos.id_productos,productos.id_usuarios,nombre_producto,descripcion,precio,foto_producto, usuarios.id_usuarios,nombre_usuario,direccion_usuario FROM usuarios INNER JOIN productos  ON usuarios.id_usuarios = productos.id_usuarios where productos.id_usuarios = $id_proveedor";
								$encontrar=mysqli_query($conexion,$buscar);
								if ($fila=mysqli_fetch_array($encontrar)) {
									$nombre_proveedor 		= $fila['nombre_usuario'];
									$direccion_proveedor	= $fila['direccion_usuario'];
						?>

						<div class="secc-artic">
							<div class="articulos">
								<a href="#"><?php echo "<img src='imagenes/$foto_producto ?>'>";?></a>
								<p class="limite"><?php echo $nombre_producto ?></p>
								<p>$ 				<?php echo $precio ?></p>
								<button class="boton"><a href="index.php? agregar= <?php echo $id_producto; ?>">Agregar</a></button>
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

								$buscar = "SELECT productos.id_productos,productos.id_usuarios,nombre_producto,descripcion,precio,foto_producto, usuarios.id_usuarios,nombre_usuario FROM usuarios INNER JOIN productos  ON usuarios.id_usuarios = productos.id_usuarios where productos.id_usuarios = $id_usuarios;";
								$encontrar=mysqli_query($conexion,$buscar);

								if ($fila=mysqli_fetch_array($encontrar)) {
									// $nombre_proveedor 		= $fila['nombre_usuario'];
									$direccion_proveedor	= $fila['direccion_usuario'];
						?>

						<div class="secc-artic">
							<div class="articulos">
								<a href="#"><?php echo "<img src='imagenes/$foto_producto ?>'>";?></a>
								<p class="limite"><?php echo $nombre_producto ?></p>
								<p>$ 				<?php echo $precio ?></p>
								<button class="boton"><a href="index.php? agregar= <?php echo $id_producto; ?>">Agregar</a></button>
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
			?>

			<div class="encabezado">restaurantes<br></div>

    	<div class="carrusel-multi"><br>
				<div class="lista-multi" id="lista-multi">
					<button class="articulos-arrow flecha-izquierda" id="flecha-izquierda" data-button="flecha-izquierda" onclick="app.processingButton(event)">
						<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path></svg>
					</button>

					<div class="rastreador" id="track">

						<?php
							$observar = "SELECT * FROM usuarios where id_usuarios >= 0 and id_rol = 2";
							$ejecutar=mysqli_query($conexion,$observar);

							while ($filas=mysqli_fetch_array($ejecutar)) {
								$id       							= $filas['id_usuarios'];
								$nombre_restaurante    	= $filas['nombre_usuario'];
								$direccion_restaurante 	= $filas['direccion_usuario'];
								$correo_restaurante   	= $filas['correo_usuario'];
								$telefono_restaurante  	= $filas['telefono_usuario'];
								$foto_proveedor 				= $filas['foto_usuario'];
								$verificar_productos = mysqli_query($conexion,"SELECT * FROM productos WHERE id_usuarios = '$id'");

								if(mysqli_num_rows($verificar_productos) > 0){
						?>

						<div class="secc-artic">
							<div class="articulos">
								<a href="restaurantes_productos.php? restaurantes= <?php echo $id; ?>"><?php echo "<img src='imagenes/$foto_proveedor ?>' class='foto-proveedor'>";?></a>
							</div>

							<div class="info-product">
								<span class="info-restaurante"><p class="restaurante-titulo">Restaurante: <b><?php echo $nombre_restaurante; ?></b></p><p>direccion: <?php echo $direccion_restaurante; ?></p><p>Correo de contacto: <?php echo $correo_restaurante; ?></p><p>Telefono: <?php echo $telefono_restaurante; ?></b></p></span>
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
		</main>

		<?php
			if(isset($_GET['agregar'])){
				echo '<div class="agregado">Debe iniciar sesion para poder añadir productos a la lista<br>
				<a href="iniciosesion-cliente.php"><u>Iniciar sesion</u></a></div>';
			}
		?>

		<div class="logo-carrito"></div>	
		<img src="imagenes/logo-simbolo.png" id="carro" class="carrito-logo">

		<div class="carrito">
			<p>articulos</p>
			<div class="carrito-vacio">
				<img src="imagenes/carrito-vacio.png" alt="" width="100px"><br>
				<p class="nada">Debe iniciar sesion para acceder a esta funcion</p>
			</div>
		</div>
		<center><footer>KING FOOD<br>SENA CME<br>Bogota D.C<br>kingfood.cme@gmail.com</footer><center>
		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
		<script src="js/main.js"></script>
	</body>
</html>
