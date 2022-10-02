<!-- <!DOCTYPE html> -->
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="css/micss.css">
    <title>Registro Restaurante</title>
  </head>

	<body background="imagenes/fondo-web.png" class="img">
    <section>
      <header>
        <div class="logo"> <img src="imagenes/logo2.png" alt="" width="100%"> </div>
      </header>

      <div class="titular-registro">
        <h1>Formulario Registro Restaurante</h1>
      </div>

      <form class="formulario-registro" action="#" method="post" enctype="multipart/form-data"> 
        <p>Nombre del negocio             </p><input name="nombre_proveedor"        type="text"     class="botones-registro"    placeholder="Ingrese nombre"              minlength="3" required>
        <p>Direccion del negocio          </p><input name="direccion_proveedor"     type="text"     class="botones-registro"    placeholder="Ingrese direccion"           minlength="7" required>
        <p>Numero de telefono             </p><input name="telefono_proveedor"      type="tel"      class="botones-registro"    placeholder="Ingrese telefono"            minlength="8" maxlength="10" required id="age" onkeypress="return valideKey(event);">
        <p>Correo electronico             </p><input name="correo_proveedor"        type="email"    class="botones-registro"    placeholder="Ingrese Correo electronico"  minlength="10"  pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" title="Debe incluir una extension de correo" required>
        <p>Contraseña                     </p><input name="clave_proveedor"         type="password" class="botones-registro"    placeholder="Ingrese contraseña"          minlength="8" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}" title="(Debe contener al menos un número, una letra mayúscula y una minúscula, y debe tener minimo 8 maximo 14 caracteres)">
        <p>Confirmacion de contraseña     </p><input name="confirma_clave_usuario"  type="password" placeholder="Vuelva a ingresar su contrasena"                         required>
        <p>Suba el logo de su restaurante </p><input type="file" name="foto_proveedor" required accept="image/*"><br><br>
        <br>
        <input type="submit" name="datos_proveedor" value="Registrar" class="iniciosesion">
        <p><a href="iniciosesion-cliente.php">¿Ya tiene cuenta de restaurante?</a></p>
      </form>
    </section>

    <?php
      include_once 'conexion.php';
      $conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
      
      if(isset($_POST['datos_proveedor'])){
        $carpeta = "imagenes/";
        opendir($carpeta);
        $destino = $carpeta.$_FILES['foto_proveedor']['name'];
              
        copy($_FILES['foto_proveedor']['tmp_name'],$destino);
        $nombre = $_FILES['foto_proveedor']['name'];
        $verificar_foto = mysqli_query($conexion,"SELECT * from usuarios Where foto_usuario like '%$nombre%'");

        if(mysqli_num_rows($verificar_foto) > 0){
          $filename    = $_FILES['foto_proveedor']['name'];
          $sourceFoto  = $_FILES['foto_proveedor']['tmp_name'];

          date_default_timezone_set("America/Bogota");
          setlocale(LC_ALL,"es_ES");
          $fecha_imagen   = date("d/m/Y h:i A");

          $logitudPass    = 10;
          $newNameFoto    = substr( md5(microtime()), 1, $logitudPass);

          $explode        = explode('.', $filename);
          $extension_foto = array_pop($explode);
          $nombre  = $newNameFoto.'.'.$extension_foto;
          $dirLocal = "imagenes";

          if (!file_exists($dirLocal)) {
              mkdir($dirLocal, 0777, true);
          }

          $miDir         = opendir($dirLocal);
          $imagenCliente = $dirLocal.'/'.$nombre;

          if(move_uploaded_file($sourceFoto, $imagenCliente)){
            echo $imagenCliente;
            // echo "<script> alert('se pudo'); </script>"; 
          }
        }

        $id_rol              = '2';
        $clave_proveedor     = $_POST['clave_proveedor'];
        $clave_proveedor_encrip     = password_hash($clave_proveedor, PASSWORD_DEFAULT);  
        $confirmacion        = $_POST['confirma_clave_usuario'];
        $nombre_proveedor    = $_POST['nombre_proveedor'];
        $correo_proveedor    = $_POST['correo_proveedor'];
        $telefono_proveedor  = $_POST['telefono_proveedor'];
        $direccion_proveedor = $_POST['direccion_proveedor'];
  
        $insertar            = "INSERT INTO preregistro (id_rol,nombre_restaurante,clave_restaurante,direccion_restaurante,correo_restaurante,logo_restaurante,telefono_restaurante) values ('$id_rol','$nombre_proveedor','$clave_proveedor_encrip','$direccion_proveedor','$correo_proveedor','$nombre','$telefono_proveedor')";

        if($clave_proveedor == $confirmacion){
          $verificar_correo = mysqli_query($conexion,"SELECT * from usuarios Where correo_usuario = '$correo_proveedor'");

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
                    alert ('usuario preregistrado correctamente, espere a que un administrador verifique su informacion y active su cuenta');
                    window.location.href ='index.php';
                  </script> ";
          }
        }
        else{
          echo "<div class='mensaje'>¡las contraseñas no coinciden!</div>"; 
        }
      }
    ?>

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
