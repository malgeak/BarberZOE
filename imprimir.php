<?php
	include "config.php"; //Configuraciones y recursos
?>

<!DOCTYPE html>
<html>
	<head>
		<title>IMPRIMIR - <?php echo $negocio;?></title>
	</head>
	<body>
		<div class="ribbon w3-red w3-card-4" style="position: fixed; padding: 20px 0; right: -200px; top: 55px; width: 550px; left: unset;">EN DESARROLLO</div>

		<div style="width: 595px !important; height: 842px !important; overflow: hidden; display: block; margin: auto; background: white;">
			<div class="w3-row w3-center">
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "GET") {
						//Obtener todas las variables y tabla

						//Imprimir encabezado con nombre de tabla
						echo "<h3>Registro # de tabla X</h3>";
						//Imprimir tabla con registro(s)
						echo "<table class='w3-table-all w3-centered'>";
							echo "<tr class='w3-light-grey'>";
								echo "<th>COLUMNAS</th>";
								echo "<th>COLUMNAS</th>";
								echo "<th>COLUMNAS</th>";
								echo "<th>COLUMNAS</th>";
							echo "</tr>";

							for($i=0; $i<10; $i++){
								echo "<tr>";
									echo "<td>REGISTROS</td>";
									echo "<td>REGISTROS</td>";
									echo "<td>REGISTROS</td>";
									echo "<td>REGISTROS</td>";
								echo "</tr>";								
							}
							echo "<tr>";
								echo "<td colspan='2'></td>";
								echo "<td class='w3-right-align'>TOTAL:</td>";
								echo "<td class='w3-left-align'>NNN</td>";
							echo "</tr>";								
						echo "</table>";

						//Agregar boton especial para imprimir (navegador)
					}else{
						redireccionar("");
					}
				?>
			</div>
		</div>
	</body>
</html>