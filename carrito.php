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
			if($_SESSION['id_rol'] !=3){
				header('location: iniciosesion-cliente.php');
			}
		}
		
		$id_usuario 	= $_SESSION['id_usuarios'];
		$foto_usuario 	= $_SESSION['foto_usuario'];
		$nomusuario 			= $_SESSION['nombre_usuario'];
		$apellido_usuario = $_SESSION['apellido_usuario'];
		$correo_usuario = $_SESSION['correo_usuario'];
		$telefono = $_SESSION['telefono_usuario'];
		$direccion_usuario = $_SESSION['direccion_usuario'];

		$verificar = "SELECT * from carrito where id_usuarios = $id_usuario";
		$enviar = mysqli_query($conexion,$verificar);
		
		date_default_timezone_set("America/Bogota");
		setlocale(LC_ALL,"es_ES");
		$time = time(); //- (1 * 7 * 60 * 60);
		$cerrar_sesion 	= date("Y-m-d H:i:s", $time);
		// $fecha_cierre 	= "INSERT INTO `usuarios` (`id_usuarios`, `id_rol`, `nombre_usuario`, `clave_usuario`, `direccion_usuario`, `correo_usuario`, `foto_usuario`, `apellido_usuario`, `telefono_usuario`, `fecha_cierre_sesion`) VALUES (NULL, '3', '', '', '', '', '', '', '', '$cerrar_sesion')";
		// $correr 				= mysqli_query($conexion,$fecha_cierre);
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
					<a href="principal-proveedor.php"><img src="imagenes/logo5.png" width="125"></a>
				</div>

				<ul class="links">
					<li class="link"><a href="productos.php" class="delineado">Productos</a></li>
					<li class="link"><a href="restaurantes.php" class="delineado">Restaurantes</a></li>
					<?php if($_SESSION['id_rol'] == 2){ echo "<li class='link'><a href='administracion_productos.php' class='delineado'>Mis productos</a></li>"; } ?>
				</ul>
			</div>

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

			<div id="toggle" class="boton-menu"></div>
		</nav>
		<br><br>
		
		<main>

			<?php
				$investigar = "SELECT carrito.id_carrito,carrito.id_usuarios,id_producto,cantidad_producto,cantidad_producto*productos.precio precio_subtotal, productos.id_productos,productos.id_usuarios as num_usuario,nombre_producto,descripcion,precio,cantidad as maximo,foto_producto FROM carrito INNER JOIN productos ON carrito.id_producto = productos.id_productos where carrito.id_usuarios = $id_usuario";
				$subtotal 	= "SELECT carrito.id_carrito,carrito.id_usuarios,id_producto, SUM(cantidad_producto*precio_subtotal) AS  Total FROM carrito where carrito.id_usuarios = $id_usuario";
				// $cantidad = "SELECT cantidad_producto,cantidad_producto*productos.precio precio_subtotal,productos.precio,nombre_producto FROM carrito INNER JOIN productos ON carrito.id_producto = productos.id_productos WHERE carrito.id_usuarios = 28";
				$ejecutar = mysqli_query($conexion,$subtotal);
				$run = mysqli_query($conexion,$investigar);
				if (mysqli_num_rows($run) > 0){

			?>

			<div class="productos-lista">
				<div class="maximo">
					<table class="tabla-carrito" border="1" cellspacing="3">
						<thead>
							<tr>
								<th class="lista-imagen"> Imagen      </th>
								<th class="product">      Producto  	</th>
								<th class="lista-precio"> Cantidad    </th>
								<th class="lista-precio"> Precio      </th>
								<th class="lista-nombre"> Eliminar    </th>
							</tr>
						</thead>

						<tbody>
							<?php
								while ($fila = mysqli_fetch_array($run)) {
									$id_carrito 					= $fila['id_carrito'];
									$id_proveedor 				= $fila['num_usuario'];
									$id_producto    			= $fila['id_producto'];
									$nombre_producto 			= $fila['nombre_producto'];
									$cantidad_maxima 			= $fila['maximo'];
									$cantidad_producto		= $fila['cantidad_producto'];
									$precio_subtotal			= $fila['precio_subtotal'];
									$foto_producto 				= $fila['foto_producto'];
									$precio_uni 					= $fila['precio'];
									$descripcion_producto = $fila['descripcion'];
							?>

							<tr>
								<td> <?php echo "<img src='imagenes/$foto_producto ?>'>"; ?>  </td>
								<td class="product"> <?php echo $nombre_producto; ?>    </td>
								<td class="lista-precio">X<?php echo $cantidad_producto; ?><a href="carrito.php? aumentar= <?php echo $id_carrito; ?>"><button class="mas">+/-</button></a></td>
								<td class="lista-precio">$ <?php echo $precio_subtotal; ?>         </td>
								<td><a href="carrito.php? eliminar= <?php echo $id_producto; ?>"><button class="eliminar"> X </button></a></td>
							</tr>

							<?php
									if(isset($_GET['eliminar'])){
										$id_producto = $_GET['eliminar'];
										$eliminar = "DELETE FROM carrito where id_usuarios = $id_usuario and id_producto = $id_producto";
										$carrito = mysqli_query($conexion,$eliminar);

										echo "<script>
														window.location.href ='carrito.php';
													</script> ";
									}
								}
							?>
						</tbody>

						<tfoot>
							<tr>
								<?php 
									while ($fila_precio=mysqli_fetch_array($ejecutar)) {
										$subtotal = $fila_precio['Total'];
								?>

								<th colspan="3" class="total"><b>Total a pagar</b></th><td colspan="2" class="total">$ <?php echo $subtotal; ?></td>
								
								<?php
									}
								?>
							</tr>

							<form action="#" method="post">
								<tr>
									<td colspan="2"><button name="confirmar">Comprar</button></td><td colspan="3"><button name="vaciar">Vaciar</button></td>
								</tr>
							</form>
						</tfoot>
					</table>
				</div>

				<?php
					if(isset($_GET['aumentar'])){
						include_once 'modificar_cantidad.php';
					}

					if(isset($_POST['seguro'])){
						$actualizar_cantidad = $_POST['cambiar'];

						$update = "UPDATE carrito SET cantidad_producto = '$actualizar_cantidad' WHERE id_carrito = '$num_carrito'";
						$ejecutar=mysqli_query($conexion,$update);

						if ($ejecutar){
							echo "<script>
											window.location.href ='carrito.php';
										</script> ";
						}
						else{
							echo "<script>
											alert ('no se pudo editar');
										</script>";
						}
					}
					if(isset($_POST['vaciar'])){
						$vaciar = "DELETE FROM carrito WHERE id_usuarios = $id_usuario";
						$eliminar_carrito=mysqli_query($conexion,$vaciar);

						if ($eliminar_carrito){
							echo "<script>
											alert ('Se vacio su carrito');
											window.location.href ='carrito.php';
										</script> ";
						}
						else{
							echo "<script>
											alert ('no se pudo vaciar');
										</script>";
						}
					}
				}
			?>

			<?php
				if(isset($_POST['confirmar'])){
					$consul = "SELECT carrito.id_carrito,carrito.id_usuarios,id_producto,cantidad_producto,cantidad_producto*productos.precio precio_subtotal, productos.id_productos,productos.id_usuarios as num_usuario,nombre_producto,descripcion,precio,cantidad as maximo,foto_producto, usuarios.nombre_usuario FROM carrito INNER JOIN productos INNER JOIN usuarios ON carrito.id_producto = productos.id_productos and productos.id_usuarios = usuarios.id_usuarios where carrito.id_usuarios = $id_usuario ORDER BY nombre_usuario asc";
					$correr = mysqli_query($conexion,$consul);
					if (mysqli_num_rows($correr) > 0){

			?>

			<div class="otros-productos">
				<div class="seccion-factura">
					<center><img src='imagenes/pago1.png' height='80' margin='auto'><br>
						<p>Nombres: 						<?php echo $nomusuario; 		?></p>
						<?php if($apellido_usuario != ''){?><p>Apellidos: <?php echo $apellido_usuario; ?></p><?php }?>
						<p>Direccion: 					<?php echo $direccion_usuario; ?></p>
						<p>Numero Telefonico: 	<?php echo $telefono; 			?></p>
						<p>Correo electronico: 	<?php echo $correo_usuario; ?></p><br>

						<div class="tabla-factura">
							<p>Articulos</p>
							<table class="articulos-factura" border="0" cellspacing="0">
								<thead>
									<tr>
										<th>Producto</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th class="no-exceder">Restaurante</th>
									</tr>
								</thead>

								<tbody>
									<?php
										while ($fila1 = mysqli_fetch_array($correr)) {
											$id_carrito 					= $fila1['id_carrito'];
											$id_proveedor 				= $fila1['num_usuario'];
											$id_producto    			= $fila1['id_producto'];
											$nombre_producto 			= $fila1['nombre_producto'];
											$cantidad_maxima 			= $fila1['maximo'];
											$cantidad_producto		= $fila1['cantidad_producto'];
											$precio_subtotal			= $fila1['precio_subtotal'];
											$foto_producto 				= $fila1['foto_producto'];
											$precio_uni 					= $fila1['precio'];
											$descripcion_producto = $fila1['descripcion'];
											$nombre_restaurante   = $fila1['nombre_usuario'];
										?>

									<tr>
										<td> <?php echo $nombre_producto; ?></td>
										<td> X<?php echo $cantidad_producto; ?></td>
										<td> $ <?php echo $precio_subtotal; ?></td>
										<td class="no-exceder"><?php echo $nombre_restaurante; ?></td>
									</tr>

									<?php
										}
									?>
								</tbody>
							</table>
						</div><b class="total-factura"> Total a pagar $ <?php echo $subtotal; ?></b>
						<form action="#" method="post"><button class='boton-factura' name="confirmar_compra">Enviar</button></form>
    			</div>
				</div>
			</div>

			<?php
				}
			}
			else{

			?>

			<div class="otros-productos">

			<?php 
			}
			?>
			<div class="encabezado2">Otros Productos</div>

			<?php
				$observar = "SELECT * FROM productos ORDER BY RAND() LIMIT 15";
				$ejecutar=mysqli_query($conexion,$observar);
				$contador = 0;

				while ($filas=mysqli_fetch_array($ejecutar)) {
					$id_producto 		 			= $filas['id_productos'];
					$id_proveedor 		 		= $filas['id_usuarios'];
					$nombre_producto 			= $filas['nombre_producto'];
					$descripcion_producto = $filas['descripcion'];
					$precio 							= $filas['precio'];
					$foto_producto 				= $filas['foto_producto'];

					$buscar = "SELECT productos.id_productos,productos.id_usuarios,nombre_producto,descripcion,precio,foto_producto, usuarios.id_usuarios,nombre_usuario FROM usuarios INNER JOIN productos  ON usuarios.id_usuarios = productos.id_usuarios where productos.id_usuarios = $id_proveedor;";
					$encontrar=mysqli_query($conexion,$buscar);

					if ($fila=mysqli_fetch_array($encontrar)) {
						$nombre_proveedor = $fila['nombre_usuario'];
			?>

			<div class="secc-artic">
				<div class="articulos2">
					<a href="#"><?php echo "<img src='imagenes/$foto_producto ?>'>";?></a>
					<p>$ 				<?php echo $precio ?></p>
					<button class="boton"><a href="carrito.php? agregar= <?php echo $id_producto; ?>">Agregar</a></button>
				</div>

				<div class="info-product">
					<span class="imagen"><?php echo "<img src='imagenes/$foto_producto ?>'>";?></span>
					<span class="info"><p><b><?php echo $nombre_producto; ?></b></p><p class="desc"><?php echo $descripcion_producto; ?></p><p class="ultimo"><b><?php echo $nombre_proveedor; ?></b></p></span>
				</div>
			</div>

			<?php
					}
				}

				if(isset($_GET['agregar'])){
					$agre_id_producto = $_GET['agregar'];
					$verificar_lista = "SELECT carrito.id_usuarios,carrito.id_producto,productos.id_productos,precio FROM carrito inner join productos on carrito.id_producto = productos.id_productos WHERE carrito.id_usuarios = $id_usuario and carrito.id_producto = $agre_id_producto";
					$buscar_product = "SELECT * from productos where id_productos = $agre_id_producto";
					$rebuscar = mysqli_query($conexion,$verificar_lista);
					$consultar = mysqli_query($conexion,$buscar_product);

					while ($linea1=mysqli_fetch_array($consultar)) {
						$precio_busqueda 		 	= $linea1['precio'];
					}

					if(mysqli_num_rows($rebuscar) == 0){
						$subir = "INSERT INTO carrito (id_usuarios,id_producto,precio_subtotal) values ($id_usuario,$agre_id_producto,$precio_busqueda)";
						$carrito = mysqli_query($conexion,$subir);
						echo "<script>window.location.href ='carrito.php';</script>";
					}
					else{
						echo "<script> alert ('ya esta este producto ');</script>";
						echo "<script>window.location.href ='carrito.php';</script>";
					}
				}
			?>
			<?php
				if(isset($_POST['confirmar_compra'])){
					$codigo_verificacion = rand(100000000,999999999);
					$codigo = $codigo_verificacion;
					$buscar_pedidos = mysqli_query($conexion,"SELECT * FROM pedidos where id_usuario = $id_usuario and estado = 'en proceso'");
						include_once 'envio_carrito.php';
						if($enviado){
							include_once 'qr.php';
							if(mysqli_num_rows($buscar_pedidos) > 0){
								echo "<script> alert('Por favor espere y verifique el estado de su pedido antes de volver a comprar'); </script>";
								echo "<script> window.location.href ='carrito.php';</script>";
							}
							else{
								$buscar_cantidad = mysqli_query($conexion,"SELECT Sum(cantidad_producto) as cantidad FROM carrito where id_usuarios = $id_usuario");
								while ($filas=mysqli_fetch_array($buscar_cantidad)) {
									$cantidad_pedido = $filas['cantidad'];
								}
								$insertar_pedidos = "INSERT into pedidos (id_usuario,numero_productos,estado,codigo_verificacion,fecha_compra,correo_destino,numero_destino) values ($id_usuario,$cantidad_pedido,'en proceso',$codigo_verificacion,'$cerrar_sesion','$correo_usuario','$telefono')";
								$execute = mysqli_query($conexion,$insertar_pedidos);

								if ($execute){
									echo "<script> alert('Se añadio su pedido a la lista, puede verificar su estado en el menu de navegacion'); </script>";
									$pedido_hecho = "DELETE from carrito where id_usuarios = $id_usuario";
									$vaciar_carrito = mysqli_query($conexion,$pedido_hecho);
								}
							}
						}	
					// }
				}
			?>

			<!-- </div>
		</div> -->
		</main>
		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
		<script src="js/main.js"></script>
	</body>

	<style>
		.seccion-factura {
			width: 100%; margin:auto;
			background: #24303c;
			padding: 25px;
			height: 700px;
			border-radius:5px;
			font-family: 'calibri';
			box-shadow: 7px 13px 37px #000;
		}
		.seccion-factura p{
			text-align: center;
			font-size: 18px;
			line-height: 40px;
			color: rgb(252, 197, 197); 
		}
		.boton-factura {
			border:none;
			background: rgb(230,39,39);
			background: linear-gradient(90deg, rgba(230,39,39,1) 10%, rgba(255,59,43,1) 50%, rgba(230,39,39,1) 90%);
			line-height:2em;
			border-radius:10px;
			font-size:19px;
			font-size:1.2rem;
			color:#fff;
			cursor:pointer;
			position: relative;
			top: 5px;
			width:calc(100% - 100px);
			-webkit-transition:all .2s ease;
			transition:all .2s ease;
		}
		.boton-factura:hover {
			background: rgb(199, 59, 59);
			background: linear-gradient(90deg, rgb(199, 59, 59) 10%, rgb(199, 59, 59) 50%, rgb(199, 59, 59) 90%);
			color:#eee;
			-webkit-transition:all .2s ease;
			transition:all .2s ease;
		}
		.tabla-factura{
			background-color: #202a34;
			width: 100%;
			height: 300px;
			overflow-y:auto;
			overflow-x: hidden;
			border-radius: 10px;
			/* border:solid 2px yellow; */
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
		.articulos-factura img{
			transform: translate(0%,5%);
		}
		.no-exceder{
			max-width:50px;
			overflow: hidden;
  		text-overflow: ellipsis;
		}
		@media screen and (max-width: 900px){
			.seccion-factura {
				width: 95%;
				/* margin-top:30px; */
			}
		}
		.total-factura{
			color:white;
		}
	</style>
</html>
