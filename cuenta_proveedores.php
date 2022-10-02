<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vi/ewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/micss.css">
    <title>Principal</title>
  </head>

  <?php
		include_once 'conexion.php';
		$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
		session_start();

		if(!isset($_SESSION['id_rol'])){
			header('location: iniciosesion-cliente.php');
		}
		else{
			if($_SESSION['id_rol'] !=2){
				header('location: iniciosesion-cliente.php');
			}
		}
      $id_usuario 	    = $_SESSION['id_usuarios'];
			$foto_usuario 		= $_SESSION['foto_usuario'];
			$correo_usuario 	= $_SESSION['correo_usuario'];
			$nomusuario 			= $_SESSION['nombre_usuario'];
      $direccion_usuario = $_SESSION['direccion_usuario'];
      $telefono_usuario = $_SESSION['telefono_usuario'];
	?>

  <body background="imagenes/fondo-web.png" class="img">
		<nav class="barra-perfil">
			<ul class="lista-mayor">
        <li class="apartado"><a href="principal-proveedor.php"><img src="imagenes/logo2.png" alt="logotipo" class="logo-perfil"></a></li>
				<li class="apartado"><button class="button type2"><a href="principal-proveedor.php">Inicio</a></button><br><br></li>
				<li class="apartado"><button class="button type3" id="open"><a href="cuenta_proveedores.php? editar= <?php echo $id_usuario; ?>">Editar Informacion</a></button><br><br></li>
        <li class="apartado"><button class="button type2"><form action="iniciosesion-cliente.php" method="POST"><input type="submit" name="cerrar_sesion" value="Cerrar sesion"></form></button></li>
        <li class="apartado"><form action="#" method="post"><a aria-label='Thanks' class='h-button centered' data-text='Eliminar cuenta' href='#'><button name="delete" class="delete"><span>¿SEGURO?</span></button></a></form></li>
			</ul>
			<div class="boton-perfil"><center>||</center></div>
		</nav>

    <?php
			if(isset($_POST['delete'])){
        $conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
        $borrar = mysqli_query($conexion,"DELETE FROM usuarios WHERE correo_usuario = '$correo_usuario'");

				if($borrar){
          session_unset();
          unset($_SESSION["correo_usuario"]);
          session_destroy();//header('Location:../login.php');
					echo "<script>
									alert ('usuario eliminado con exito');
									window.location.href ='iniciosesion-cliente.php';
								</script> ";
				}
				else{
					echo "<script>
								  alert ('no se pudo borrar');
								</script>";
				}
				unset($_POST['borrar']);
      }
    ?>

		<main>
		  <section class="seccion-perfil-usuario">
	      <div class="perfil-usuario-header">
		      <div class="perfil-usuario-avatar">
            <?php echo "<img src='imagenes/$foto_usuario ?>'>"; ?>
			      <button type="button" class="boton-avatar">
              <i class="icon-image"></i>
            </button>
          </div>
        </div>
	    </section>

      <center>
      <div class="informacion"><br>
        <table class="tabla-3"><br>
          <thead>
            <tr>
              <th class="text-left">Informacion Restaurante</th>
              <th class="text-left">Contactos</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td class="text-left1"><b>Nombre:</b><br><h5><?php echo $nomusuario; ?></h5></td>
              <td class="text-left1"><b>Telefono:</b><br><h5><?php echo $telefono_usuario; ?></h5></td>
            </tr>
            <tr>
              <!-- <td class="text-left1"><b>Localidad: </b><br><h5>Chapinero.</h5></td> -->
              
            </tr>
            <tr>
              <td class="text-left1"><b>Direccion:</b><br><h5><?php echo $direccion_usuario; ?></h5></td>
              <td class="text-left1"><b>Correo: </b><br><h5><?php echo $correo_usuario; ?></h5></td>	
            </tr>
            <!-- <tr>
              <td class="text-left1"><b>Categoria:</b><br><h5>Vegetariana.</h5></td>
            </tr> -->
          </tbody>
        </table>
      </div><br>
      </center>
	  </main>

    <?php
      if(isset($_GET['editar'])){
        include_once 'modificar_usuarios.php';
      }

			if(isset($_POST['actualizar_datos'])){
        $actu_nombre_usuario  = $_POST['nombre'];
        $actu_direccion 		  = $_POST['direccion'];
        $actu_telefono 		    = $_POST['telefono'];
        $actualizar_foto      = $_FILES['cambio_foto']['name'];

        $carpeta = "imagenes/";
        opendir($carpeta);
        $destino = $carpeta.$_FILES['cambio_foto']['name'];

        copy($_FILES['cambio_foto']['tmp_name'],$destino);
        $nombre = $_FILES['cambio_foto']['name'];
        $verificar_foto = mysqli_query($conexion,"SELECT * from usuarios Where foto_usuario = '$nombre'");
        $nuevoNameFoto       = $_FILES['cambio_foto']['name'];

        if(mysqli_num_rows($verificar_foto) > 0){
          $filename    = $_FILES['cambio_foto']['name'];
          $sourceFoto  = $_FILES['cambio_foto']['tmp_name'];

          date_default_timezone_set("America/Bogota");
          setlocale(LC_ALL,"es_ES");
          $fecha_imagen   = date("d/m/Y h:i A");

          $logitudPass    = 10;
          $newNameFoto    = substr( md5(microtime()), 1, $logitudPass);

          $explode        = explode('.', $filename);
          $extension_foto = array_pop($explode);
          $actualizar_foto  = $newNameFoto.'.'.$extension_foto;

          $dirLocal = "imagenes";
          
          if (!file_exists($dirLocal)) {
            mkdir($dirLocal, 0777, true);
          }

          $miDir         = opendir($dirLocal);
          $imagenCliente = $dirLocal.'/'.$actualizar_foto;

          if(move_uploaded_file($sourceFoto, $imagenCliente)){
            echo $imagenCliente;
          }
        }

				$update = "UPDATE usuarios SET nombre_usuario = '$actu_nombre_usuario',direccion_usuario = '$actu_direccion',foto_usuario = '$actualizar_foto',telefono_usuario = '$actu_telefono' WHERE id_usuarios = '$id_usuario'";
				$ejecutar=mysqli_query($conexion,$update);

				if ($ejecutar){
					echo "<script>
									alert ('usuario editado con exito');
									window.location.href ='cuenta_proveedores.php';
								</script> ";
          $_SESSION['nombre_usuario'] 	= $actu_nombre_usuario;
          $_SESSION['direccion_usuario']= $actu_direccion;
          $_SESSION['telefono_usuario'] = $actu_telefono;
          $_SESSION['foto_usuario'] = $actualizar_foto;
				}
				else{
					echo "<script>
									alert ('no se pudo editar');
								</script>";
				}
			}
		?>

    <script src="js/barra.js"></script>
	</body>		
</html>