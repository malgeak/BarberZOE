<!-- INVENTARIO -->
<div id="Inventario" style="height: 100%;" class="hidden w3-animate-opacity w3-content w3-padding-large w3-margin-top">			
	<div class="w3-white w3-card-4 w3-margin-bottom">
		<div class="w3-row">
			<div class="w3-padding">
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Inventario</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Inventario</p>
			</div>
		</div>

		<div class="w3-row">
			<div class="w3-center w3-padding w3-block">
				<button id="pr" onclick="openTab(event, 'barberia')" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs">Barbería</button>
				<button id="ma" onclick="openTab(event, 'peluqueria')" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs">Peluquería</button>
			</div>
		</div>
	</div>

	<div class="w3-white w3-card-4 w3-margin-top">
		<div class="w3-row">
			<div id="barberia" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top buttonInv">	
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Productos de barbería</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Productos de barbería</p>

				<div class="w3-row w3-section">
					<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
					<div class="w3-rest">
						<input class="w3-input w3-border w3-large" id="buscadorProductos" type="text" onkeyup="filtradorProductos()" placeholder="Buscar producto por nombre">
					</div>
				</div>

				<div class="w3-row limit">									
					<table class="w3-table-all w3-centered w3-hoverable" id="tablaProductos">	
						<tr class="w3-light-grey">
							<th>ID</th>
							<th>Nombre</th>
							<th>Marca</th>
							<th>Precio</th>
							<th>Stock</th>
						</tr>

						<?php
							$query = "SELECT * FROM productos ORDER BY pkserial ASC";
							$resultado = pg_query($conexion, $query) or die("Error al obtener datos de productos");
							$numProds = pg_num_rows($resultado);

							if($numProds>0){
								while ($fila=pg_fetch_array($resultado)) {
									echo "<tr class='w3-animate-opacity'>";
										echo "<td>" . $fila['pkserial'] . "</td>";
										echo "<td>" . $fila['nombre'] . "</td>";
										echo "<td>" . $fila['marca'] . "</td>";
										echo "<td>$" . $fila['precio'] . "</td>";
										if($fila['stock'] == 0){
											echo "<td><i class='fa fa-close'></i></td>";
										}elseif ($fila['stock'] > 0 & $fila['stock'] <= 10) {
											echo "<td>" . $fila['stock'] ." <i class='fa fa-exclamation'></i></td>";
										}else{
											echo "<td>" . $fila['stock'] . "</td>";
										}												
									echo "</tr>";
								}
							}else{
								echo "<tr><td colspan='5'>No hay registros</td><tr>";
							}
						?>
					</table>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<button onclick="openEl('agregarBar'); alerta('Llene todos los campos')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Agregar</button>
						<button onclick="openEl('eliminarBar'); alerta('Seleccione los productos a eliminar')" class="w3-border w3-white w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom">Eliminar</button>
						<button onclick="openEl('restockBarber'); alerta('Todo el inventario se actualizará')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Stock</button>
					</div>
				</div>
			</div>

			<div id="peluqueria" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top buttonInv">	
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Materiales de peluquería</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Materiales de peluquería</p>

				<div class="w3-row w3-section">
					<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
					<div class="w3-rest">
						<input class="w3-input w3-border w3-large" id="buscadorMateriales" type="text" onkeyup="filtradorMateriales()" placeholder="Buscar material por nombre">
					</div>
				</div>

				<div class="w3-row limit">									
					<table class="w3-table-all w3-centered w3-hoverable" id="tablaMateriales">
						<tr class="w3-light-grey">
							<th>ID</th>
							<th>Nombre</th>
							<th>Marca</th>
							<th>Costo</th>
							<th>Stock</th>
						</tr>

						<?php
							$query = "SELECT * FROM materiales ORDER BY pkserial ASC";
							$resultado = pg_query($conexion, $query) or die("Error al obtener datos en materiales");
							$numMats = pg_num_rows($resultado);

							if($numMats>0){
								while ($fila=pg_fetch_array($resultado)) {
									echo "<tr class='w3-animate-opacity'>";
										echo "<td>" . $fila['pkserial'] . "</td>";
										echo "<td>" . $fila['nombre'] . "</td>";
										echo "<td>" . $fila['marca'] . "</td>";
										echo "<td>$" . $fila['precio'] . "</td>";
										if($fila['stock'] == 0){
											echo "<td><i class='fa fa-close'></i></td>";
										}elseif ($fila['stock'] > 0 & $fila['stock'] <= 10) {
											echo "<td>" . $fila['stock'] ." <i class='fa fa-exclamation'></i></td>";
										}else{
											echo "<td>" . $fila['stock'] . "</td>";
										}				
									echo "</tr>";
								}
							}else{
								echo "<tr><td colspan='5'>No hay registros</td><tr>";
							}
						?>
					</table>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<button onclick="openEl('agregarPel'); alerta('Llene todos los campos')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Agregar</button>
						<button onclick="openEl('eliminarPel'); alerta('Seleccione los materiales a eliminar')" class="w3-border w3-white w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom">Eliminar</button>
						<button onclick="openEl('restockPeluq'); alerta('Todo el inventario se actualizará')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Stock</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	include "ventanas.php";
?>