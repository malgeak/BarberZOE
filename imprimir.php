<?php
	include "config.php"; //Configuraciones
	include "recursos/php/functions.php"; //Funciones visuales
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
	<body style="background: #cfcfcf; width: 100%; height: 100%;">
		<div style="width: 595px !important; height: 842px !important; overflow: hidden; display: block; margin: auto; background: white;">
			<div class="w3-row w3-center">
				<?php
					$movimiento=null;
					$total=$sumatoria=0; //Sumatorias
					#$fecha=null; ->Por implementar		
					$id=null;
					if(empty($_GET["movimientos"])){
						echo "Error!";
						$movimiento="Error!";
					}else{
						$movimiento=$_GET['movimientos'];
						
						if($movimiento=="ventas"){ //Cabeceras
							$id="pkventa";
						}else if($movimiento=="gastos"){
							$id="pkgasto";
						}
						
						$query = "SELECT * FROM $movimiento ORDER BY $id ASC";
						$resultado = pg_query($conexion, $query) or die("Error al obtener datos de $movimiento");
						$numMovs = pg_num_rows($resultado);

						echo "<h3>Todos los registros de " . $movimiento . "</h3>";
						echo '<table class="w3-table-all w3-centered" id="'.$movimiento.'">';
						echo '<tr class="w3-light-grey">';
						if($movimiento=="ventas"){ //Cabeceras
							echo "
								<th>ID</th>
								<th>Fecha</th>
								<th>Hora</th>
								<th>Descuento</th>
								<th>Total</th>
								<th>Descripción</th>
							";
						}else if($movimiento=="gastos"){
							echo "
								<th>ID</th>
								<th>Fecha</th>
								<th>Total</th>
								<th>Descripción</th>
							";
						}
						echo "</tr>";

						if($numMovs>0){ //Filas
							while ($fila=pg_fetch_array($resultado)) {
								echo "<tr class='w3-animate-opacity'>";
								if($movimiento=="ventas"){ //Filas
									echo "<td>" . $fila['pkventa'] . "</td>";
									echo "<td>" . $fila['fkfecha'] . "</td>";	
									echo "<td>" . substr_replace($fila['hora'],"",5) . "</td>";
									if($fila['descuento']>0){
										echo "<td>" . $fila['descuento'] . "%</td>";
									}else{
										echo "<td>-----</td>";
									}														
									echo "<td>$" . $fila['costototal'] . "</td>";
									echo "<td><div class='w3-small'>".$fila['descripcion']."</div></td>";
								}else if($movimiento=="gastos"){
									echo "<td>" . $fila['pkgasto'] . "</td>";
									echo "<td>" . $fila['fkfecha'] . "</td>";	
									echo "<td>$" . $fila['costototal'] . "</td>";
									echo "<td><div class='w3-small'>".$fila['descripcion']."</div></td>";
								}
									
								echo "</tr>";

								$total++; //Total de registros
								$sumatoria+=$fila['costototal']; //Total de $
							}

							echo "<tr class='w3-animate-opacity'>";
								echo "<td colspan='6'>Total ".$movimiento.": ".$total."<br>Total: $".$sumatoria."</td>";
							echo "</tr>";
						}else{
							if($movimiento=="ventas"){ //Cabeceras
								echo "<tr><td colspan='6'>No hay registros</td><tr>";
							}else if($movimiento=="gastos"){
								echo "<tr><td colspan='4'>No hay registros</td><tr>";
							}
							
						}
						echo "</table>";
					}
				?>
			</div>
		</div>
	</body>
</html>

<?php
	pg_close($conexion);
?>