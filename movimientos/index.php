<!-- MOVIMIENTOS -->
<div id="Movimientos" style="height: 100%;" class="hidden w3-animate-opacity w3-content w3-padding-large w3-margin-top w3-margin-bottom">			
	<div class="w3-white w3-card-4 w3-margin-bottom">
		<div class="w3-row">
			<div class="w3-padding">
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Movimientos</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Movimientos</p>
			</div>
		</div>

		<div class="w3-row">
			<div class="w3-center w3-padding w3-block">
				<button id="ve" onclick="openTab2(event, 'ventas')" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs2">Ventas</button>
				<button id="ga" onclick="openTab2(event, 'gastos')" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs2">Gastos</button>
			</div>
		</div>
	</div>

	<!-- VENTAS -->
	<div class="w3-white w3-card-4 w3-margin-top">
		<div class="w3-row">
			<div id="ventas" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top buttonGan">	
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registros de ventas</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registros de ventas</p>

				<div class="w3-row w3-section">
					<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
					<div class="w3-rest">
						<input class="w3-input w3-border w3-large" id="buscadorVentas" type="text" onkeyup="filtradorVentas()" placeholder="AAAA-MM-DD">
					</div>
				</div>

				<div class="w3-row limit">									
					<table class="w3-table-all w3-centered w3-hoverable" id="tablaVentas">	
						<tr class="w3-light-grey">
							<th>ID</th>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Descuento</th>
							<th>Total</th>
							<th>Descripción</th>
						</tr>

						<?php
							$query = "SELECT * FROM ventas ORDER BY pkventa ASC";
							$resultado = pg_query($conexion, $query) or die("Error al obtener datos de ventas");
							$numProds = pg_num_rows($resultado);

							if($numProds>0){
								while ($fila=pg_fetch_array($resultado)) {
									echo "<tr class='w3-animate-opacity'>";
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
									echo "</tr>";
								}
							}else{
								echo "<tr><td colspan='6'>No hay registros</td><tr>";
							}
						?>
					</table>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<button onclick="openEl('agregarVenta'); SetDate(); alerta('Llene todos los campos')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Agregar</button>
						<button onclick="windowOpen('<?php echo $raiz."imprimir.php"."?fecha=indefinida&movimientos=ventas";?>');return false" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Imprimir</button>
					</div>
				</div>
			</div>
			
			<!-- GASTOS -->
			<div id="gastos" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top buttonGan">	
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registros de gastos</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registros de gastos</p>

				<div class="w3-row w3-section">
					<div class="w3-col w3-block">
						<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
						<div class="w3-rest">
							<input class="w3-input w3-border w3-large" id="buscadorGastos" type="text" onkeyup="filtradorGastos()" placeholder="AAAA-MM-DD">
						</div>
					</div>
				</div>

				<div class="w3-row limit">									
					<table class="w3-table-all w3-centered w3-hoverable" id="tablaGastos">
						<tr class="w3-light-grey">
							<th>ID</th>
							<th>Registrado</th>
							<th>Total</th>
							<th>Descripción</th>
						</tr>

						<?php
							$query = "SELECT * FROM gastos ORDER BY pkgasto ASC";
							$resultado = pg_query($conexion, $query) or die("Error al obtener datos en gastos");
							$numMats = pg_num_rows($resultado);

							if($numMats>0){
								while ($fila=pg_fetch_array($resultado)) {
									echo "<tr class='w3-animate-opacity'>";
										echo "<td>" . $fila['pkgasto'] . "</td>";
										echo "<td>" . $fila['fkfecha'] . "</td>";
										echo "<td>$" . $fila['costototal'] . "</td>";
										echo "<td>" . $fila['descripcion'] . "</td>";
									echo "</tr>";
								}
							}else{
								echo "<tr><td colspan='4'>No hay registros</td><tr>";
							}
						?>
					</table>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<button onclick="openEl('agregarGasto'); SetDate(); alerta('Llene todos los campos')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Agregar</button>
						<button onclick="windowOpen('<?php echo $raiz."imprimir.php"."?fecha=indefinida&movimientos=gastos";?>');return false" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Imprimir</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include "ventanas.php";
?>