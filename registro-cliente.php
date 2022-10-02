<!-- <!DOCTYPE html> -->
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="vi/ewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/micss.css">
		<title>Registro clientes</title>
  </head>

  <body background="imagenes/fondo-web.png" class="img">
    <section>
      <header>
        <div class="logo"> <img src="imagenes/logo2.png" alt="" width="100%"> </div>
      </header>

      <div class="titular-registro">
        <h1>Formulario Registro Usuarios</h1>
      </div>

      <form class="formulario-registro"  action="#" method="post">
        <div><p> Nombres        </p><input type="text"     name="nombre_usuario"    placeholder="Ingrese Nombres"   pattern="[a-Z]" minlength="3" required class="nombre" ></div>
        <div><p> Apellidos      </p><input type="text"     name="apellido_usuario"  placeholder="Ingrese Apellidos" pattern="[a-Z]" minlength="3" class="apellido"></div>
        <p> Direccion           </p><input type="text"     name="direccion_usuario" placeholder="Ingrese Direccion"                 minlength="8" required>
        <p> Numero de telefono  </p><input type="tel"      name="telefono_usuario"  class="botones-registro"    placeholder="Ingrese telefono"            minlength="8" maxlength="10" required id="age" onkeypress="return valideKey(event);">
        <p> Correo electronico  </p><input type="email"    name="correo_usuario"    placeholder="Ingrese Correo electronico"        minlength="10"  pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" title="Debe incluir una extension de correo" required>
        <p> Contraseña          </p><input type="password" name="clave_usuario"     placeholder="Ingrese Contrasena"                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}" title="(Debe contener al menos un número, una letra mayúscula y una minúscula, y debe tener minimo 8 maximo 14 caracteres)" required>
        <p> Confirmacion de contraseña        </p><input type="password" name="confirma_clave_usuario"     placeholder="Vuelva a ingresar su contrasena"                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}" title="(Debe contener al menos un número, una letra mayúscula y una minúscula, y debe tener minimo 8 maximo 14 caracteres)" required>
        <!-- <p>Estoy de acuerdo con <a href="#">Terminos y condiciones</a></p> -->
        <input type="submit" name="insertar" value="Registrar" class="iniciosesion">
        <button class="reg-provee"><a href="registro-proveedor.php">Si desea subir sus productos, registrese desde aqui</a></button>
        <p><a href="iniciosesion-cliente.php">Ya tengo cuenta</a></p>
      </form>

      <?php
        include_once 'conexion.php';
        $conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');

        if(isset($_POST['insertar'])){
          $id_rol = '3';
          $nombre_usuario = $_POST['nombre_usuario'];
          $apellido_usuario = $_POST['apellido_usuario'];
          $direccion_usuario = $_POST['direccion_usuario'];
          $correo_usuario = $_POST['correo_usuario'];
          $clave_usuario = $_POST['clave_usuario'];
          $confirmacion = $_POST['confirma_clave_usuario'];

          if($clave_usuario == $confirmacion){
            $clave_usuario = password_hash($clave_usuario, PASSWORD_DEFAULT);  
            $foto_usuario = 'invitado.png';
            $telefono_usuario = $_POST['telefono_usuario'];
            $insertar = "INSERT INTO usuarios (id_rol,nombre_usuario,clave_usuario,direccion_usuario,correo_usuario,foto_usuario,apellido_usuario,telefono_usuario) values ('$id_rol','$nombre_usuario', '$clave_usuario','$direccion_usuario','$correo_usuario','$foto_usuario','$apellido_usuario','$telefono_usuario')";

            $verificar_correo = mysqli_query($conexion,"SELECT * from usuarios Where correo_usuario = '$correo_usuario'");

            if(mysqli_num_rows($verificar_correo) > 0){
              echo "<script>
                      alert ('Este correo ya esta registrado');
                      window.location.href ='registro-cliente.php';
                    </script> ";
              exit();
            }
            
            $ejecutar = mysqli_query($conexion,$insertar);

            if ($ejecutar){
              echo "<script>
                      alert('Se ha registrado correctamente');
                      window.location.href ='iniciosesion-cliente.php';
                    </script>";
            }
          }
          else{
            echo "<div class='mensaje'>¡las contraseñas no coinciden!</div>"; 
          }
        }
      ?>

    </section>
    <script type="text/javascript">
      function valideKey(evt){
        
        // code is the decimal ASCII representation of the pressed key.
        var code = (evt.which) ? evt.which : evt.keyCode;
        
        if(code==8) { // backspace.
          return true;
        } else if(code>=48 && code<=57) { // is a number.
          return true;
        } else{ // other keys.
          return false;
        }
      }
		</script>
  </body>
</html>