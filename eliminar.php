<?php
	include "config.php";

	/*
		$tabla -> productos / materiales
		$conexion -> conexion de query con BD
		$query -> consulta / insercion / eliminacion
		$resultado -> resultado de query
		$counts -> Total de seleccionados
		$id -> pkserial | pkevento
		$elegidos[x] -> $_POST['selected'] -> array checkboxes
		$i -> Bucle -> Todos los registros -> Index arrays
	*/

	if(empty($elegidos)){ //En caso de no elegir alguno
		echo "¡No se ha eliminado nada!";
		redireccionar("");
	}else{
		$counts = count($elegidos); //Cuenta los seleccionados
		for($i=0; $i < $counts; $i++){ //El $elegidos[$i] seleccionado es el serial
			$query = "DELETE FROM $tabla WHERE $id=$elegidos[$i]";
			$resultado = pg_query($conexion, $query) or die("Error al eliminar registros");
			echo "Se eliminó de la tabla ".$tabla.", el elemento con el ID ".$elegidos[$i]. ".<br>";
		}

		if($tabla=="productos"){
			redireccionar("?pestaña=inventario&tab=productos"); //Pestaña+subpestaña
		}else if($tabla=="materiales"){
			redireccionar("?pestaña=inventario&tab=materiales"); //Pestaña+subpestaña
		}else if($tabla=="eventos"){
			redireccionar("?pestaña=agenda"); //Pestaña
		}
	}

	pg_close($conexion);	
?>