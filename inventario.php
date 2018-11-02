<!-- INVENTARIO -->
<div id="inventario" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top hide">	
	<div class="w3-white w3-card-4 w3-margin-bottom">
		<div class="w3-row">
			<div class="w3-padding">
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Inventario</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Inventario</p>
			</div>
		</div>

		<div class="w3-row">
			<div class="w3-center w3-padding w3-block">
				<button onclick="w3.show('#productos'); w3.hide('#materiales');" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs">Productos</button>
				<button onclick="w3.show('#materiales'); w3.hide('#productos');" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs">Materiales</button>
			</div>
		</div>
	</div>

	<div class="w3-white w3-card-4 w3-margin-top">
		<div class="w3-row">
			<div id="productos" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top hide">
				<div class="w3-row w3-display-container w3-center">
					<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Productos</h1>
					<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Productos</p>

					<button style="right: 100px; top: 65px;" onclick="w3.show('#agregarProducto'); alerta('Llene todos los campos')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-display-right"><i class="fa fa-plus"></i></button>
				</div>	

				<div class="w3-row w3-section">
					<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
					<div class="w3-rest">
						<input class="w3-input w3-border w3-large" oninput="w3.filterHTML('#tablaProductos', '.trTablaProductos', this.value)" type="text" placeholder="Buscar por datos de producto">
					</div>
				</div>

				<div class="w3-row limit">									
					<table class="w3-table-all w3-centered w3-hoverable" id="tablaProductos">	
						<tr class="w3-light-grey">
							<th>Código <i class="fa fa-barcode"></i></th>
							<th>Nombre</th>
							<th>Marca</th>
							<th>Precio</th>
							<th>Stock</th>
							<th>Acciones</th>
						</tr>

						<?php
							try { //Implementación con PDO
							    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
							    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Tipo de concexión -> PDO				
							    $sql = "SELECT codigo, AES_DECRYPT(nombre, '$specialKey') nombre, AES_DECRYPT(marca, '$specialKey') marca, AES_DECRYPT(precio, '$specialKey') precio, AES_DECRYPT(stock, '$specialKey') stock FROM productos ORDER BY nombre ASC";
							    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
							    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
							    #echo "Datos obtenidos correctamente. <br>";

							    $counter = 0;
							    
								foreach ($conn->query($sql) as $registro) {								
									echo "<tr class='w3-animate-opacity trTablaProductos'>";
										echo "<td><b>" . $registro['codigo'] . "</b></td>";
										echo "<td>" . $registro['nombre'] . "</td>";
										echo "<td>" . $registro['marca'] . "</td>";
										echo "<td>$" . $registro['precio'] . "</td>";
										if($registro['stock'] == 0){
											echo "<td><i class='fa fa-close w3-text-red'></i></td>";
										}elseif ($registro['stock'] > 0 & $registro['stock'] <= 10) {
											echo "<td>" . $registro['stock'] ." <i class='fa fa-exclamation w3-text-amber'></i></td>";
										}else{
											echo "<td>" . $registro['stock'] . "</td>";
										}

										modal("editarProducto".$counter,
											"Editar datos del producto<br>
											<span class='w3-small'>¡Asegurate de hacer clic en actualizar!</span>

											<form action='" . $raiz . "?pestaña=inventario&tab=productos' method='post'>
												<div class='w3-border w3-padding-large w3-round-medium' style='display:block;margin:auto;width:70%;'>
													<div class='w3-row-padding w3-margin-bottom'>
														<div class='w3-quarter w3-right-align'><b>Código:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border w3-disabled' type='text' value='" . $registro['codigo'] . "' required disabled>
														</div>
													</div>
													<div class='w3-row-padding w3-margin-bottom'>
														<div class='w3-quarter w3-right-align'><b>Nombre:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border' type='text' name='nombre' value='" . $registro['nombre'] . "' required maxlength='50' placeholder='Nombre del producto'>
														</div>
													</div>
													<div class='w3-row-padding w3-margin-bottom'>
														<div class='w3-quarter w3-right-align'><b>Marca:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border' type='text' name='marca' value='" . $registro['marca'] . "' required maxlength='50' placeholder='Marca del producto'>
														</div>
													</div>
													<div class='w3-row-padding w3-margin-bottom'>
														<div class='w3-quarter w3-right-align'><b>Precio:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border' type='number' name='precio' value='" . $registro['precio'] . "' required min='1' max='1000' placeholder='Precio del producto' onfocus=\"alerta('Moneda: MXN')\">
														</div>
													</div>
													<div class='w3-row-padding'>
														<div class='w3-quarter w3-right-align'><b>Stock:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border' type='number' name='stock' value='" . $registro['stock'] . "' required placeholder='Stock del producto' min='0' max='250'>
														</div>
													</div>												
												</div>

												<div class='w3-center'>
														<input type='text' name='tabla' value='productos' style='display:none;'>
														<input type='text' name='id' value='".$registro['codigo']."' style='display:none;'>
														<button type='submit' name='actualizar' class='w3-margin-top w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom'>ACTUALIZAR</button>				
												</div>
											</form>",
											"alerta", "no", "static");

										modal("eliminarProducto".$counter,
											"¿Seguro que deseas eliminar el siguiente producto?<br>
											<span class='w3-small'>¡Los datos no se podrán recuperar!</span>
											<div class='w3-border w3-round-medium w3-padding-small' style='display:block;margin:auto;width:70%;'>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Código:</b></div>
													<div class='w3-half'>" . $registro['codigo'] . "</div>
												</div>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Nombre:</b></div>
													<div class='w3-half'>" . $registro['nombre'] . "</div>
												</div>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Marca:</b></div>
													<div class='w3-half'>" . $registro['marca'] . "</div>
												</div>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Precio:</b></div>
													<div class='w3-half'>" . $registro['precio'] . "</div>
												</div>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Stock:</b></div>
													<div class='w3-half'>" . $registro['stock'] . "</div>
												</div>												
											</div>

											<div class='w3-center'>
												<form action='" . $raiz . "?pestaña=inventario&tab=productos' method='post'>
													<input type='text' name='tabla' value='productos' style='display:none;'>
													<input type='text' name='id' value='".$registro['codigo']."' style='display:none;'>
													<button type='submit' name='eliminar' class='w3-margin-top w3-border w3-white w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom'>ELIMINAR</button>
												</form>
											</div>",
											"error", "no");

										echo "<td class='w3-large'>";
											echo "<a class='w3-hover-opacity' href='javascript:void(0)' onclick='w3.show(\"#editarProducto".$counter."\")'><i class='fa fa-edit w3-text-blue w3-margin-right'></i></a>";
											echo "<a class='w3-hover-opacity' href='javascript:void(0)' onclick='w3.show(\"#eliminarProducto".$counter."\")'><i class='fa fa-trash w3-text-red'></i></a>";
										echo "</td>";
									echo "</tr>";															

									if($registro<1){
										echo "<tr><td colspan='6'>No hay registros</td></tr>";
									}else{
										$counter += 1;
									}
								}

								if($counter>=1){echo "<tr><td colspan='6'>Total registros: " . $counter . "</td><tr>";}								
							}catch(PDOException $e){
								$e = $e->getMessage();
								modal("errorInventario", "<b>Error en inventario->index.php: </b><br><tt>" . $e . "</tt>", "error");
						   		//Errores (Muestra donde se detiene)
						    }
						?>
					</table>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<?php
							modal("agregarProducto",
								"Agregar producto<br>
								<span class='w3-small'>¡Asegurate de hacer clic en agregar!</span>
								<form action='" . $raiz . "?pestaña=inventario&tab=productos' method='post'>
									<div class='w3-border w3-padding-large w3-round-medium' style='display:block;margin:auto;width:70%;'>
										<div class='w3-row-padding w3-margin-bottom'>
											<div class='w3-quarter w3-right-align'><b>Código:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='number' name='id' value='' required min='11111111' max='99999999' placeholder='C&oacute;digo de barras'>
											</div>
										</div>
										<div class='w3-row-padding w3-margin-bottom'>
											<div class='w3-quarter w3-right-align'><b>Nombre:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='text' name='nombre' value='' required maxlength='50' placeholder='Nombre del producto'>
											</div>
										</div>
										<div class='w3-row-padding w3-margin-bottom'>
											<div class='w3-quarter w3-right-align'><b>Marca:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='text' name='marca' value='' required maxlength='50' placeholder='Marca del producto'>
											</div>
										</div>
										<div class='w3-row-padding w3-margin-bottom'>
											<div class='w3-quarter w3-right-align'><b>Precio:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='number' name='precio' value='' required min='1' max='1000' placeholder='Precio del producto' onfocus=\"alerta('Moneda: MXN')\">
											</div>
										</div>
										<div class='w3-row-padding'>
											<div class='w3-quarter w3-right-align'><b>Stock:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='number' name='stock' value='' required placeholder='Stock del producto' min='0' max='250'>
											</div>
										</div>												
									</div>

									<div class='w3-center'>
											<input type='text' name='tabla' value='productos' style='display:none;'>
											<button type='submit' name='agregar' class='w3-margin-top w3-border w3-white w3-hover-green w3-button w3-round-medium w3-ripple w3-margin-bottom'>AGREGAR</button>				
									</div>
								</form>",
							"alerta", "no", "static");
						?>
					</div>
				</div>
			</div>

			<div id="materiales" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top hide">	
				<div class="w3-row w3-display-container">
					<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Materiales</h1>
					<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Materiales</p>
					<button style="right: 100px; top: 65px;" onclick="w3.show('#agregarMaterial'); alerta('Llene todos los campos')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-display-right"><i class="fa fa-plus"></i></button>
				</div>	

				<div class="w3-row w3-section">
					<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
					<div class="w3-rest">
						<input class="w3-input w3-border w3-large" oninput="w3.filterHTML('#tablaMateriales', '.trTablaMateriales', this.value)" type="text" placeholder="Buscar por datos de material">
					</div>
				</div>

				<div class="w3-row limit">									
					<table class="w3-table-all w3-centered w3-hoverable" id="tablaMateriales">
						<tr class="w3-light-grey">
							<th>ID</th>
							<th>Nombre</th>
							<th>Stock</th>
							<th>Precio</th>
							<th>Acciones</th>
						</tr>

						<?php
							try { //Implementación con PDO
							    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
							    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Tipo de concexión -> PDO				
							    $sql = "SELECT id_material, AES_DECRYPT(nombre, '$specialKey') nombre,  AES_DECRYPT(stock, '$specialKey') stock, AES_DECRYPT(precio, '$specialKey') precio FROM materiales ORDER BY id_material ASC";
							    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
							    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
							    #echo "Datos obtenidos correctamente. <br>";

							    $counter = 0;
							    
								foreach ($conn->query($sql) as $registro) {								
									echo "<tr class='w3-animate-opacity trTablaMateriales'>";
										echo "<td><b>" . $registro['id_material'] . "</b></td>";
										echo "<td>" . $registro['nombre'] . "</td>";
										if($registro['stock'] == 0){
											echo "<td><i class='fa fa-close w3-text-red'></i></td>";
										}elseif ($registro['stock'] > 0 & $registro['stock'] <= 10) {
											echo "<td>" . $registro['stock'] ." <i class='fa fa-exclamation w3-text-amber'></i></td>";
										}else{
											echo "<td>" . $registro['stock'] . "</td>";
										}
										echo "<td>$" . $registro['precio'] . "</td>";						

										modal("editarMaterial".$counter,
											"Editar datos del material<br>
											<span class='w3-small'>¡Asegurate de hacer clic en actualizar!</span>

											<form action='" . $raiz . "?pestaña=inventario&tab=materiales' method='post'>
												<div class='w3-border w3-padding-large w3-round-medium' style='display:block;margin:auto;width:70%;'>
													<div class='w3-row-padding w3-margin-bottom'>
														<div class='w3-quarter w3-right-align'><b>ID:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border w3-disabled' type='text' value='" . $registro['id_material'] . "' required disabled>
														</div>
													</div>
													<div class='w3-row-padding w3-margin-bottom'>
														<div class='w3-quarter w3-right-align'><b>Nombre:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border' type='text' name='nombre' value='" . $registro['nombre'] . "' required maxlength='50' placeholder='Nombre del material'>
														</div>
													</div>
													<div class='w3-row-padding w3-margin-bottom'>
														<div class='w3-quarter w3-right-align'><b>Stock:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border' type='number' name='stock' value='" . $registro['stock'] . "' required placeholder='Stock del material' min='0' max='250'>
														</div>
													</div>
													<div class='w3-row-padding'>
														<div class='w3-quarter w3-right-align'><b>Precio:</b></div>
														<div class='w3-threequarter'>
															<input class='w3-input w3-round-medium w3-border' type='number' name='precio' value='" . $registro['precio'] . "' required min='1' max='1000' placeholder='Precio del material' onfocus=\"alerta('Moneda: MXN')\">
														</div>
													</div>											
												</div>

												<div class='w3-center'>
														<input type='text' name='tabla' value='materiales' style='display:none;'>
														<input type='text' name='id' value='".$registro['id_material']."' style='display:none;'>
														<button type='submit' name='actualizar' class='w3-margin-top w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom'>ACTUALIZAR</button>				
												</div>
											</form>",
											"alerta", "no", "static");

										modal("eliminarMaterial".$counter,
											"¿Seguro que deseas eliminar el siguiente material?<br>
											<span class='w3-small'>¡Los datos no se podrán recuperar!</span>
											<div class='w3-border w3-round-medium w3-padding-small' style='display:block;margin:auto;width:70%;'>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>ID:</b></div>
													<div class='w3-half'>" . $registro['id_material'] . "</div>
												</div>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Nombre:</b></div>
													<div class='w3-half'>" . $registro['nombre'] . "</div>
												</div>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Stock:</b></div>
													<div class='w3-half'>" . $registro['stock'] . "</div>
												</div>
												<div class='w3-row-padding'>
													<div class='w3-half w3-right-align'><b>Precio:</b></div>
													<div class='w3-half'>" . $registro['precio'] . "</div>
												</div>									
											</div>

											<div class='w3-center'>
												<form action='" . $raiz . "?pestaña=inventario&tab=materiales' method='post'>
													<input type='text' name='tabla' value='materiales' style='display:none;'>
													<input type='text' name='id' value='".$registro['id_material']."' style='display:none;'>
													<button type='submit' name='eliminar' class='w3-margin-top w3-border w3-white w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom'>ELIMINAR</button>
												</form>
											</div>",
											"error", "no");

										echo "<td class='w3-large'>";
											echo "<a class='w3-hover-opacity' href='javascript:void(0)' onclick='w3.show(\"#editarMaterial".$counter."\")'><i class='fa fa-edit w3-text-blue w3-margin-right'></i></a>";
											echo "<a class='w3-hover-opacity' href='javascript:void(0)' onclick='w3.show(\"#eliminarMaterial".$counter."\")'><i class='fa fa-trash w3-text-red'></i></a>";
										echo "</td>";
									echo "</tr>";															

									if($registro<1){
										echo "<tr><td colspan='5'>No hay registros</td></tr>";
									}else{
										$counter += 1;
									}
								}

								if($counter>=1){echo "<tr><td colspan='5'>Total registros: " . $counter . "</td><tr>";}								
							}catch(PDOException $e){
								$e = $e->getMessage();
								modal("errorInventario", "<b>Error en inventario->index.php: </b><br><tt>" . $e . "</tt>", "error");
						   		//Errores (Muestra donde se detiene)
						    }
						?>
					</table>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<?php
							modal("agregarMaterial",
								"Agregar material<br>
								<span class='w3-small'>¡Asegurate de hacer clic en agregar!</span>
								<form action='" . $raiz . "?pestaña=inventario&tab=materiales' method='post'>
									<div class='w3-border w3-padding-large w3-round-medium' style='display:block;margin:auto;width:70%;'>
										<div class='w3-row-padding w3-margin-bottom'>
											<div class='w3-quarter w3-right-align'><b>Nombre:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='text' name='nombre' value='' required maxlength='50' placeholder='Nombre del producto'>
											</div>
										</div>
										<div class='w3-row-padding w3-margin-bottom'>
											<div class='w3-quarter w3-right-align'><b>Stock:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='number' name='stock' value='' required placeholder='Stock del producto' min='0' max='250'>
											</div>
										</div>
										<div class='w3-row-padding'>
											<div class='w3-quarter w3-right-align'><b>Precio:</b></div>
											<div class='w3-threequarter'>
												<input class='w3-input w3-round-medium w3-border' type='number' name='precio' value='' required min='1' max='1000' placeholder='Precio del producto' onfocus=\"alerta('Moneda: MXN')\">
											</div>
										</div>									
									</div>

									<div class='w3-center'>
											<input type='text' name='tabla' value='materiales' style='display:none;'>
											<button type='submit' name='agregar' class='w3-margin-top w3-border w3-white w3-hover-green w3-button w3-round-medium w3-ripple w3-margin-bottom'>AGREGAR</button>				
									</div>
								</form>",
							"alerta", "no", "static");
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>