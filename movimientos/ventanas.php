<!-- Ventanas ventas -->
<div id="agregarVenta" class="w3-modal">
	<?php
		$query = "SELECT * FROM ventas ORDER BY pkventa ASC";
		$resultado = pg_query($conexion, $query) or die("Error al obtener datos en ventas");
		$numRows = pg_num_rows($resultado);
		if($numRows>0){
			while ($fila=pg_fetch_array($resultado)) {
				$lastId = $fila['pkventa']; //Obtener el ultimo id de ventas
			}
		}else{
			$lastId=0;
		}
	?>
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('agregarVenta')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>

		<span class="w3-padding-small w3-large w3-black w3-display-topleft" style="top: 65px;">ID: <?php echo $lastId+1; ?></span>

		<span class="w3-display-topleft w3-padding-small w3-black">
			<input class="w3-border-0 w3-large w3-black" type="time" id="timeNow" readonly><br>
			<input class="w3-border-0 w3-large w3-black" type="date" id="dateToday" readonly>
		</span>

		<form action="insertar.php" method="post">
			<input type="text" name="tabla" value="ventas" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registrar una venta</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registrar una venta</p>
					</div>

					<input name="hora" type="time" id="timeSave" style="display: none;">
					<input name="fecha" type="date" id="dateSave" style="display: none;">
					<input name="id" type="number" value="<?php echo $lastId+1; ?>" style="display: none"> <!-- Se lleva el valor del ID -->

					<div class="w3-row w3-section">
						<div class="w3-block limit">
							<table class="w3-table-all w3-centered w3-hoverable">
								<tr class="w3-light-grey">
									<th>ID</th>
									<th>Seleccione</th>
									<th>Nombre</th>
									<th class="w3-hide-small">Costo</th>
									<th class="w3-hide-small">Disponible</th>
									<th>Cantidad</th>												
								</tr>

								<?php
									$query = "SELECT * FROM productos ORDER BY pkserial ASC";
									$resultado = pg_query($conexion, $query) or die("Error al obtener datos en productos");

									$numProds = pg_num_rows($resultado);

									if($numProds>0){
										while ($fila=pg_fetch_array($resultado)) {
											echo "<tr class='w3-animate-opacity'>";
												if($fila['stock']>0){
													echo "<td>" . $fila['pkserial'] . "</td>";
													echo "<td><input class='w3-check' type='checkbox' id='check".$fila['pkserial']."' name='selected[]' value='" . $fila['pkserial'] . "' onclick='check(".$fila['pkserial'].")'></td>";
													echo "<input value='" . $fila['pkserial'] . "' type='text' name='ids[]' style='display: none;'>";
													echo "<td class='w3-large'>" . $fila['nombre'] . ", " . $fila['marca'] . "</td>";
													echo "<td class='w3-hide-small'>".$fila['precio']."</td>";
													echo "<td class='w3-hide-small'>".$fila['stock']."</td>";
													$place = $fila['pkserial'];
													echo "<td><input class='w3-input w3-border w3-large' type='number' id='canti".$fila['pkserial']."' min='1' max='" . $fila['stock'] . "' name='cantidad[$place]' placeholder='Unidades'></td>";
												}															
											echo "</tr>";
										}
									}else{
										echo "<tr><td colspan='6'>No hay registros</td><tr>";
									}
								?>
							</table>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block w3-margin-top">
							<input class="w3-input w3-border w3-large" name="descuento" type="number" min="0" max="100" placeholder="Descuento a esta venta">
						</div>
					</div>
				</div>
			</div>

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Registrar</button>
				<input type="reset" onclick="closeEl('agregarVenta')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>

<!-- Ventanas gastos -->
<div id="agregarGasto" class="w3-modal">
	<?php
		$query = "SELECT * FROM gastos ORDER BY pkgasto ASC";
		$resultado = pg_query($conexion, $query) or die("Error al obtener datos en gastos");
		$numRows = pg_num_rows($resultado);
		if($numRows>0){
			while ($fila=pg_fetch_array($resultado)) {
				$lastId = $fila['pkgasto']; //Obtener el ultimo id de gastos
			}
		}else{
			$lastId=0;
		}
	?>
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('agregarGasto')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>
		<span class="w3-padding-small w3-xlarge w3-black w3-display-topleft">ID: <?php echo $lastId+1; ?></span>

		<form action="insertar.php" method="post">
			<input type="text" name="tabla" value="gastos" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registrar un gasto</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registrar un gasto</p>
					</div>

					<input name="id" type="number" value="<?php echo $lastId+1; ?>" style="display: none"> <!-- Se lleva el valor del ID -->

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" id="dateSave2" name="fecha" type="date" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" maxlength="200" name="descripcion" autofocus="autofocus" placeholder="Descripción del gasto" type="textarea" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" name="precio" type="number" min="1" max="20000" placeholder="Costo total" required>
						</div>
					</div>
				</div>
			</div>

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Registrar</button>
				<input type="reset" onclick="closeEl('agregarGasto')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>