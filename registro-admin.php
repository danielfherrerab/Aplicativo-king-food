<!-- <!DOCTYPE html> -->
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="css/micss.css">
    <title>Registro Proveedores</title>
  </head>

	<body background="imagenes/fondo-web.png" class="img">
    <section>
      <header>
        <div class="logo">
          <img src="imagenes/logo2.png" alt="" width="100%">
        </div>
      </header>
      <div class="titular-registro">
        <h1>Formulario Registro Proveedores</h1>
      </div>

      <form class="formulario-registro" action="#" method="post" enctype="multipart/form-data"> 
        <p>Nombre de usuario   </p><input name="nombre_proveedor"    type="text"     class="botones-registro"  placeholder="Ingrese nombre"      minlength="3" required>
        <p>Correo electronico   </p><input name="correo_proveedor"    type="email"    class="botones-registro"  placeholder="Ingrese correo electronico"  minlength="7" required>
        <p>Contraseña           </p><input name="clave_proveedor"     type="password" class="botones-registro"  placeholder="Ingrese contraseña"  minlength="8" required>

        <!-- <br><br>Categoria de comida que vendera
          <select class="botones-registro" name="Categoria" required>
            <option disabled>Elija alguna opcion</option>                                
            <option>Chatarra        </option>                              
            <option>Vegetariana     </option>
            <option>Asiatica        </option>
            <option>Tradicional     </option>                                      
          </select>             -->
        <br>
        <input type="submit" name="datos_proveedor" value="Registrar" class="iniciosesion">
        <p><a href="iniciosesion-cliente.php">¿Ya tengo cuenta?</a></p>
      </form>

    </section>

    <?php
      include_once 'conexion.php';
      $conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
      
      if(isset($_POST['datos_proveedor'])){
        $id_rol = '1';
        $nombre_proveedor = $_POST['nombre_proveedor'];
        $correo_proveedor = $_POST['correo_proveedor'];
        $clave_proveedor = $_POST['clave_proveedor'];
        $clave_proveedor = password_hash($clave_proveedor, PASSWORD_DEFAULT);  
        $insertar = "INSERT INTO usuarios (id_rol,nombre_usuario,clave_usuario,correo_usuario) 
        values ('$id_rol','$nombre_proveedor','$clave_proveedor','$correo_proveedor')";

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
                  alert ('registrado correctamente');
                    
                </script> ";
        }
      }
    ?>
  </body>
</html>