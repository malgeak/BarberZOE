<!-- Ventanas productos barberia -->
<div id="agregarBar" class="w3-modal">
	<?php 
		$query = "SELECT * FROM productos ORDER BY pkserial ASC";
		$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos en productos");
		$numRows = mysqli_num_rows($resultado);
		if($numRows>0){
			while ($fila=mysqli_fetch_array($resultado)) {
				$lastId = $fila['pkserial'];
			}
		}else{
			$lastId=0;
		}
	?>

	<div class="w3-marging-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('agregarBar')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>
		<span class="w3-padding-small w3-xlarge w3-black w3-display-topleft">ID: <?php echo $lastId+1; ?></span>

		<form action="insertar.php" method="post">
			<input type="text" name="tabla" value="productos" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Añadir producto a barbería</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Añadir producto a barbería</p>
					</div>

					<input name="id" type="number" value="<?php echo $lastId+1; ?>" style="display: none"> <!-- Se lleva el valor del ID -->

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" maxlength="50" name="nombre" type="text" placeholder="Nombre del producto" autofocus="autofocus" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" maxlength="50" max="20" name="marca" type="text" placeholder="Marca del producto" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" name="precio" type="number" min="1" max="1000" placeholder="Precio del producto" onfocus="alerta('Moneda: MXN')" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" name="stock" type="number" min="0" max="250" placeholder="Stock del producto">
						</div>
					</div>
				</div>
			</div>

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Agregar</button>
				<input type="reset" onclick="closeEl('agregarBar')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>			

