<?php
	include "config.php";

	/*
		$tabla -> productos / materiales
		$conexion -> conexion de query con BD
		$query -> consulta / insercion / eliminacion
		$resultado -> resultado de query
		$totalRegs -> Total de registros en tabla
		$place[x] -> $_POST['id'] -> array id fila
		$precios[x] -> $_POST['precio'] -> array contenedores precio
		$stocks[x] -> $_POST['stock'] -> array contenedores stock
		$i -> Bucle -> Todos los registros -> Index arrays
	*/

	$query = "SELECT * FROM $tabla ORDER BY pkserial ASC";
	$resultado = pg_query($conexion, $query) or die ("Error al obtener datos en productos");
	$totalRegs = pg_num_rows($resultado); //Total registros leidos de la BD

	if(empty($_POST['precio']) || empty($_POST['stock'])){ //En caso de no tener registros
		echo "¡No se ha actualizado nada!";
	}else{
		echo "Toda la tabla se ha actualizado.<br>";
		for($i=0; $i < $totalRegs; $i++){ //El id seleccionado es el actualizado
			$query = "UPDATE $tabla SET precio=$precios[$i] WHERE pkserial=$place[$i]"; //El mismo id del post			
			$resultado = pg_query($conexion, $query) or die ("Error al actualizar precios");
			echo "De la tabla ".$tabla.", el elemento con el ID ".$place[$i].", el precio ahora es:".$precios[$i].".<br>";

			$query = "UPDATE $tabla SET stock=$stocks[$i] WHERE pkserial=$place[$i]"; //El mismo id del post
			$resultado = pg_query($conexion, $query) or die("Error al actualizar stock");
			echo "De la tabla ".$tabla.", el elemento con el ID ".$place[$i].", el stock ahora es:".$stocks[$i].".<br>";
		}
	}
	pg_close($conexion);	

	if($tabla=="productos"){
		redireccionar("?pestaña=inventario&tab=productos"); //Pestaña+subpestaña
	}else if($tabla=="materiales"){
		redireccionar("?pestaña=inventario&tab=materiales"); //Pestaña+subpestaña
	}
?>