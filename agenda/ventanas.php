<!-- Ventanas agenda -->
<div id="agregarEvento" class="w3-modal">
	<?php 
		$query = "SELECT * FROM eventos ORDER BY eventos ASC";
		$resultado = pg_query($conexion, $query) or die("Error al obtener datos en eventos");
		$numRows = pg_num_rows($resultado);
		if($numRows>0){
			while ($fila=pg_fetch_array($resultado)) {
				$lastId = $fila['pkevento'];
			}
		}else{
			$lastId=0;
		}
	?>
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('agregarEvento')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>

		<span class="w3-padding-small w3-xlarge w3-black w3-display-topleft">ID: <?php echo $lastId+1; ?></span>

		<form action="insertar.php" method="post">
			<input type="text" name="tabla" value="eventos" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registrar un evento</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registrar un evento</p>
					</div>

					<input name="id" type="number" value="<?php echo $lastId+1; ?>" style="display: none"> <!-- Se lleva el valor del ID -->
					<input name="registro" type="date" id="dateSave3" style="display: none">  <!-- Se lleva la fecha de registro -->

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" name="fecha" type="date" required autofocus="autofocus">
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" maxlength="50" placeholder="Titulo del evento" name="nombre" type="textarea" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" maxlength="50" placeholder="Descripcion del evento" name="descripcion" type="textarea" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<select class="w3-input w3-border" name="tipoE">
								<option value="Cumple">Cumpleaños</option>
								<option value="Fiesta">Fiestuki</option>
								<option value="Aniv">Aniversario</option>
								<option value="Boda">Pinshi Bodorrio</option>
								<option value="Cita" selected>Cita</option>
								<option value="Serie">Final de serie</option>
								<option value="Novela">Final de novela</option>
								<option value="Evento">Evento</option>
								<option value="Viaje">Viaje</option>
								<option value="Salida">Salida</option>
							</select>
						</div>
					</div>								
				</div>
			</div>

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Registrar</button>
				<input type="reset" onclick="closeEl('agregarEvento')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>

<div id="eliminarEvento" class="w3-modal">
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('eliminarEvento')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>

		<form action="eliminar.php" method="post">		
		<input type="text" name="tabla" value="eventos" style="display: none;">				
			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Eliminar eventos</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Eliminar eventos</p>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-row w3-content w3-margin-top limit">
							<table class="w3-table-all w3-centered w3-hoverable">
								<tr class="w3-light-grey">
									<th>Seleccione</th>
									<th>Nombre</th>
									<th>Tipo</th>
									<th>Fecha</th>
								</tr>

								<?php
									$query = "SELECT * FROM eventos ORDER BY pkevento ASC";
									$resultado = pg_query($conexion, $query) or die("Error al obtener datos en eventos");
									$numProds = pg_num_rows($resultado);

									if($numProds>0){
										while ($fila=pg_fetch_array($resultado)) {
											echo "<tr class='w3-animate-opacity'>";
												echo "<td><input class='w3-check' type='checkbox' name='selected[]' value='" . $fila['pkevento'] . "'></td>";
												echo "<td>" . $fila['nombre'] . "</td>";
												echo "<td>" . $fila['tipo'] . "</td>";
												echo "<td>" . $fila['fecha'] . "</td>";
											echo "</tr>";
										}
									}else{
										echo "<tr><td colspan='4'>No hay registros</td><tr>";
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>					

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Eliminar</button>
				<input type="reset" onclick="closeEl('eliminarEvento')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>

<div id="revisarEventos" class="w3-modal">
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('revisarEventos')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>

		<div class="w3-section">
			<div class="w3-center w3-padding-small w3-block">
				<div class="w3-row w3-section">
					<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registros de eventos</h1>
					<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registros de eventos</p>
				</div>

				<div class="w3-row w3-section">
					<div class="w3-block limit">
						<table class="w3-table-all w3-centered w3-hoverable w3-margin-bottom">
							<tr class="w3-light-grey">
								<th>id</th>
								<th>Titulo</th>
								<th>Descripcion</th>
								<th>Tipo</th>												
								<th>Fecha</th>												
							</tr>

							<?php
								$query = "SELECT * FROM eventos ORDER BY pkevento ASC";
									$resultado = pg_query($conexion, $query) or die("Error al obtener datos en eventos");
									$numProds = pg_num_rows($resultado);

									if($numProds>0){
										while ($fila=pg_fetch_array($resultado)) {
											echo "<tr class='w3-animate-opacity'>";
												echo "<td>" . $fila['pkevento'] . "</td>";
												echo "<td>" . $fila['nombre'] . "</td>";
												echo "<td>" . $fila['descripcion'] . "</td>";
												echo "<td>" . $fila['tipo'] . "</td>";
												echo "<td>" . $fila['fecha'] . "</td>";
											echo "</tr>";
										}
									}else{
										echo "<tr><td colspan='5'>No hay registros</td><tr>";
									}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>