<div id="eliminarBar" class="w3-modal">
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('eliminarBar')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>

		<form action="eliminar.php" method="post">
			<input type="text" name="tabla" value="productos" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Eliminar productos de barbería</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Eliminar productos de barbería</p>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-row w3-content w3-margin-top limit">
							<table class="w3-table-all w3-centered w3-hoverable">
								<tr class="w3-light-grey">
									<th>Seleccione</th>
									<th>Serial</th>
									<th>Nombre</th>
									<th>Marca</th>
								</tr>

								<?php
									$query = "SELECT * FROM productos ORDER BY pkserial ASC";
									$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos en productos");
									$numProds = mysqli_num_rows($resultado);

									if($numProds>0){
										while ($fila=mysqli_fetch_array($resultado)) {
											echo "<tr class='w3-animate-opacity'>";
												echo "<td><input class='w3-check' type='checkbox' name='selected[]' value='" . $fila['pkserial'] . "'></td>";
												echo "<td>" . $fila['pkserial'] . "</td>";
												echo "<td>" . $fila['nombre'] . "</td>";
												echo "<td>" . $fila['marca'] . "</td>";
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
				<input type="reset" onclick="closeEl('eliminarBar')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>

<div id="restockBarber" class="w3-modal">
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<div class="w3-center"><br>
			<span onclick="closeEl('restockBarber')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>
		</div>

		<form action="actualizar.php" method="post">
		<input type="text" name="tabla" value="productos" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Actualizar stock de barbería</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Actualizar stock de barbería</p>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-row w3-content w3-margin-top limit">
							<table class="w3-table-all w3-centered w3-hoverable">
								<tr class="w3-light-grey">
									<th>ID</th>
									<th>Nombre</th>
									<th>Marca</th>
									<th>Precio</th>
									<th>Stock</th>
								</tr>

								<?php
									$query = "SELECT * FROM productos ORDER BY pkserial ASC";
									$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos en productos");
									$numProds = mysqli_num_rows($resultado);

									if($numProds>0){
										while ($fila=mysqli_fetch_array($resultado)) {
											echo "<tr class='w3-animate-opacity'>";
												echo "<td>" . $fila['pkserial'] . "</td>";
												echo "<input value='" . $fila['pkserial'] . "' type='text' name='id[]' style='display: none;'>";
												echo "<td>" . $fila['nombre'] . "</td>";
												echo "<td>" . $fila['marca'] . "</td>";
												echo "<td><input class='w3-input w3-border w3-large' value='" . $fila['precio'] . "' type='number' min='1' name='precio[]' required></td>";
												echo "<td><input class='w3-input w3-border w3-large' value='" . $fila['stock'] . "' type='number' min='0' max='250' name='stock[]' required></td>";															
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

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Actualizar</button>
				<input type="reset" onclick="closeEl('restockBarber')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>

<!-- Ventanas productos peluqueria -->
<div id="agregarPel" class="w3-modal">
	<?php 
		$query = "SELECT * FROM materiales ORDER BY pkserial ASC";
		$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos en materiales");
		$numRows = mysqli_num_rows($resultado);
		if($numRows>0){
			while ($fila=mysqli_fetch_array($resultado)) {
				$lastId = $fila['pkserial'];
			}
		}else{
			$lastId=0;
		}
	?>

	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('agregarPel')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>

		<span class="w3-padding-small w3-xlarge w3-black w3-display-topleft">ID: <?php echo $lastId+1; ?></span>

		<form action="insertar.php" method="post">
			<input type="text" name="tabla" value="materiales" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Añadir material a peluquería</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Añadir material a peluquería</p>
					</div>								

					<input name="id" type="number" value="<?php echo $lastId+1; ?>" style="display: none"> <!-- Se lleva el valor del ID -->

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" maxlength="50" name="nombre" type="text" placeholder="Nombre del material" autofocus="autofocus" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" maxlength="50" name="marca" type="text" placeholder="Marca del material" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" max="1000" name="precio" type="number" min="1" placeholder="Precio del material" onfocus="alerta('Moneda: MXN')" required>
						</div>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-block">
							<input class="w3-input w3-border w3-large" name="stock" type="number" min="0" max="250" placeholder="Stock del material">
						</div>
					</div>
				</div>
			</div>

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Agregar</button>
				<input type="reset" onclick="closeEl('agregarPel')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>

<div id="eliminarPel" class="w3-modal">
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<span onclick="closeEl('eliminarPel')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>

		<form action="eliminar.php" method="post">
		<input type="text" name="tabla" value="materiales" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Eliminar materiales de peluquería</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Eliminar materiales de peluquería</p>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-row w3-content w3-margin-top limit">
							<table class="w3-table-all w3-centered w3-hoverable">
								<tr class="w3-light-grey">
									<th>Seleccione</th>
									<th>Serial</th>
									<th>Nombre</th>
									<th>Marca</th>
								</tr>

								<?php
									$query = "SELECT * FROM materiales ORDER BY pkserial ASC";
									$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos en materiales");
									$numProds = mysqli_num_rows($resultado);

									if($numProds>0){
										while ($fila=mysqli_fetch_array($resultado)) {
											echo "<tr class='w3-animate-opacity'>";
												echo "<td><input class='w3-check' type='checkbox' name='selected[]' value='" . $fila['pkserial'] . "'></td>";
												echo "<td>" . $fila['pkserial'] . "</td>";
												echo "<td>" . $fila['nombre'] . "</td>";
												echo "<td>" . $fila['marca'] . "</td>";
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
				<input type="reset" onclick="closeEl('eliminarPel')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>

<div id="restockPeluq" class="w3-modal">
	<div class="w3-margin-bottom w3-modal-content w3-card-4 w3-animate-zoom limitWindow" style="padding-top: 0px !important;">
		<div class="w3-center"><br>
			<span onclick="closeEl('restockPeluq')" class="w3-button w3-xlarge w3-hover-black w3-red w3-display-topright" title="Cerrar ventana">&times;</span>
		</div>

		<form action="actualizar.php" method="post">
			<input type="text" name="tabla" value="materiales" style="display: none;">

			<div class="w3-section">
				<div class="w3-center w3-padding-small w3-block">
					<div class="w3-row w3-section">
						<h1 class="w3-xxlarge w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Actualizar stock de materiales</h1>
						<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Actualizar stock de materiales</p>
					</div>

					<div class="w3-row w3-section">
						<div class="w3-row w3-content w3-margin-top limit">
							<table class="w3-table-all w3-centered w3-hoverable">
								<tr class="w3-light-grey">
									<th>ID</th>
									<th>Nombre</th>
									<th>Marca</th>
									<th>Costo</th>
									<th>Stock</th>
								</tr>

								<?php
									$query = "SELECT * FROM materiales ORDER BY pkserial ASC";
									$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos en materiales");
									$numProds = mysqli_num_rows($resultado);

									if($numProds>0){
										while ($fila=mysqli_fetch_array($resultado)) {
											echo "<tr class='w3-animate-opacity'>";
												echo "<td>" . $fila['pkserial'] . "</td>";
												echo "<input value='" . $fila['pkserial'] . "' type='text' name='id[]' style='display: none;'>";
												echo "<td>" . $fila['nombre'] . "</td>";
												echo "<td>" . $fila['marca'] . "</td>";
												echo "<td><input class='w3-input w3-border w3-large' value='" . $fila['precio'] . "' type='number' min='1' name='precio[]' required></td>";
												echo "<td><input class='w3-input w3-border w3-large' value='" . $fila['stock'] . "' type='number' min='0' max='250' name='stock[]' required></td>";														
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

			<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button class="w3-button w3-blue w3-half w3-hover-black" type="submit">Actualizar</button>
				<input type="reset" onclick="closeEl('restockPeluq')" class="w3-button w3-red w3-half w3-hover-black" value="Cancelar">							
			</div>
		</form>
	</div>
</div>