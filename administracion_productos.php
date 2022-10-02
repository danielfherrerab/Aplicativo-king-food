<!-- <!DOCTYPE html> -->
<html lang="es">

	<?php
		include_once 'conexion.php';
		session_start();

			if(!isset($_SESSION['id_rol'])) {
				header('location: iniciosesion-cliente.php');
			}
			else{
				if($_SESSION['id_rol'] !=2){
					header('location: iniciosesion-cliente.php');
				}
			}
			$foto_usuario 		= $_SESSION['foto_usuario'];
			$correo_usuario 	= $_SESSION['correo_usuario'];
			$nomusuario 			= $_SESSION['nombre_usuario'];
	?>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="width, initial-scale=1.0">
    <link rel="stylesheet" href="css/administracion.css"> 
    <link rel="stylesheet" href="css/micss.css"> 
    <title>KING FOOD</title>
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
					<li class="link"><a href="administracion_productos.php" class="delineado">Mis productos</a></li>
					<li class="link"><a href="cuenta_proveedores.php" class="delineado">Mi perfil</a></li>
				</ul>
			</div>

			<div class="buscar">
				<div class="btn"><i class="fas fa-search icon"></i></div>
				<input type="text" placeholder="Buscar" required>
			</div>

      <div class="submenu">
				<a href="cuenta_proveedores.php"> <?php echo "<img src='imagenes/$foto_usuario ?>' class='foto-perfil' alt=''  title='Mi perfil'>"; ?></a>
				<div id="info-perfil">
					<a href="#" class="datos-usuario">	
						<?php echo $nomusuario."<br>"; ?>
					</a>

					<a class="datos-usuario">
						<?php echo $correo_usuario;	 ?>
					</a>

					<form action="iniciosesion-cliente.php" method="POST">
						<input type="submit" name="cerrar_sesion" value="Cerrar sesion" class="datos-usuario">
					</form>
				</div>
			</div>
			<div id="toggle" class="boton-menu">
		</nav>

		<main>
			<br><div class="encabezado">administracion de Productos</div><br>
			<h5>- Usted podra anadir, modificar y eliminar productos. <br> - (*) Campos obligatorios </h5>

			<?php
				$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
				$id_usuarios  = $_SESSION['id_usuarios'];
				$observar     = "SELECT * FROM productos where id_usuarios = '$id_usuarios'";

				if(isset($_POST['buscar'])){
					$nombre = $_POST["busqueda"];
					$observar = "SELECT * FROM productos where nombre_producto LIKE ('%$nombre%') and id_usuarios = '$id_usuarios'";
				}
				$ejecutar=mysqli_query($conexion,$observar);
				if(mysqli_num_rows($ejecutar) > 0){
			?>
			
			<div class="cuadro-titulo1">Modificar / Eliminar productos</div>
			<div class="modifcar-productos">
				<table class="tabla-2" border="1" cellspacing="3">
					<thead>
						<tr>
							<th class="lista-nombre"> Nombre      </th>
							<th class="lista-nombre"> descripcion </th>
							<th class="lista-imagen"> Imagen      </th>
							<th class="lista-precio"> Precio      </th>
							<th class="lista-precio"> Cantidad    </th>
							<th class="lista-nombre"> Acciones    </th>
						</tr>
					</thead>

					<tbody>
						<?php
							while ($filas=mysqli_fetch_array($ejecutar)) {
								$id       				= $filas['id_productos'];
								$nombre_producto 	= $filas['nombre_producto'];
								$descripcion 			= $filas['descripcion'];
								$precio 					= $filas['precio'];
								$foto_producto 		= $filas['foto_producto'];
								$cantidad 				= $filas['cantidad'];
						?>

						<tr>
							<td><?php echo $nombre_producto;	?></td>
							<td><?php echo $descripcion; 			?></td>
							<td><?php echo "<img src='imagenes/$foto_producto ?>'>";?></td>
							<td class="lista-precio">$ <?php echo $precio;   ?>       </td>
							<td class="lista-precio">  <?php echo $cantidad; ?>       </td>
							<td><button><a href="administracion_productos.php? editar= <?php echo $id; ?>"> Editar </a></button><b class="desa">|||</b><button><a href="administracion_productos.php? borrar= <?php echo $id; ?>">Borrar</a></button></td>
						</tr>

						<?php
							}
						?>

					</tbody>
				</table>
			</div>

			<?php
					}
					else{
			?>

			<div class="cuadro-titulo1">Modificar / Eliminar productos</div>
			<div class="modifcar-productos">
				<table class="tabla-2">
					<tr>
						<td class="sin-conte">NO SE ENCONTRO NIGUN PRODUCTO</td>
					</tr>
				</table>
			</div>

			<?php
					}
			?>

			<form action="#" method="post" class="buscar-productos">
				<input  type="text"   name="busqueda" placeholder="Ingrese busqueda" class="busqueda">
				<input  type="submit" name="buscar"   value="Buscar">
				<button type="button" class="boton2"><a href="administracion_productos.php">Actualizar</a></button>
			</form>
				
			<?php
				if(isset($_GET['editar'])){
					include_once 'modificar_productos.php';
				}
			?>

			<?php
				if(isset($_POST['actualizar_datos'])){
					$actualizar_precio 				= $_POST['precio'];
					$actualizar_cantidad 			= $_POST['cantidad'];
					$actualizar_descripcion 	= $_POST['descripcion'];
					$actualizar_nombre 				= $_POST['nombre_producto'];
					$actualizar_foto_producto = $_FILES['foto_producto']['name'];

					$carpeta = "imagenes/";
					opendir($carpeta);
					$destino = $carpeta.$_FILES['foto_producto']['name'];
								
					copy($_FILES['foto_producto']['tmp_name'],$destino);
					$nombre = $_FILES['foto_producto']['name'];
					$verificar_foto = mysqli_query($conexion,"SELECT * from usuarios Where foto_usuario = '$nombre'");
					$nuevoNameFoto       = $_FILES['foto_producto']['name'];

					if(mysqli_num_rows($verificar_foto) > 0){

						$filename    = $_FILES['foto_producto']['name'];
						$sourceFoto  = $_FILES['foto_producto']['tmp_name'];

						date_default_timezone_set("America/Bogota");
						setlocale(LC_ALL,"es_ES");
						$fecha_imagen   = date("d/m/Y h:i A");

						$logitudPass    = 10;
						$newNameFoto    = substr( md5(microtime()), 1, $logitudPass);

						$explode        = explode('.', $filename);
						$extension_foto = array_pop($explode);
						$actualizar_foto_producto = $newNameFoto.'.'.$extension_foto;

						$dirLocal = "imagenes";

						if (!file_exists($dirLocal)) {
								mkdir($dirLocal, 0777, true);
						}

						$miDir         = opendir($dirLocal);
						$imagenCliente = $dirLocal.'/'.$nuevoNameFoto;

						if(move_uploaded_file($sourceFoto, $imagenCliente)){
							echo $imagenCliente;
							// echo "<script> alert('se pudo'); </script>"; 
						}
					}

					$update = "UPDATE productos SET nombre_producto = '$actualizar_nombre',descripcion = '$actualizar_descripcion',precio = '$actualizar_precio',cantidad = '$actualizar_cantidad',foto_producto = '$actualizar_foto_producto' WHERE id_productos = '$editar_id'";
					$ejecutar=mysqli_query($conexion,$update);

					if ($ejecutar){
						echo "<script>
										alert ('articulo editado con exito');
										window.location.href ='administracion_productos.php';
									</script> ";
					}
					else{
							echo "<script>
											alert ('no se pudo EDITAR');
										</script>";
						}
				}
			?>

			<?php
				if(isset($_GET['borrar'])){
					include_once 'borrar_productos.php';
				}
			?>

			<?php
				if(isset($_POST['borrar_datos'])){      
					$borrar = "DELETE FROM productos WHERE id_productos = '$borrar_id'";
					$ejecutar=mysqli_query($conexion,$borrar);
		
					if($ejecutar){
						echo "<script>
										alert ('Producto eliminado con exito');
										window.location.href ='administracion_productos.php';
									</script> ";
					}
					else{
						echo "<script>
										alert ('no se pudo borrar');
									</script>";
					}
				}
				unset($_POST['borrar']);
			?>

			<br><br>
			<div class="cuadro-titulo">Añadir productos</div>
			<div class="seccion-proveedor">
        <br>
				<div class="superior">
					<div class="span1">
						<form action="#" method="post" enctype="multipart/form-data">
							Nombre del producto*<br>
							<input type="text" name="nombre_producto" placeholder="Ingrese nombre de producto"  class="texto" minlength="4" required><br>
							Descripcion*<br>
							<textarea name="descripcion_producto" cols="10" rows="1"  class="area-editar" placeholder="Ingrese nueva descripcion al producto" minlength="10" required></textarea><br>
							Precio del producto*<br>
							<input type="number" name="precio_producto" placeholder="Ingrese precio de producto"  class="texto" min="0" step="50"><br>
							Cantidad del producto*<br>
							<input type="number" name="cantidad_producto" placeholder="Ingrese cantidad de producto"  class="texto" min="1"><br>
							Imagen*<br>
							<input type="file" name="agre_foto_producto" class="controls" id="seleccionArchivos" accept="image/*" required>
							<input type="submit" name="insertar" value="Añadir producto" class="agregar">
						</form>
					</div>
					<div class="span2">
						<img src="imagenes/interrogante.png" class="superpuesto">
						<img id="imagenPrevisualizacion" alt="" class="temporal">
					</div>

					<?php
						include_once 'conexion.php';
						$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');

						if(isset($_POST['insertar'])){
							$id_rol 							= $_SESSION['id_rol'];
							$id_usuarios 					= $_SESSION['id_usuarios'];
							$nombre_producto 			= $_POST['nombre_producto'];
							$precio_producto 			= $_POST['precio_producto'];
							$cantidad_producto 		= $_POST['cantidad_producto'];
							$descripcion_producto = $_POST['descripcion_producto'];
							$nombre 							= $_FILES['agre_foto_producto']['name'];

							$carpeta = "imagenes/";
							opendir($carpeta);
							$destino = $carpeta.$_FILES['agre_foto_producto']['name'];
											
							copy($_FILES['agre_foto_producto']['tmp_name'],$destino);
							$nombre = $_FILES['agre_foto_producto']['name'];
							$verificar_foto = mysqli_query($conexion,"SELECT * from usuarios Where foto_usuario = '$nombre'");
							$nuevoNameFoto       = $_FILES['agre_foto_producto']['name'];

							if(mysqli_num_rows($verificar_foto) > 0){
								$filename    = $_FILES['agre_foto_producto']['name'];
								$sourceFoto  = $_FILES['agre_foto_producto']['tmp_name'];

								date_default_timezone_set("America/Bogota");
								setlocale(LC_ALL,"es_ES");
								$fecha_imagen   = date("d/m/Y h:i A");

								$logitudPass    = 10;
								$newNameFoto    = substr( md5(microtime()), 1, $logitudPass);

								$explode        = explode('.', $filename);
								$extension_foto = array_pop($explode);
								$nuevoNameFoto  = $newNameFoto.'.'.$extension_foto;

								$dirLocal = "imagenes";

								if (!file_exists($dirLocal)) {
									mkdir($dirLocal, 0777, true);
								}

								$miDir         = opendir($dirLocal);
								$imagenCliente = $dirLocal.'/'.$nuevoNameFoto;

								if(move_uploaded_file($sourceFoto, $imagenCliente)){
									echo $imagenCliente;
									// echo "<script> alert('se pudo'); </script>"; 
								}
							}

							$insertar = "INSERT INTO productos (id_usuarios,nombre_producto,descripcion,precio,cantidad,foto_producto) values ('$id_usuarios','$nombre_producto','$descripcion_producto','$precio_producto','$cantidad_producto','$nombre')";
							$ejecutar = mysqli_query($conexion,$insertar);

							if ($ejecutar){
								echo "<script>
												alert ('Producto agregado con exito');
												window.location.href ='administracion_productos.php';
											</script> ";
							}
						}
					?>

    	</div>
  	</main>

		<center><footer>KING FOOD<br>SENA CME<br>Bogota D.C<br>kingfood.cme@gmail.com</footer><center>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
		<script src="js/tabla-edicion.js"></script>
		<script>
      const $seleccionArchivos = document.querySelector("#seleccionArchivos"),
      $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

      $seleccionArchivos.addEventListener("change", () => {
        const archivos = $seleccionArchivos.files;
        if (!archivos || !archivos.length) {
          $imagenPrevisualizacion.src = "";
          return;
        }
        const primerArchivo = archivos[0];
        const objectURL = URL.createObjectURL(primerArchivo);
        $imagenPrevisualizacion.src = objectURL;
      });
    </script>
  </body>
</html>
