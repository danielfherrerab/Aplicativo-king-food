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
			if($_SESSION['id_rol'] !=1){
				header('location: iniciosesion-cliente.php');
			}
		}
    $Sid_usuario 	    = $_SESSION['id_usuarios'];
		$Sfoto_usuario 		= $_SESSION['foto_usuario'];
		$Scorreo_usuario 	= $_SESSION['correo_usuario'];
		$Snomusuario 			= $_SESSION['nombre_usuario'];
    $Sdireccion_usuario = $_SESSION['direccion_usuario'];
    $Stelefono_usuario = $_SESSION['telefono_usuario'];
	?>

  <body background="imagenes/fondo-web.png" class="img">
    <nav class="barra-perfil">
      <ul class="lista-mayor">
        <li class="apartado"><a href="principal-admin.php"><img src="imagenes/logo2.png" alt="logotipo" class="logo-perfil"></a></li>
        <li class="apartado"><button class="button type2"><a href="principal-admin.php">Inicio</a></button></li>
        <li class="apartado"><form action="#" method="post"><button class="button type3" id="open"  name="total_usuarios">Usuarios registrados</button></form></li>
        <li class="apartado"><form action="#" method="post"><button class="button type3" id="open2" name="total_restaurantes">Restaurantes registrados</button></form></li>
        <li class="apartado"><form action="#" method="post"><button class="button type3" id="open2" name="restaurantes_preregistrados">Pre-registros</button></form></li>
        <li class="apartado"><button class="button type2"><form action="iniciosesion-cliente.php" method="POST"><input type="submit" name="cerrar_sesion" value="Cerrar sesion"></form></button></li>
        <li class="apartado"><form action="#" method="post"><a aria-label='Thanks' class='h-button centered' data-text='Eliminar cuenta' href='#'><button name="delete" class="delete"><span>¿SEGURO?</span></button></a></form></li>
      </ul>
      <div class="boton-perfil"><center>||</center></div>
    </nav>
    
    <section class="seccion-perfil-usuario">
				<div class="perfil-usuario-header">
					<div class="perfil-usuario-avatar">
						<?php echo "<img src='imagenes/$Sfoto_usuario ?>'>";?>

					</div>
				</div>
			</section>

			<center><div class="informacion"><br><br><br>
				<table class="tabla-3" >
					<thead>
						<tr>
							<th class="text-left">Informacion administrador</th>
							<th class="text-left">Contactos</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-left1"><b>Nombre:</b><br><h5><?php echo $Snomusuario; ?></h5></td>
							<td class="text-left1"><b>Telefono:</b><br><h5><?php echo $Stelefono_usuario; ?></h5></td>
						</tr>
						<tr>
							<td class="text-left1"><b>Direccion:</b><br><h5><?php echo $Sdireccion_usuario; ?></h5></td>
							<td class="text-left1"><b>Correo: </b><br><h5><?php echo $Scorreo_usuario; ?></h5></td>	
						</tr>
					</tbody>
				</table>
			</center></div><br>

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
                  <th class="lista-nombre">Perfil             </th>
                  <th class="lista-nombre">Nombres            </th>
                  <th class="lista-imagen">Apellidos          </th>
                  <th class="lista-precio">Direccion          </th>
                  <th class="lista-precio">Numero telefonico  </th>
                  <th class="lista-nombre">Correo electronico </th>
                  <th class="lista-nombre">Eliminar           </th>
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
                  <td class="color-p"><?php if($apellido_usuario == ''){ echo "<u>no tiene</u>"; }else{ echo $apellido_usuario; }?></td>
                  <td class="color-p"><?php echo $direccion_usuario;?></td>
                  <td class="color-p"><?php echo $telefono_usuario;?></td>
                  <td class="color-p"><?php echo $correo_usuario;?></td>
                  <td class="color-p"><button><a href="perfil-administrador.php? borrar_usuario=<?php echo $id_cliente; ?>">Borrar</a></button></td>
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
                  <th class="lista-nombre">Logo</th>
                  <th class="lista-nombre">Negocio     </th>
                  <th class="lista-nombre">Direccion</th>
                  <th class="lista-nombre">Telefono     </th>
                  <th class="lista-imagen">Correo electronico </th>
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
                  <td class="color-p"><button><a href="perfil-administrador.php?agregar_restaurante=<?php echo $nombre_restaurante; ?>">Agregar</a></td>
                </tr>

                <?php
                  }
                ?>

                </tbody>
              </table>
            </div>
            <form action="#" method="post" class="buscar-productos">
              <input  type="text"   name="busqueda1" placeholder="Ingrese busqueda" class="busqueda">
              <input  type="submit" name="buscar1"   value="Buscar">
              <button type="button" class="boton2"><a href="administracion_productos.php">Actualizar</a></button>
            </form>
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
          </div>
        </section>

        <?php
        }
        ?>
        
        <?php 
          if(isset($_GET['borrar_usuario'])){
            $borrar_cliente				= $_GET['borrar_usuario'];
            $busqueda 				    = "SELECT * FROM usuarios WHERE id_usuarios = '$borrar_cliente'";
            $inspeccionar					= mysqli_query($conexion,$busqueda);

            if($inspeccionar){
        ?>
          
        <div class="borrar-articulos">
          <form action="#" method="post">
            <p>Desea eliminar el usuario?</p>
            <input type="submit" name="eliminar_usuario" value="Borrar" class="boton-enviar">
          </form>
        </div>

        <?php
            }
          }
        ?>

        <?php
          if(isset($_POST['eliminar_usuario'])){      
            $borrar_carrito = mysqli_query($conexion,"DELETE FROM carrito WHERE id_usuarios = '$borrar_cliente'");
            $borrar_pedidos = mysqli_query($conexion,"DELETE FROM pedidos WHERE id_usuario = '$borrar_cliente'");
            $borrar = "DELETE FROM usuarios WHERE id_usuarios = '$borrar_cliente'";
            $ejecutar=mysqli_query($conexion,$borrar);

            if($ejecutar){
              echo "<script>
                      alert ('Usuario eliminado con exito');
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
            $restaurante = $_GET['agregar_restaurante'];
            $consultar_restaurante 	= mysqli_query($conexion,"SELECT * FROM usuarios WHERE nombre_usuario like '%$restaurante%'");

            if(mysqli_num_rows($consultar_restaurante) > 0){
              echo "<script> alert('El nombre de este restaurante ya se encuentra registro en el sistema');</script>";
              echo "<script> window.location.href ='perfil-administrador.php';</script>";
            }
            else{
              $consultar_info = mysqli_query($conexion,"SELECT * FROM preregistro WHERE nombre_restaurante like '%$restaurante%'");
              while ($lineas = mysqli_fetch_array($consultar_info)) {
                $actu_id_rol                = $lineas['id_rol'];
                $actu_nombre_restaurante    = $lineas['nombre_restaurante'];
                $actu_clave_restaurante 	  = $lineas['clave_restaurante'];
                $actu_direccion_restaurante = $lineas['direccion_restaurante'];
                $actu_correo_restaurante 	  = $lineas['correo_restaurante'];
                $actu_logo_restaurante 		  = $lineas['logo_restaurante'];
                $actu_telefono_restaurante 	= $lineas['telefono_restaurante'];
                $actu_logo_restaurante 	    = $lineas['logo_restaurante'];
              }

              $agregar = mysqli_query($conexion,"INSERT INTO usuarios (id_rol,nombre_usuario,clave_usuario,direccion_usuario,correo_usuario,foto_usuario,telefono_usuario) values ('$actu_id_rol','$actu_nombre_restaurante','$actu_clave_restaurante','$actu_direccion_restaurante','$actu_correo_restaurante','$actu_logo_restaurante','$actu_telefono_restaurante')");
              $borrar_preregistro = mysqli_query($conexion,"DELETE FROM preregistro WHERE nombre_restaurante like '%$restaurante%'");
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

<style type="text/css">


.modal-container {/*Sombreado*/
  display: flex;
  background-color: rgba(48, 47, 47, 0.3);
  align-items: center;
  justify-content: center;
  position: fixed;
  pointer-events: none;
  top:0;
  left: 0;
  height: 100vh;
  width: 100vw;
  z-index: 9;
  pointer-events: auto;
  opacity: 1;
}



.show {
  pointer-events: auto;
  opacity: 1;
}
.show2 {
  pointer-events: auto;
  opacity: 1;
}

.modal {
  width: auto;
  height: auto;
  right: 0px;
  background-color: #24303c;
  margin: 0%;
  border-radius: 5px;
  position: relative;
  text-align: center;
  left: 0px;/*impide movimitnto*/
  padding: 2rem;
  top: 0%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  border-radius: 4px;
  font-family: 'calibri';
  min-height:450px;
  z-index: 9999999999;
}

.modal h4 {
  font-size: 21px;
  margin-bottom: 20px;
  color: #ffffff;
}

.modal h1 {
   margin: 0;
}
.modal p {
  opacity: 0.7;
  font-size: 18px;
  color: #FF6E6E;
}   

.controlsn {
  width: 100%;
  background: #566473;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 16px;
  border: 1px solid #e4475c;;
  font-family: 'calibri';
  font-size: 18px;
}
  .controls1 {
    width: 45%;
    background: #24303c;
    padding: 8px;
    border-radius: 5px;
    margin-bottom: 50px;
    border: 2px solid #e4475c;/*Color del border de los espacios*/
    font-family: 'arial';
    font-size: 15px;
    color: #e4475c;
    
}

.controls1:hover{
  color: #fff;
}

button a{
  color: white;
}

.cuadro-titulo1{
  width: 250px;
  padding: 5px;
  background-color: #000000;
  border-radius: 10px 10px 10px 10px;
  border-bottom: solid 2px #f57272;
  color: white;
  text-indent: 4px;
  
}

.modifcar-productos{
  background: #fc5f5f; 
  border-radius: 15px 15px 15px 0px;
  box-shadow: 7px 13px 37px #000;
  text-align: center;
  justify-content: center;
  transition: .5s ease-in-out;
  border: solid 2px #fc5f5f;
  background-color: rgb(255, 166, 166);
  width: auto;
  overflow-y:auto;
  overflow-x: hidden;
  max-height: 330px;
}

.tabla-2 {
  border-radius: 1px 15px 15px 0px;
  box-shadow: 7px 13px 37px #000;
  text-align: center;
  justify-content: center;
  transition: .5s ease-in-out;
  border: solid 2px #fc5f5f;
  background-color: #24303c;
  width: 100%;
  text-overflow: ellipsis;
  text-align: center;
}
.tabla-2 img{
	margin: 0 auto;
	height: 100px;
	width: 100%;
	display: flex;
	vertical-align: top;
}
.tabla-2 td{
	max-height: 10px;
  text-overflow: ellipsis;
}
.tabla-2 .lista-nombre{
	width: 20%;
  color: white;
  background: #ff4040;
}
.tabla-2 .lista-precio{
	width: 5%;
  text-align: center;
  color: white;
  background: #ff4040;
}
.tabla-2 th{
  padding: 10px;
}
.tabla-2 .lista-imagen{
	width: 10%;
  color: white;
  background: #ff4040;
  overflow:hidden;
  text-overflow: ellipsis;
}
.tabla-2 button{
  border: solid 2px #ff4040;
  background-color: rgb(255, 86, 86);
  padding: 5px;
  cursor: pointer;
  border-radius: 3px;
  width:auto;
  color:black;
}
.tabla-2 a{
  text-decoration:none;
}

.color-p{
  color: #000000;
  background-color: rgb(255, 255, 255);
}

.buscar-productos input[type="submit"]{
  margin-left:-5px;
  width: 80px;
  border-radius: 0px 0px 10px 0px;
}
.buscar-productos input{
  background: #24303c;
  padding: 2px;
  border-radius: 5px;
  margin-bottom: 13px;
  margin-left: -316px;
  border: 1px solid #FF6E6E;/*Color del border de los espacios*/
  font-family: 'Calibri';
  font-size: 18px;
  color:white;
  outline: none;
  display: inline-block;
  cursor: pointer;
}

.buscar-productos .busqueda {
  background: #ffffffe1;
  border-radius: 0px 0px 0px 10px;
  border: solid 2px #fc5f5f;
  font-family: 'Calibri';
  font-size: 18px;
  color:black;
}

.busqueda{
  width: 160px;
  height: 28px;
  font-size: 18px;
  color: #000;
  outline: none;
  border: 1px solid silver;
  border-radius: 0px 0px 5px 5px;
  transition: all 0.6s ease;
}

.boton2{
  background-color: #da473c;
  text-align: center;
  margin-top: -28px;
  font-size:16px;
  width: 190px;
  padding: 2px;
  border-radius: 0px 0px 10px 10px;
  border: 1px solid #FF6E6E;/*Color del border de los espacios*/
  font-family: 'Calibri';
  font-size: 18px;
  color:white;
  outline: none;
  display: inline-block;
}
.boton2 a{
  color:white;
}
.delete{
  width:100%;
  height:100%;
  background:none;
  padding:10px;
  color:rgb(255, 104, 104);
  border:none;
  font-weight:bold;
}
		</style>
    <script src="js/barra.js"></script>
  </body>  
</html>