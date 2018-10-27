<!--
	LU: 27/10/18

	Total lenguajes y framework utilizados:
	PHP, JAVASCRIPT, CSS3, HTML5, POSTGRESQL, W3.CSS.
-->

<?php
	include "config.php"; //Configuraciones
	include "recursos/php/functions.php"; //Funciones visuales
	//Cambios
	/*
		implementar stuff en agenda
		Maximo 2 por dia eventos (CORREGIR)
	*/
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $negocio;?></title> <!-- Titulo en pestaña navegador -->
		<meta charset="UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="recursos/imagenes/favicon.ico">

		<!-- JQUERY Y HTML5 -->
		<script src="recursos/js/html5shiv.js"></script> <!-- HTML5 -->
		<meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Visual en moviles -->

		<!-- RECURSOS -->
		<link rel="stylesheet" href="recursos/css/w3.css"> <!-- FRAMEWORK (VISUAL) CSS -->

		<!-- Fuentes (De ser posible) e iconos
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- Esta pagina -->		
		<link rel="stylesheet" href="recursos/css/barberia.css"> <!-- Estilos componentes -->
	</head>
	<body style="background: url('<?php echo $fondo;?>');">
		<?php
			include "recursos/php/menu.php"; //Obtiene el menu y los vinculos de pestañas
		?>

		<div class="w3-animate-opacity"> <!-- Contenedor principal tabs -->
			<!-- PORTADA -->
			<div id="main" style="height: 100%;" class="hidden w3-animate-opacity">
				<div class="w3-padding-16 w3-center" style="width: 100%;">
					<img src="recursos/imagenes/logo.jpg" alt="Logo imagen" style="max-width: 400px; width: 100%; border: 60px solid black;">
				</div>
			</div>

			<?php
				include "inventario/index.php"; //Inventario, pestaña y ventanas
				include "movimientos/index.php"; //Movimientos, pestaña y ventanas
				include "agenda/index.php"; //Agenda, pestaña y ventanas
			?>
		</div>

		<!-- MENSAJES DE ALERTA -->
		<div id="snackbar">
			<!-- ABRIR PESTAÑAS PREDETERMINADAS (VISUAL) -->
			<script>
				<?php
					/*
						$_GET["pestaña"]) -> Que pestaña tuvo una accion
						$_GET["tab"]) -> Que subpestaña tuvo una accion
					*/

					if(empty($_GET["pestaña"])){ //Si la pestaña no tiene accion
						$pestaña = null; //Limpia variable				
						//Abre pestañas predeterminadas
						echo "document.getElementById(\"p\").click();"; //Portada
						echo "document.getElementById(\"pr\").click();"; //Inventario->Productos
						echo "document.getElementById(\"ve\").click();"; //Movimientos->Ventas
					}else{ //Pestaña tuvo cambios
						$pestaña = $_GET["pestaña"]; //Pestaña vinculo
						if(empty($_GET["tab"])){ //Subpestaña no tuvo accion
							$tab = null; //Limpia variable
							//Subpestañas predeterminadas
							echo "document.getElementById(\"pr\").click();"; //Productos
							echo "document.getElementById(\"ve\").click();"; //Ventas
						}else{ //Vinculo subpestaña
							$tab = $_GET["tab"];
						}												
						switch ($pestaña) {
							case "inventario":
								echo "document.getElementById(\"i\").click();"; //Inventario
								if($tab=="productos"){
									echo "document.getElementById(\"pr\").click();"; //Productos
									echo "document.getElementById(\"ve\").click();"; //Ventas
								}else if($tab == "materiales"){
									echo "document.getElementById(\"ma\").click();"; //Materiales
									echo "document.getElementById(\"ve\").click();"; //Ventas
								}else{
									echo "document.getElementById(\"pr\").click();"; //Predeterminada
									echo "document.getElementById(\"ve\").click();"; //Ventas
								}
								break;

							case "movimientos":
								echo "document.getElementById(\"m\").click();"; //Movimientos
								if($tab=="ventas"){
									echo "document.getElementById(\"ve\").click();"; //Ventas
									echo "document.getElementById(\"pr\").click();"; //Productos
								}else if($tab == "gastos"){
									echo "document.getElementById(\"ga\").click();"; //Gastos
									echo "document.getElementById(\"pr\").click();"; //Productos
								}else{
									echo "document.getElementById(\"ve\").click();"; //Predeterminada
									echo "document.getElementById(\"pr\").click();"; //Productos
								}
								break;

							case "agenda":
								echo "document.getElementById(\"a\").click();"; //Agenda
								break;
							
							default:
								echo "document.getElementById(\"p\").click();"; //Predeterminada
								break;
						}
					}
				?>
			</script>
		</div>
	</body>
</html>

<?php
	mysqli_close($conexion);
?>