<?php 
  $conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
	$observar         = "SELECT * FROM usuarios where id_rol = 3";
  $buscar           = "SELECT * FROM usuarios where id_rol = 2";
  $preregistros     = "SELECT * FROM preregistro";
?>
<?php
if(isset($_POST['total_usuarios'])){
  if((isset($_POST['buscar'])) or (isset($_POST['busqueda']))){
    $nombre = $_POST["busqueda"];
    $observar = "SELECT * FROM usuarios where nombre_usuario LIKE '%$nombre%' and id_rol = 3";
  }
?>
<section class="modal-container" id="modal_container">    
  <div class="modal">
    <center><div class="cuadro-titulo1"><h1>Usuarios registrados</h1></div></center><br>
        
    <?php

      $ejecutar=mysqli_query($conexion,$observar);
      if(mysqli_num_rows($ejecutar) > 0){
    ?>
          
		<div class="modifcar-productos">
			<table class="tabla-2" border="1" cellspacing="3">
				<thead>
					<tr>
					  <th class="lista-nombre"> perfil      </th>
						<th class="lista-nombre"> Nombres </th>
						<th class="lista-imagen"> Apellidos      </th>
						<th class="lista-precio"> Direccion      </th>
						<th class="lista-precio"> Numero telefonico     </th>
						<th class="lista-nombre">Correo electronico    </th>
            <th class="lista-nombre">Eliminar</th>
					</tr>
				</thead>		
			  <tbody>

          <?php
            while ($filas=mysqli_fetch_array($ejecutar)) {
              $id_cliente         = $filas['id_usuarios'];
              $foto_usuario       = $filas['foto_usuario'];
              $nombre_usuario 	  = $filas['nombre_usuario'];
              $apellido_usuario   = $filas['apellido_usuario'];
              $direccion_usuario 	= $filas['direccion_usuario'];
              $telefono_usuario 	= $filas['telefono_usuario'];
              $correo_usuario 		= $filas['correo_usuario'];
          ?>

          <tr>
            <td><?php echo "<img src = 'imagenes/$foto_usuario'>"; ?></td>
            <td class="color-p"><?php echo $nombre_usuario;?></td>
            <td class="color-p"><?php echo $apellido_usuario;?></td>
            <td class="color-p"><?php echo $direccion_usuario;?></td>
            <td class="color-p"><?php echo $telefono_usuario;?></td>
            <td class="color-p"><?php echo $correo_usuario;?></td>
            <td class="color-p"><button><a href="perfil-administrador.php? borrar_usuario= <?php echo $id_cliente; ?>">Borrar</a></button></td>
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

    <div class="modifcar-productos">
      <table class="tabla-2">
        <tr><td class="sin-conte">NO SE ENCONTRO NIGUN USUARIO</td></tr>
      </table>
    </div>

    <?php
      }
    ?>

    <form action="#" method="post" class="buscar-productos">
      <input  type="text"   name="busqueda" placeholder="Ingrese busqueda" class="busqueda">
      <input  type="submit" name="buscar"   value="Buscar">
      <button type="button" class="boton2"><a href="perfil-administrador.php">Actualizar</a></button>
    </form>
  </div>
</section>

<?php
}
if(isset($_POST['total_restaurantes'])){
?>

<section class="modal-container" id="modal_container2">      
  <div class="modal">
    <center><div class="cuadro-titulo1"><h1>Restaurantes registrados</h1></div></center><br>
			
    <?php
      if(isset($_POST['buscar1'])){
        $nombre = $_POST["busqueda1"];
        $buscar = "SELECT * FROM usuarios where nombre_usuario LIKE '%$nombre%' and id_rol = 2";
      }
      $restaurantes = mysqli_query($conexion,$buscar);
      if(mysqli_num_rows($restaurantes) > 0){

    ?>

		<div class="modifcar-productos">
  		<table class="tabla-2" border="1" cellspacing="3">
				<thead>
  				<tr>
            <th class="lista-nombre">Logo restaurante</th>
						<th class="lista-nombre"> Nombre del negocio     </th>
						<th class="lista-nombre"> Direccion del negocio </th>
						<th class="lista-imagen">  Telefono del negocio     </th>
						<th class="lista-precio"> Correo electronico    </th>
            <th class="lista-nombre">Eliminar</th>
					</tr>
				</thead>		
				<tbody>

          <?php
            while ($fila = mysqli_fetch_array($restaurantes)) {
              $id_restaurante         = $fila['id_usuarios'];
              $foto_restaurante       = $fila['foto_usuario'];
              $nombre_restaurante 	  = $fila['nombre_usuario'];
              $direccion_restaurante 	= $fila['direccion_usuario'];
              $telefono_restaurarnte 	= $fila['telefono_usuario'];
              $correo_restaurante 		= $fila['correo_usuario'];
          ?>

          <tr>
            <td><?php echo "<img src = 'imagenes/$foto_restaurante'>"; ?></td>
            <td class="color-p"><?php echo $nombre_restaurante;?></td>
            <td class="color-p"><?php echo $direccion_restaurante;?></td>
            <td class="color-p"><?php echo $telefono_restaurarnte;?></td>
            <td class="color-p"><?php echo $correo_restaurante;?></td>
            <td class="color-p"><button><a href="perfil-administrador.php? borrar_restaurante= <?php echo $id_restaurante; ?>">Borrar</a></td>
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

      <div class="modifcar-productos">
        <table class="tabla-2">
          <tr><td class="sin-conte">NO SE ENCONTRO NIGUN USUARIO</td></tr>
        </table>
      </div>

      <?php
        }
      ?>

      <form action="#" method="post" class="buscar-productos">
        <input  type="text"   name="busqueda1" placeholder="Ingrese busqueda" class="busqueda">
        <input  type="submit" name="buscar1"   value="Buscar">
        <button type="button" class="boton2"><a href="administracion_productos.php">Actualizar</a></button>
      </form>
    </div>
  </section>

  <?php
  }
  ?>


<?php
  if(isset($_POST['restaurantes_preregistrados'])){
?>

<section class="modal-container" id="modal_container2">      
  <div class="modal">
    <center><div class="cuadro-titulo1"><h1>Restaurantes <br>Pre-registrados</h1></div></center><br>
			
    <?php
      if(isset($_POST['buscar1'])){
        $nombre = $_POST["busqueda1"];
        $buscar = "SELECT * FROM preregistro where nombre_restaurante LIKE '%$nombre%'";
      }
      $restaurantes_preregistrados = mysqli_query($conexion,$preregistros);
      if(mysqli_num_rows($restaurantes_preregistrados) > 0){

    ?>

		<div class="modifcar-productos">
  		<table class="tabla-2" border="1" cellspacing="3">
				<thead>
  				<tr>
            <th class="lista-nombre">Logo restaurante	     </th>
						<th class="lista-nombre">Nombre del negocio    </th>
						<th class="lista-nombre">Direccion del negocio </th>
						<th class="lista-imagen">Telefono del negocio  </th>
						<th class="lista-precio">Correo electronico    </th>
            <th class="lista-nombre">Aceptar              </th>
					</tr>
				</thead>		
				<tbody>

          <?php
            while ($fila = mysqli_fetch_array($restaurantes_preregistrados)) {
              $id_registro            = $fila['id_registro'];
              $id_rol                 = $fila['id_rol'];
              $nombre_restaurante     = $fila['nombre_restaurante'];
              $clave_restaurante 	    = $fila['clave_restaurante'];
              $direccion_restaurante 	= $fila['direccion_restaurante'];
              $correo_restaurante 	  = $fila['correo_restaurante'];
              $logo_restaurante 		  = $fila['logo_restaurante'];
              $telefono_restaurante 	= $fila['telefono_restaurante'];
              $logo_restaurante 	= $fila['logo_restaurante'];
          ?>

          <tr>
            <td><?php echo "<img src = 'imagenes/$logo_restaurante'>"; ?></td>
            <td class="color-p"><?php echo $nombre_restaurante;?></td>
            <td class="color-p"><?php echo $direccion_restaurante;?></td>
            <td class="color-p"><?php echo $telefono_restaurante;?></td>
            <td class="color-p"><?php echo $correo_restaurante;?></td>
            <td class="color-p"><button><a href="perfil-administrador.php? agregar_restaurante = <?php echo $nombre_restaurante; ?>">Agregar</a></td>
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

      <div class="modifcar-productos">
        <table class="tabla-2">
          <tr><td class="sin-conte">NO SE ENCONTRO NIGUN USUARIO</td></tr>
        </table>
      </div>

      <?php
        }
      ?>

      <form action="#" method="post" class="buscar-productos">
        <input  type="text"   name="busqueda1" placeholder="Ingrese busqueda" class="busqueda">
        <input  type="submit" name="buscar1"   value="Buscar">
        <button type="button" class="boton2"><a href="administracion_productos.php">Actualizar</a></button>
      </form>
    </div>
  </section>

  <?php
  }
  ?>
    
  <?php 
    if(isset($_GET['borrar_restaurante'])){
      $borrar_restaurante				= $_GET['borrar_restaurante'];
      $busqueda 				= "SELECT * FROM usuarios WHERE id_usuarios = '$borrar_restaurante'";
      $inspeccionar					= mysqli_query($conexion,$busqueda);

      if($inspeccionar){
  ?>
    
  <div class="borrar-articulos">
    <form action="#" method="post">
      <p>Desea eliminar el restaurante?</p>
      <input type="submit" name="eliminar_restaurante" value="Borrar" class="boton-enviar">
    </form>
  </div>

  <?php
      }
    }
  ?>

  <?php
	  if(isset($_POST['eliminar_restaurante'])){      
		  $borrar = "DELETE FROM usuarios WHERE id_usuarios = '$borrar_restaurante'";
			$ejecutar=mysqli_query($conexion,$borrar);

			if($ejecutar){
				echo "<script>
							  alert ('restaurante eliminado con exito');
								window.location.href ='perfil-administrador.php';
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
  <?php
		if(isset($_POST['delete'])){
      $borrar = mysqli_query($conexion,"DELETE FROM carrito WHERE id_usuarios = '$Sid_usuario'");
      $borrar = mysqli_query($conexion,"DELETE FROM usuarios WHERE correo_usuario = '$Scorreo_usuario'");

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
  <?php
    if(isset($_GET['agregar_restaurante'])){
      $nombre_restaurante = $_GET['agregar_restaurante'];
      $consultar_restaurante 	= mysqli_query($conexion,"SELECT * FROM usuarios WHERE nombre_usuario like '%$nombre_restaurante%'");

      if(mysqli_num_rows($consultar_restaurante) > 0){
        echo "<script> alert('El nombre de este restaurante ya se encuentra registro en el sistema');</script>";
        echo "<script> window.location.href ='perfil_administrador.php';</script>";
      }
      else{
        $consultar_info = mysqli_query($conexion,"SELECT * FROM preregistro WHERE nombre_usuario like '%$nombre_restaurante%'");
        $lineas			    = mysqli_fetch_array($consultar_info);
        $actu_id_rol                = $lineas['id_rol'];
        $actu_nombre_restaurante    = $lineas['nombre_restaurante'];
        $actu_clave_restaurante 	  = $lineas['clave_restaurante'];
        $actu_direccion_restaurante = $lineas['direccion_restaurante'];
        $actu_correo_restaurante 	  = $lineas['correo_restaurante'];
        $actu_logo_restaurante 		  = $lineas['logo_restaurante'];
        $actu_telefono_restaurante 	= $lineas['telefono_restaurante'];
        $actu_logo_restaurante 	    = $lineas['logo_restaurante'];


        $agregar = mysqli_query($conexion,"INSERT INTO usuarios (id_rol,nombre_usuario,clave_usuario,direccion_usuario,correo_usuario,foto_usuario,telefono_usuario) values ('$actu_id_rol','$actu_nombre_restaurante','$actu_clave_restaurante','$actu_direccion_restaurante','$actu_correo_restaurante','$actu_logo_restaurante','$actu_telefono_restaurante')");

        if($agregar){
          echo "<script>
                  alert ('usuario agregado con exito');
                  window.location.href ='perfil-administrador.php';
                </script> ";
        }
        else{
          echo "<script>
                  alert ('no se pudo agregar');
                </script>";
        }
      }
    }
  ?>