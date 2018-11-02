<!--
	LU: 28/10/18

	Total lenguajes y framework utilizados:
	PHP, JAVASCRIPT, CSS3, HTML5, MYSQL, W3.CSS.
-->

<?php
	include "config.php"; //Configuraciones, recursos, conexiones...
	//Cambios
	/*
		implementar stuff en agenda
		Maximo 2 por dia eventos (CORREGIR)
	*/
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $negocio;?></title>
	</head>
	<body style="background: url('<?php echo $fondo;?>');">		
		<?php
			include "recursos/php/menu.php"; //Obtiene el menu y los vinculos de pestañas
		?>	

		<div class="ribbon w3-red w3-card-4" style="position: fixed; padding: 20px 0; right: -200px; top: 55px; width: 550px; left: unset;">EN DESARROLLO</div>

		<div class="w3-animate-opacity w3-margin-top"> <!-- Contenedor principal tabs -->
			<!-- PORTADA -->
			<div id="portada" class="w3-animate-opacity hide">				
				<div class="w3-center">					
					<img src="recursos/imagenes/logo.jpg" alt="Logo imagen" style="max-width: 400px; width: 100%; border: 60px solid black;">
				</div>
			</div>

			<?php
				require "inventario.php"; //Inventario, pestaña y ventanas
				require "movimientos.php"; //Movimientos, pestaña y ventanas
				require "agenda.php"; //Agenda, pestaña y ventanas

				if(empty($_GET["pestaña"])){
					echo "<script>w3.show('#portada'); w3.show('#zoe'); w3.hide('#inventario'); w3.hide('#movimientos'); w3.hide('#agenda');</script>";
				}else{
					if(empty($_GET["tab"])){
						echo "<script>w3.show('#".$_GET["pestaña"]."');w3.show('#productos');w3.show('#ventas');</script>";	
					}else{
						echo "<script>w3.show('#".$_GET["pestaña"]."');w3.show('#".$_GET["tab"]."');</script>";	
					}
				}
			?>
		</div>

		<!-- MENSAJES DE ALERTA -->
		<div id="snackbar"></div>
	</body>
</html>