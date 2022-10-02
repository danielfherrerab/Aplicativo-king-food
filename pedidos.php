<!-- <!DOCTYPE html> -->
<html lang="es">

	<?php
		include_once 'conexion.php';

			if(!isset($_SESSION['id_rol'])) {
				header('location: iniciosesion-cliente.php');
			}
			else{
				if($_SESSION['id_rol'] !=3){
					header('location: iniciosesion-cliente.php');
				}
			}
			$foto_usuario 		= $_SESSION['foto_usuario'];
			$correo_usuario 	= $_SESSION['correo_usuario'];
			$nomusuario 			= $_SESSION['nombre_usuario'];
	?>

  <head> 
    <link rel="stylesheet" href="css/micss.css"> 
    <title>KING FOOD</title>
  </head>

  <body class="img" background="imagenes/fondo-web.png">
			<?php
				$conexion=mysqli_connect('localhost','root','','kingfood') or die ('problemas en la conexion');
				$id_usuarios  = $_SESSION['id_usuarios'];
				$observar     = "SELECT * FROM pedidos where id_usuario = $id_usuarios";

				$ejecutar=mysqli_query($conexion,$observar);
				if(mysqli_num_rows($ejecutar) > 0){
			?>
			
			<div class="titulo-pedidos">Listado de pedidos</div>
				<table class="tabla-pedidos" border="0" cellspacing="3">
					<thead>
						<tr>
							<th>Id pedido      </th>
							<th>Numero de productos</th>
							<th>Fecha compra</th>
							<th>Estado</th>
						</tr>
					</thead>

					<tbody>
						<?php
							while ($filas=mysqli_fetch_array($ejecutar)) {
								$id_pedido    		  = $filas['id_pedido'];
								$numero_productos = $filas['numero_productos'];
								$estado 			      = $filas['estado'];
								$fecha_compra 		  = $filas['fecha_compra'];
						?>

						<tr><form action="#" method="post">
							<td><?php echo $id_pedido;	      ?></td>
							<td><?php echo $numero_productos; ?></td>
							<td><?php echo $fecha_compra; ?></td>
              <td><b><?php echo $estado; if($estado =="en proceso"){ ?></b><br><!--<button class="cancelar"><a href="principal.php? cancelar= <?php echo $id_pedido; ?>">Cancelar</a></button><br>--><button class="confirmar"><a href="principal.php? confirmar= <?php echo $id_pedido; ?>">Confirmar entrega</a></button> <?php } ?></td>
            </form></tr>

						<?php
							}
						?>

					</tbody><div id="cerrar"><a href="principal.php"><img src="imagenes/equis.png" alt="" width="30px"></a></div>
				</table>

			<?php
					}
					else{
			?>

			<div class="titulo-pedidos">Listado de pedidos</div>
				<table class="tabla-pedidos" border="0" cellspacing="3">
					<tr>
						<td class="sin-conte">NO SE ENCONTRO NIGUN PEDIDO</td>
					</tr>
				</table><div id="cerrar"><a href="principal.php"><img src="imagenes/equis.png" alt="" width="30px"></a></div>
			</div>

			<?php
					}
					if(isset($_GET['cancelar'])){
						$id_pedido = $_GET['cancelar'];
						$consulta 				= "UPDATE pedidos set estado = 'cancelado' WHERE id_pedido = $id_pedido";
						$ejecutar					= mysqli_query($conexion,$consulta);
						if($ejecutar){
							echo "<script>alert('Pedido cancelado exitosamente');</script>";
							echo "<script>window.location.href = 'pedidos.php';</script>";
						}
					}
					if(isset($_GET['confirmar'])){
						$id_pedido = $_GET['confirmar'];
						$consulta 				= "UPDATE pedidos set estado = 'entregado' WHERE id_pedido = $id_pedido";
						$ejecutar					= mysqli_query($conexion,$consulta);
						if($ejecutar){
							echo "<script>alert('Confirmacion de pedido entregado aceptada');</script>";
							echo "<script>window.location.href ='pedidos.php';</script>";
						}
					}
			?>
	</body>
</html>
