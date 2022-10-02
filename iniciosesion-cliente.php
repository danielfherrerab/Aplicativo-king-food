<!-- <!DOCTYPE html> -->
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="vi/ewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/micss.css">
    <title>Inicio de Sesion</title>
  </head>

  <body background="imagenes/fondo-web.png" class="img">
    <section>
      <header>
        <div class="logo"><img src="imagenes/logo2.png" alt="" width="100%"></div>
      </header>

      <div class="titular-registro">
        <h1>Inicio de sesion</h1>
      </div>

      <form action="#" method="post" class="formulario-registro">
			<a href="registro-cliente.php"><p class="index">¿Desea volver a ver los productos?</p></a>
        <p>Correo electronico</p><input name="correo_usuario" placeholder="Ingrese correo electronico" type="email" maxlength="40" required>
        <p>Contraseña        </p><input name="clave_usuario"  placeholder="Ingrese clave" type="password" minlength="1" required>
        <input type="submit" name="IniciarSesion" value="INICIO SESION" class="iniciosesion">
        <!-- <p><a href="recuperar-clave.php">Olvide mi contraseña</a></p> -->
        <p><a href="registro-cliente.php">Crear usuario</a></p>
				<button class="reg-provee"><a href="registro-proveedor.php">Si desea subir sus productos, registrese desde aqui</a></button>
      </form>
    </section>

    <?php
			include_once 'conexion.php';
			$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
			session_start();

			if (isset($_POST['cerrar_sesion'])){
				session_unset();
				unset($_SESSION["correo_usuario"]);
				session_destroy();//header('Location:../login.php');
			}

			if (isset($_SESSION['id_rol'])){
				switch ($_SESSION['id_rol']){
					case 1:
						header('Location: principal-admin.php');		break;
					case 2:
						header('Location: principal-proveedor.php');break;
					case 3:
						header('Location: principal.php');					break;
					default:
						echo "no estoy en nada";										break;
				}
			}

			if (isset($_POST['correo_usuario']) && isset($_POST['clave_usuario'])) {
				$username = mysqli_real_escape_string($conexion, $_POST["correo_usuario"]);  
				$password = mysqli_real_escape_string($conexion, $_POST["clave_usuario"]);  
				$query = "SELECT * FROM usuarios WHERE correo_usuario = '$username'";  
				$result = mysqli_query($conexion, $query); 

				if(mysqli_num_rows($result) >= 1)  
				{  
					while($row = mysqli_fetch_array($result))  {  
						if(password_verify($password, $row["clave_usuario"]))  {  
							if (isset($_POST['correo_usuario']) && isset($_POST['clave_usuario'])) {
								$username = $_POST['correo_usuario'];
								$password = $_POST['clave_usuario'];
								$db 			= new Database();
								$query 		= $db->connect()->prepare("SELECT *FROM usuarios WHERE correo_usuario = :correo_usuario");
								$query->execute(['correo_usuario' =>$username]);
								$arreglofila = $query->fetch(PDO::FETCH_NUM);
								
								if ($arreglofila == true) {
									$id_rol 						= $arreglofila[1];
									$_SESSION['id_rol'] = $id_rol;

									switch($id_rol) {
										case 1:
											header('Location: principal-admin.php');		break;
										case 2:
											header('Location: principal-proveedor.php');break;
										case 3:
											header('Location: principal.php');					break;
										default:
											echo "no estoy en nada";										break;
									}

									$id_usuarios 									= $arreglofila[0];
									$_SESSION['id_usuarios'] 			= $id_usuarios;
									$nombre_usuario 							= $arreglofila[2];
									$_SESSION['nombre_usuario'] 	= $nombre_usuario;
									$direccion_usuario 						= $arreglofila[4];
									$_SESSION['direccion_usuario']= $direccion_usuario;
									$correo_usuario 							= $arreglofila[5];
									$_SESSION['correo_usuario'] 	= $correo_usuario;
									$foto_usuario 								= $arreglofila[6];
									$_SESSION['foto_usuario'] 		= $foto_usuario;
									$apellido_usuario 						= $arreglofila[7];
									$_SESSION['apellido_usuario'] = $apellido_usuario;
									$telefono_usuario 						= $arreglofila[8];
									$_SESSION['telefono_usuario'] = $telefono_usuario;
								}
								else{
									echo "<div class='mensaje'>El usuario puede que no exista o el correo electronico o la contraseña es invalida!</div>";
								}
							}
						}  
						else  {  
							echo "<div class='mensaje'>El usuario puede que no exista o el correo electronico o la contraseña es invalida!</div>";
						}  
					}  
				}  
				else  
				{  
					echo "<div class='mensaje'>El usuario puede que no exista o el correo electronico o la contraseña es invalida!</div>"; 
				} 
			}
		?>

	</body>
</html>