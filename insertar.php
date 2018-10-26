<?php
	include "config.php";

	/*
		$tabla -> productos / materiales / ventas / gastos / eventos
		$tipo -> (1,2,3,4,5) -> Menu
		$conexion -> conexion de query con BD
		$query -> consulta / insercion / eliminacion
		$resultado -> resultado de query
		$counts -> Total de seleccionados
		$elegidos[x] -> $_POST['selected'] -> array checkboxes
		$i -> Bucle -> Todos los registros -> Index arrays
	*/

	switch ($tipo) {
		case 1: //Insertar en productos
			$query = "INSERT INTO $tabla(fkinventario, pkserial, nombre, marca, precio, stock) VALUES ($tipo, $place, '$nombre', '$marca', $precio, $stock)"; //Inserta datos
			$resultado = pg_query($conexion, $query) or die("Error al insertar registros a productos");
			echo "Se insertó en la tabla ".$tabla.", el elemento con el ID ".$place.".";
			redireccionar("?pestaña=inventario&tab=productos"); //Pestaña+subpestaña
			break;

		case 2: //Insertar en materiales
			$query = "INSERT INTO $tabla(fkinventario, pkserial, nombre, marca, precio, stock) VALUES ($tipo, $place, '$nombre', '$marca', $precio, $stock)"; //Inserta datos
			$resultado = pg_query($conexion, $query) or die("Error al insertar registros a materiales");
			echo "Se insertó en la tabla ".$tabla.", el elemento con el ID ".$place.".";
			redireccionar("?pestaña=inventario&tab=materiales"); //Pestaña+subpestaña
			break;

		case 3: //Insertar en ventas
			$query = "SELECT * FROM productos ORDER BY pkserial ASC"; //Obtener el ultimo ID
			$resultado = pg_query($conexion, $query) or die("Error al obtener datos en productos");
			$numRows = pg_num_rows($resultado);
			if($numRows>0){
				while ($fila=pg_fetch_array($resultado)) {
					$lastId = $fila['pkserial'];
				}
			}else{
				$lastId=0;
			}

			if(empty($elegidos)){ //En caso de no elegir alguno para venta
				echo "¡No se ha seleccionado nada!";
				redireccionar("");
			}else{
				$counts = count($elegidos); //Cuenta los seleccionados
				$descripcion = $counts . " productos.<br>";

				for($i=0; $i < $counts; $i++){ //El $elegidos[$i] seleccionado es el pkserial
					$query = "SELECT * FROM productos WHERE pkserial=$elegidos[$i]";
					$resultado = pg_query($conexion, $query) or die("Error al obtener datos de productos para venta");					
					while ($fila=pg_fetch_array($resultado)) {
						$placeTable =  $fila['pkserial'];
						if(empty($cantidad[$placeTable])){
							echo "¡No se ha seleccionado una cantidad!";
						}else{
							$costoProducto = $cantidad[$placeTable] * $fila['precio']; //Prods * precio
							$costoTotal += $costoProducto; //Precio final

							$newStock = $fila['stock'] - $cantidad[$placeTable];					
							$query = "UPDATE productos SET stock=$newStock WHERE pkserial=$placeTable";
							$resultado = pg_query($conexion, $query) or die("Error al actualizar stock");

							$descripcion = $descripcion . $fila['nombre'] . " [" . $fila['marca'] . "], " . $cantidad[$placeTable] . " unidades.<br>";
						}						
					}
				}

				if($descuento>0){
					$desc = $descuento/100;
					$nuevoCosto = $costoTotal * $desc;
					$costoFinal = $costoTotal - $nuevoCosto;
				}else{
					$descuento = 0;
					$costoFinal = $costoTotal;
				}

				$query = "INSERT INTO ventas VALUES ('$fecha', $costoFinal, $descuento, '$descripcion', $place, '$hora')";
				$resultado = pg_query($conexion, $query) or die("Error al insertar datos en ventas");
				echo "Se insertó en la tabla ".$tabla.", el elemento con el ID ".$place.", ";
				echo $descripcion.".";
				redireccionar("?pestaña=movimientos&tab=ventas"); //Pestaña+subpestaña
			}
			break;

		case 4: //Insertar en gastos
			$query = "INSERT INTO $tabla VALUES ('$fecha', $precio, $place, '$descripcion')"; //Inserta datos
			$resultado = pg_query($conexion, $query) or die("Error al insertar registro a gastos");
			echo "Se insertó en la tabla ".$tabla.", el elemento con el ID ".$place.".";
			redireccionar("?pestaña=movimientos&tab=gastos"); //Pestaña+subpestaña
			break;

		case 5: //Insertar en eventos
			$query = "INSERT INTO $tabla VALUES ($place, '$registro', '$nombre', '$tipoE', '$descripcion', '$fecha')"; //Inserta datos
			$resultado = pg_query($conexion, $query) or die("Error al insertar registro a eventos");
			echo "Se insertó en la tabla ".$tabla.", el elemento con el ID ".$place.".";
			redireccionar("?pestaña=agenda"); //Pestaña
			break;
		
		default:
			pg_close($conexion);
			break;
	}
?>