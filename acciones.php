<?php
	try { //Implementación con PDO
	    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Tipo de conexión -> PDO
	    #echo "Se conectó correctamente con la BD. <br>";

	    if (isset($_POST['agregar'])) { //Al hacer clic en algun boton para agregar
	    	#Limpia todos los elementos posibles -> Obtiene de $_POST['elemento']
	    	if(empty($_POST["id"])){$id = null;}else{$id = $_POST["id"]; /*Id*/}
			if(empty($_POST["nombre"])){$nombre = null;}else{$nombre = test_input($_POST["nombre"]); /*Nombre*/}
			if(empty($_POST["marca"])){$marca = null;}else{$marca = test_input($_POST["marca"]); /*Marca*/}
			if(empty($_POST["precio"])){$precio = null;}else{$precio = $_POST["precio"]; /*Precio(s)*/}
			if(empty($_POST["descuento"])){$descuento = null;}else{$descuento = $_POST["descuento"]; /*descuento*/}
			if(empty($_POST["stock"])){$stock = null;}else{$stock = $_POST["stock"]; /*Stock*/}
			if(empty($_POST["tabla"])){$tabla = null; $tipo=null;}else{$tabla = $_POST["tabla"]; /*Tabla*/}
			if(empty($_POST['selected'])){$elegidos=null;}else{$elegidos = $_POST['selected']; /*Crea array con los checkbox seleccionados*/}
			if(empty($_POST["cantidad"])){$cantidad = null;}else{$cantidad = $_POST["cantidad"]; /*Cantidades*/}
			if(empty($_POST["fecha"])){$fecha = null;}else{$fecha = $_POST["fecha"]; /*Fecha*/}
			if(empty($_POST["hora"])){$hora = null;}else{$hora = $_POST["hora"]; /*Hora*/}
			if(empty($_POST["descripcion"])){$descripcion = null;}else{$descripcion = $_POST["descripcion"]; /*descuento*/}

			if ($tabla == "productos") {
				$sql = "INSERT INTO productos VALUES (?, ?, AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'))";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([1, $id, $marca, $nombre, $stock, $precio]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Insertado el registro en la tabla productos correctamente. <br>";

			    $sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute(["Productos", "Se insert&oacute; un registro."]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Registro guardado correctamente.";

			    modal("registroAgregado", "El registro fue agregado.", "correcto");
			}elseif ($tabla == "materiales") { //CORREGIR -> Al insertar registros con ID faltantes ente 0 y N dice que esta duplicado
				$sql = "INSERT INTO materiales(id_inventario, nombre, stock, precio) VALUES (?, AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'))";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([2, $nombre, $stock, $precio]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Insertado el registro en la tabla productos correctamente. <br>";

			    $sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute(["Productos", "Se insert&oacute; un registro."]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Registro guardado correctamente.";

			    modal("registroAgregado", "El registro fue agregado.", "correcto");
			}elseif ($tabla == "ventas") {
				if(empty($elegidos)){ //En caso de no elegir alguno para venta
					modal("sinDatos", "¡No se ha seleccionado nada!", "error");
				}else{
					$counts = count($elegidos); //Cuenta los seleccionados
					if($counts==1){
						$descripcion = $counts . " producto vendido;[";
					}else{
						$descripcion = $counts . " productos vendidos;[";
					}
					
					$totalSinDescuento = 0;	
					$totalConDescuento = 0;
					$desc = $newStock = 0;
					$costoTotalProducto = 0;

					foreach ($elegidos as $elegido) {						
						$sql = "SELECT codigo, AES_DECRYPT(nombre, '$specialKey') nombre, AES_DECRYPT(marca, '$specialKey') marca, AES_DECRYPT(precio, '$specialKey') precio, AES_DECRYPT(stock, '$specialKey') stock FROM productos WHERE codigo = $elegido"; //Buscamos el precio del producto seleccionado
					    $stmt=$conn->prepare($sql);
					    $stmt->execute();
					    foreach ($conn->query($sql) as $prod) {
					    	$precioProducto = $prod['precio'];					    	
					    }					    
				    	//Ahora debemos calcular el total sin el descuento de venta cantidad * precio (SUMATORIA)
				    	$costoTotalProducto = $cantidad[$elegido] * $precioProducto; //Guardamos el costo total de prod.					
				    	$descripcion .= "(Código: " . $prod['codigo'] . ",Nombre: " . $prod['nombre'] . ",Marca: " . $prod['marca'] . ",Costo: $";
						$totalSinDescuento = $totalSinDescuento + ($cantidad[$elegido] * $precioProducto); //Lo añadimos al total de la venta
						$descripcion .= $costoTotalProducto . ", Unidades: " . $cantidad[$elegido] . ")";

						$newStock = $prod['stock'] - $cantidad[$elegido];

						//Actualizamos los datos de stock de los productos vendidos
						$sql = "UPDATE productos SET stock=AES_ENCRYPT(?, '$specialKey') WHERE codigo=$elegido";
					    $stmt=$conn->prepare($sql);
					    $stmt->execute([$newStock]);
					}

					//Para muestra de datos
					$descripcion .= "]";

					if(empty($descuento)){ //No se agregó descuento
						$totalConDescuento = $totalSinDescuento;
					}else{ //Descuento
						$desc = $descuento/100; //local
						$totalConDescuento = $totalSinDescuento * $desc;
						$totalConDescuento = $totalSinDescuento - $totalConDescuento;
					}

					$sql = "INSERT INTO ventas (fecha, costo_total, descuento, descripcion, hora) VALUES (?, AES_ENCRYPT(?, '$specialKey'), ?, AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'))";
				    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
				    $stmt->execute([$fecha, $totalConDescuento, $descuento, $descripcion, $hora]);
				}

				$sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute(["Ventas", "Se insert&oacute; un registro."]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Registro guardado correctamente.";

			    modal("registroAgregado", "El registro fue agregado.", "correcto");
			}elseif ($tabla == "gastos") {
				$sql = "INSERT INTO gastos(fecha, costo_total, descripcion) VALUES (?, AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'))";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$fecha, $precio, $descripcion]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Insertado el registro en la tabla productos correctamente. <br>";

			    $sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute(["Gastos", "Se insert&oacute; un registro."]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Registro guardado correctamente.";

			    modal("registroAgregado", "El registro fue agregado.", "correcto");
			}elseif ($tabla == "eventos") {
				$tipo = "id_evento";

				modal("registroAgregado", "El registro fue agregado. ONCHECK", "correcto");
			}
		}

		if (isset($_POST['eliminar'])) { //Al hacer clic en algun boton de eliminar
			#Limpia todos los elementos posibles -> Obtiene de $_POST['elemento']
			if(empty($_POST["id"])){$id = null;}else{$id = $_POST["id"]; /*Id*/}
			if(empty($_POST["tabla"])){$tabla = null; $tipo=null;}else{$tabla = $_POST["tabla"]; /*Tabla*/}
			if ($tabla == "productos") {
				$tipo = "codigo";
			}elseif ($tabla == "materiales") {
				$tipo = "id_material";
			}elseif ($tabla == "ventas") {
				$tipo = "id_venta";
			}elseif ($tabla == "gastos") {
				$tipo = "id_gasto";
			}elseif ($tabla == "eventos") {
				$tipo = "id_evento";
			}

			$sql = "DELETE FROM $tabla WHERE $tipo=$id";
		    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
		    $stmt->execute(); //Ejecutamos el SQL con los datos a guardar
		    #echo "Eliminado el registro en la tabla correctamente. <br>";

		    $sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
		    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
		    $stmt->execute([$tabla, "Se elimin&oacute; un registro."]); //Ejecutamos el SQL con los datos a guardar
		    #echo "Registro eliminado correctamente.";

			modal("registroEliminado", "El registro fue eliminado.", "correcto");	
		}

		if (isset($_POST['actualizar'])) { //Al hacer clic en algun boton de actualizar
			#Limpia todos los elementos posibles -> Obtiene de $_POST['elemento']
			if(empty($_POST["id"])){$id = null;}else{$id = $_POST["id"]; /*Id*/}
			if(empty($_POST["nombre"])){$nombre = null;}else{$nombre = test_input($_POST["nombre"]); /*Nombre*/}
			if(empty($_POST["marca"])){$marca = null;}else{$marca = test_input($_POST["marca"]); /*Marca*/}
			if(empty($_POST["precio"])){$precio = null;}else{$precio = $_POST["precio"]; /*Precio*/}
			if(empty($_POST["stock"])){$stock = null;}else{$stock = $_POST["stock"]; /*Stock*/}
			if(empty($_POST["tabla"])){$tabla = null; $tipo=null;}else{$tabla = $_POST["tabla"]; /*Tabla*/}

			if ($tabla == "productos") {
				$tipo = "codigo";
			}elseif ($tabla == "materiales") {
				$tipo = "id_material";
			}elseif ($tabla == "ventas") {
				$tipo = "id_venta";
			}elseif ($tabla == "gastos") {
				$tipo = "id_gasto";
			}elseif ($tabla == "eventos") {
				$tipo = "id_evento";
			}

			if($tabla == "productos"){
		    	$sql = "UPDATE $tabla SET nombre=AES_ENCRYPT(?, '$specialKey') WHERE $tipo=$id";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$nombre]); //Ejecutamos el SQL con los datos a guardar

			    $sql = "UPDATE $tabla SET marca=AES_ENCRYPT(?, '$specialKey') WHERE $tipo=$id";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$marca]); //Ejecutamos el SQL con los datos a guardar

			    $sql = "UPDATE $tabla SET precio=AES_ENCRYPT(?, '$specialKey') WHERE $tipo=$id";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$precio]); //Ejecutamos el SQL con los datos a guardar

			    $sql = "UPDATE $tabla SET stock=AES_ENCRYPT(?, '$specialKey') WHERE $tipo=$id";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$stock]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Actualizado el registro en la tabla correctamente. <br>";
		    }else if($tabla == "materiales"){
		    	$sql = "UPDATE $tabla SET nombre=AES_ENCRYPT(?, '$specialKey') WHERE $tipo=$id";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$nombre]); //Ejecutamos el SQL con los datos a guardar

			    $sql = "UPDATE $tabla SET stock=AES_ENCRYPT(?, '$specialKey') WHERE $tipo=$id";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$stock]); //Ejecutamos el SQL con los datos a guardar
			    #echo "Actualizado el registro en la tabla correctamente. <br>";

			    $sql = "UPDATE $tabla SET precio=AES_ENCRYPT(?, '$specialKey') WHERE $tipo=$id";
			    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
			    $stmt->execute([$precio]); //Ejecutamos el SQL con los datos a guardar		    
		    }					

		    $sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
		    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
		    $stmt->execute([$tabla, "Se actualiz&oacute; un registro."]); //Ejecutamos el SQL con los datos a guardar
		    #echo "Registro actualizado correctamente.";

			modal("registroActualizado", "El registro fue actualizado.", "correcto");
		}
	}catch(PDOException $e){
		$e = $e->getMessage();
		if (strpos($e, 'Duplicate entry') !== false) {
			modal('productoDuplicado', 'Parece que este registro ya existe.', 'error');
		}else{
			modal("errorAcciones", "<b>Error en acciones.php: </b><br><tt>" . $e . "</tt>", "error");
		}		
   		//Errores (Muestra donde se detiene)
    }
?>