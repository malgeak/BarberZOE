<!-- MOVIMIENTOS -->
<div id="movimientos" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top w3-margin-bottom hide">			
	<div class="w3-white w3-card-4 w3-margin-bottom">
		<div class="w3-row">
			<div class="w3-padding">
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Movimientos</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Movimientos</p>
			</div>
		</div>

		<div class="w3-row">
			<div class="w3-center w3-padding w3-block">
				<button onclick="w3.show('#ventas'); w3.hide('#gastos');" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs2">Ventas</button>
				<button onclick="w3.show('#gastos'); w3.hide('#ventas');" class="w3-border w3-red w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom tabs2">Gastos</button>
			</div>
		</div>
	</div>

	<!-- VENTAS -->
	<div class="w3-white w3-card-4 w3-margin-top">
		<div class="w3-row">
			<div id="ventas" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top hide">	
				<div class="w3-row w3-display-container w3-center">
					<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registros de ventas</h1>
					<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registros de ventas</p>

					<button style="right: 100px; top: 65px;" onclick="w3.show('#agregarVenta'); SetDate();" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-display-right"><i class="fa fa-plus"></i></button>
				</div>

				<div class="w3-row w3-section">
					<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
					<div class="w3-rest">
						<input class="w3-input w3-border w3-large" type="text" oninput="w3.filterHTML('#tablaVentas', '.trTablaVentas', this.value)" placeholder="Buscar por datos de venta">
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
							<th>Acciones</th>
						</tr>

						<?php
							try { //Implementación con PDO
							    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
							    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Tipo de conexión -> PDO				
							    $sql = "SELECT id_venta, fecha, AES_DECRYPT(costo_total, '$specialKey') costo_total, descuento, AES_DECRYPT(descripcion, '$specialKey') descripcion, AES_DECRYPT(hora, '$specialKey') hora FROM ventas ORDER BY id_venta DESC";
							    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
							    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
							    #echo "Datos obtenidos correctamente. <br>";

							    $counter = 0;
							    $describe = "";
							    
								foreach ($conn->query($sql) as $registro) {	
									echo "<tr class='w3-animate-opacity trTablaVentas'>";
										echo "<td><b>" . $registro['id_venta'] . "</b></td>";
										echo "<td>" . $registro['fecha'] . "</td>";
										echo "<td>" . $registro['hora'] . "</td>";
										if(empty($registro['descuento'])){
											echo "<td>--------</td>";
										}else{
											echo "<td>" . $registro['descuento'] . "%</td>";
										}										
										echo "<td>$" . $registro['costo_total'] . "</td>";
										$describe = $registro['descripcion'];
										$describe = str_replace(";","</td>",$describe);	
										$describe = str_replace(",","<br>",$describe);
										$describe = str_replace("[","<td><button onclick=\"windowOpen('".$raiz."imprimir.php?id_venta=".$registro['id_venta']."');return false\" class=\"w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom\"><i class='fa fa-print'></i></button><span class='w3-hide'>",$describe);	
										$describe = str_replace("]","</b></span>",$describe);
										echo "<td>" . $describe;										
										$counter += 1;
									echo "</tr>";	
								}

								if($counter>=1){
									echo "<tr><td colspan='7'>Total registros: " . $counter . "</td><tr>";
								}else{
									echo "<tr><td colspan='7'>No hay registros</td></tr>";	
								}
							}catch(PDOException $e){
								$e = $e->getMessage();
								modal("errorInventario", "<b>Error en inventario->index.php: </b><br><tt>" . $e . "</tt>", "error");
						   		//Errores (Muestra donde se detiene)
						    }
						?>
					</table>
				</div>			

				<?php
					modal("agregarVenta",
						"Agregar venta<br>
						<span class='w3-small'>¡Asegurate de hacer clic en agregar!</span>
						<form id='agregarVentaForm' action='" . $raiz . "?pestaña=movimientos&tab=ventas' method='post'>
							<div class='w3-border w3-padding-large w3-round-medium' style='display:block;margin:auto;width:70%;'>
								<div class='w3-row-padding w3-margin-bottom'>
									<div class='w3-quarter w3-right-align'><b>Fecha:</b></div>
									<div class='w3-threequarter'>
										<input class='w3-input w3-round-medium w3-border' type='date' id='dateToday' readonly name='fecha' style='cursor: not-allowed;'>
									</div>
								</div>
								<div class='w3-row-padding w3-margin-bottom'>
									<div class='w3-quarter w3-right-align'><b>Hora:</b></div>
									<div class='w3-threequarter'>
										<input class='w3-input w3-round-medium w3-border' type='time' id='timeNow' readonly style='cursor: not-allowed;' name='hora'>
									</div>
								</div>								
								<div class='w3-row-padding w3-margin-bottom'>
									<div class='w3-quarter w3-right-align'><b>Descripción:</b></div>
									<div class='w3-threequarter'>
										<button type='button' onclick='w3.show(\"#seleccionarProductos\")' class='w3-border w3-block w3-white w3-hover-blue w3-button w3-round-medium w3-ripple'>SELECCIONAR PRODUCTOS</button>
									</div>
								</div>
								<div class='w3-row-padding'>
									<div class='w3-quarter w3-right-align'><b>Descuento:</b></div>
									<div class='w3-threequarter'>
										<input class='w3-input w3-round-medium w3-border' type='number' name='descuento' value='' min='0' max='100' placeholder='Descuento de esta venta'>
									</div>
								</div>												
							</div>

							<div class='w3-center'>
								<input type='text' name='tabla' value='ventas' style='display:none;'>
								<button type='submit' name='agregar' class='w3-margin-top w3-border w3-white w3-hover-green w3-button w3-round-medium w3-ripple w3-margin-bottom'>AGREGAR</button>				
							</div>
						</form>",
					"alerta", "no", "static");
				?>

				<div id="seleccionarProductos" class="w3-modal w3-animate-opacity">
					<div class="w3-modal-content w3-display-middle w3-padding w3-margin-bottom w3-margin-top" style="border-radius: 32px 0px 32px 32px;">
						<div class="w3-container w3-large w3-padding-24">
							<span onclick="w3.hide('#seleccionarProductos');" class="w3-button w3-blue w3-hover-opacity w3-display-topright w3-xlarge" title="Cerrar ventana"><i class="fa fa-check"></i></span>
							<p class="w3-center">
							<i class='fa fa-exclamation-triangle w3-text-yellow'></i>
							Seleccionar productos para venta<br>
							<span class='w3-small'>¡Asegurate de seleccionar el producto y colocar la cantidad!</span>

							<div class="w3-row w3-section">
								<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
								<div class="w3-rest">
									<input class="w3-input w3-border w3-large" oninput="w3.filterHTML('#tablaProductos2', '.trTablaProductos2', this.value)" type="text" placeholder="Buscar por datos de producto">
								</div>
							</div>

							<div class='w3-row-padding w3-margin-bottom w3-round-medium'>
								<div class="w3-row limit">									
									<table class="w3-table-all w3-centered w3-hoverable" id="tablaProductos2">
										<tr class="w3-light-grey">
											<th>Código <i class="fa fa-barcode"></i></th>
											<th>Nombre</th>
											<th>Marca</th>
											<th>Precio</th>
											<th>Unidades</th>
											<th>Seleccionar</th>
										</tr>

										<?php
											$localCheckbox = 0;

											try { //Implementación con PDO
											    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
											    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Tipo de conexión -> PDO				
											    $sql = "SELECT codigo, AES_DECRYPT(nombre, '$specialKey') nombre, AES_DECRYPT(marca, '$specialKey') marca, AES_DECRYPT(precio, '$specialKey') precio, AES_DECRYPT(stock, '$specialKey') stock FROM productos ORDER BY nombre ASC";
											    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
											    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
											    #echo "Datos obtenidos correctamente. <br>";

												foreach ($conn->query($sql) as $registro) {								
													echo "<tr class='w3-animate-opacity trTablaProductos2'>";
														echo "<td><b>" . $registro['codigo'] . "</b></td>";
														echo "<td>" . $registro['nombre'] . "</td>";
														echo "<td>" . $registro['marca'] . "</td>";
														echo "<td>$" . $registro['precio'] . "</td>";
														if($registro['stock'] == 0){
															echo "<td><i class='fa fa-close w3-text-red'></i></td>";
															$localCheckbox = 1;
														}else{
															if($registro['stock']<=10){
																echo "<td class='w3-display-container'><span class='w3-display-topright w3-badge w3-circle w3-yellow w3-tiny w3-padding-small'>".$registro['stock']."</span><input form='agregarVentaForm' class='w3-input w3-border w3-large' type='number' min='1' max='" . $registro['stock'] . "' name='cantidad[".$registro['codigo']."]' placeholder='Unidades' id='field".$registro['codigo']."' disabled></td>";
															}else{
																echo "<td class='w3-display-container'><span class='w3-display-topright w3-badge w3-circle w3-blue w3-tiny w3-padding-small'>".$registro['stock']."</span><input form='agregarVentaForm' class='w3-input w3-border w3-large' type='number' min='1' max='" . $registro['stock'] . "' name='cantidad[".$registro['codigo']."]' placeholder='Unidades' id='field".$registro['codigo']."' disabled></td>";	
															}
															
															$localCheckbox = 0;
														}

														echo "<td class='w3-large'>";
														if($localCheckbox==0){
															echo "<input class='w3-check' form='agregarVentaForm' type='checkbox' name='selected[".$registro['codigo']."]' value='" . $registro['codigo'] . "' id='check".$registro['codigo']."' onclick=\"checkField('check".$registro['codigo']."', 'field".$registro['codigo']."');\"";
														}else{
															echo "<i class='fa fa-close w3-text-red'></i>";
														}
														echo "</td>";
													echo "</tr>";															

													if($registro<1){
														echo "<tr><td colspan='6'>No hay registros</td></tr>";
													}
												}							
											}catch(PDOException $e){
												$e = $e->getMessage();
												modal("errorInventario", "<b>Error en movimientos.php: </b><br><tt>" . $e . "</tt>", "error");
										   		//Errores (Muestra donde se detiene)
										    }
										?>
									</table>
								</div>
							</div>
							</p>
						</div>
					</div>
				</div>

				<div id="imprimirVenta" class="w3-modal w3-animate-opacity">
					<div class="w3-modal-content w3-display-middle w3-padding w3-margin-bottom w3-margin-top" style="border-radius: 32px 0px 32px 32px;">
						<div class="w3-container w3-large w3-padding-24">
							<span onclick="w3.hide('#imprimirVenta');" class="w3-button w3-red w3-hover-opacity w3-display-topright w3-xlarge" title="Cerrar ventana">&times;</span>
							<p class="w3-center">
							<i class='fa fa-exclamation-triangle w3-text-yellow'></i>
							Seleccionar una fecha de ventas<br>
							<span class='w3-small'>No selecciones alguna para imprimir todos los registros</span>
							<form class="w3-row-padding w3-margin-bottom w3-round-medium w3-center" action="<?php echo $raiz."imprimir.php";?>" method="get">
								<?php
									try { //Implementación con PDO
									    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
									    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Tipo de conexión -> PDO				
									    $sql = "SELECT DISTINCT fecha FROM ventas ORDER BY fecha DESC";
									    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
									    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
									    #echo "Datos obtenidos correctamente. <br>";
									    
									    echo "<select name='fecha' class='w3-border w3-white w3-button w3-round-medium w3-ripple w3-margin-bottom'>";
									    echo "<option value='indefinida' selected>Elige una fecha</option>";
										foreach ($conn->query($sql) as $registro) {
											echo "<option value='".$registro['fecha']."'>";
												echo $registro['fecha'];
											echo "</option>";	
										}
										echo "</select><br>";		
									}catch(PDOException $e){
										$e = $e->getMessage();
										modal("errorImpresiones", "<b>Error en movimientos.php: </b><br><tt>" . $e . "</tt>", "error");
								   		//Errores (Muestra donde se detiene)
								    }
								?>
								<input type='text' name='tabla' value='ventas' style='display:none;'>
								<button onclick="windowOpen('<?php echo $raiz."imprimir.php";?>');return false" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom" type='submit'>Imprimir</button>
							</form>
							</p>
						</div>
					</div>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<button onclick="w3.show('#imprimirVenta');" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Imprimir</button>			
					</div>
				</div>
			</div>
			
			<!-- GASTOS -->
			<div id="gastos" class="w3-animate-opacity w3-content w3-padding-large w3-margin-top hide">	
				<div class="w3-row w3-display-container w3-center">
					<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Registros de gastos</h1>
					<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Registros de gastos</p>

					<button style="right: 100px; top: 65px;" onclick="w3.show('#agregarGasto'); SetDate();" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-display-right"><i class="fa fa-plus"></i></button>
				</div>

				<div class="w3-row w3-section">
					<div class="w3-hide-small w3-col" style="width:50px"><i class="w3-xxlarge fa fa-search"></i></div>
					<div class="w3-rest">
						<input class="w3-input w3-border w3-large" type="text" oninput="w3.filterHTML('#tablaGastos', '.trTablaGastos', this.value)" placeholder="Buscar por datos de gasto">
					</div>
				</div>

				<div class="w3-row limit">									
					<table class="w3-table-all w3-centered w3-hoverable" id="tablaGastos">
						<tr class="w3-light-grey">
							<th>ID</th>
							<th>Fecha</th>
							<th>Total</th>
							<th>Descripción</th>
							<th>Acciones</th>
						</tr>

						<?php
							$counter = 0;

							try { //Implementación con PDO
							    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
							    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Tipo de conexión -> PDO				
							    $sql = "SELECT id_gasto, fecha, AES_DECRYPT(costo_total, '$specialKey') costo_total, AES_DECRYPT(descripcion, '$specialKey') descripcion FROM gastos ORDER BY id_gasto DESC";
							    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
							    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
							    #echo "Datos obtenidos correctamente. <br>";
							    
								foreach ($conn->query($sql) as $registro) {	
									echo "<tr class='w3-animate-opacity trTablaGastos'>";
										echo "<td><b>" . $registro['id_gasto'] . "</b></td>";
										echo "<td>" . $registro['fecha'] . "</td>";
										echo "<td>$" . $registro['costo_total'] . "</td>";					
										echo "<td>" . $registro['descripcion'] . "</td>";
										echo "<td><button onclick=\"windowOpen('".$raiz."imprimir.php?id_gasto=".$registro['id_gasto']."');return false\" class=\"w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom\"><i class='fa fa-print'></i></button></td>";
									echo "</tr>";

									$counter+=1;
								}

								if($counter>=1){
									echo "<tr><td colspan='5'>Total registros: " . $counter . "</td><tr>";
								}else{
									echo "<tr><td colspan='5'>No hay registros</td></tr>";	
								}
							}catch(PDOException $e){
								$e = $e->getMessage();
								modal("errorInventario", "<b>Error en inventario->index.php: </b><br><tt>" . $e . "</tt>", "error");
						   		//Errores (Muestra donde se detiene)
						    }
						?>
					</table>
				</div>

				<?php
					modal("agregarGasto",
						"Agregar gasto<br>
						<span class='w3-small'>¡Asegurate de hacer clic en agregar!</span>
						<form action='" . $raiz . "?pestaña=movimientos&tab=gastos' method='post'>
							<div class='w3-border w3-padding-large w3-round-medium' style='display:block;margin:auto;width:70%;'>
								<div class='w3-row-padding w3-margin-bottom'>
									<div class='w3-quarter w3-right-align'><b>Fecha:</b></div>
									<div class='w3-threequarter'>
										<input class='w3-input w3-round-medium w3-border' type='date' id='dateToday2' name='fecha'>
									</div>
								</div>						
								<div class='w3-row-padding w3-margin-bottom'>
									<div class='w3-quarter w3-right-align'><b>Total:</b></div>
									<div class='w3-threequarter'>
										<input class='w3-input w3-round-medium w3-border' type='number' name='precio' value='' required min='1' max='10000' placeholder='Total de gasto'>
									</div>
								</div>	
								<div class='w3-row-padding'>
									<div class='w3-quarter w3-right-align'><b>Descripción:</b></div>
									<div class='w3-threequarter'>
										<input class='w3-input w3-round-medium w3-border' type='text' name='descripcion' value='' required placeholder='Descripción del gasto'>
									</div>
								</div>												
							</div>

							<div class='w3-center'>
								<input type='text' name='tabla' value='gastos' style='display:none;'>
								<button type='submit' name='agregar' class='w3-margin-top w3-border w3-white w3-hover-green w3-button w3-round-medium w3-ripple w3-margin-bottom'>AGREGAR</button>				
							</div>
						</form>",
					"alerta", "no", "static");
				?>

				<div id="imprimirGasto" class="w3-modal w3-animate-opacity">
					<div class="w3-modal-content w3-display-middle w3-padding w3-margin-bottom w3-margin-top" style="border-radius: 32px 0px 32px 32px;">
						<div class="w3-container w3-large w3-padding-24">
							<span onclick="w3.hide('#imprimirGasto');" class="w3-button w3-red w3-hover-opacity w3-display-topright w3-xlarge" title="Cerrar ventana">&times;</span>
							<p class="w3-center">
							<i class='fa fa-exclamation-triangle w3-text-yellow'></i>
							Seleccionar una fecha de gastos<br>
							<span class='w3-small'>No selecciones alguna para imprimir todos los registros</span>
							<form class="w3-row-padding w3-margin-bottom w3-round-medium w3-center" action="<?php echo $raiz."imprimir.php";?>" method="get">
								<?php
									try { //Implementación con PDO
									    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
									    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Tipo de conexión -> PDO				
									    $sql = "SELECT DISTINCT fecha FROM gastos ORDER BY fecha DESC";
									    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
									    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
									    #echo "Datos obtenidos correctamente. <br>";
									    
									    echo "<select name='fecha' class='w3-border w3-white w3-button w3-round-medium w3-ripple w3-margin-bottom'>";
									    echo "<option value='indefinida' selected>Elige una fecha</option>";
										foreach ($conn->query($sql) as $registro) {
											echo "<option value='".$registro['fecha']."'>";
												echo $registro['fecha'];
											echo "</option>";	
										}
										echo "</select><br>";		
									}catch(PDOException $e){
										$e = $e->getMessage();
										modal("errorImpresiones", "<b>Error en movimientos.php: </b><br><tt>" . $e . "</tt>", "error");
								   		//Errores (Muestra donde se detiene)
								    }
								?>
								<input type='text' name='tabla' value='gastos' style='display:none;'>
								<button onclick="windowOpen('<?php echo $raiz."imprimir.php";?>');return false" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom" type='submit'>Imprimir</button>					
							</form>
							</p>
						</div>
					</div>
				</div>

				<div class="w3-row w3-margin-top">
					<div class="w3-center w3-padding w3-block w3-margin-top">
						<button onclick="w3.show('#imprimirGasto');" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom" type='submit'>Imprimir</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>