<table class="w3-table w3-bordered w3-centered">
	<tr class="w3-light-grey">
		<?php
			for($diasNumb=0; $diasNumb<7; $diasNumb++){
				echo "<th style='text-transform:uppercase;'>".$diasName[$diasNumb]."</th>";
			}
		?>
	</tr>

	<style type="text/css">
		.evt:hover{
			cursor: cell;
		}
	</style>

	<?php
		/* PARA FUTURA ÍMPLEMENTACIÓN
		$query = "SELECT fecha FROM eventos ORDER BY fecha ASC";
		$resultado = pg_query($conexion, $query) or die("Error al obtener datos en eventos");
		$eventos = pg_fetch_all_columns($resultado); //Array con los eventos existentes

		$query = "SELECT nombre FROM eventos ORDER BY fecha ASC";
		$resultado = pg_query($conexion, $query) or die("Error al obtener datos en eventos");
		$nombres = pg_fetch_all_columns($resultado); //Array con los nombres de eventos

		$query = "SELECT tipo FROM eventos ORDER BY fecha ASC";
		$resultado = pg_query($conexion, $query) or die("Error al obtener datos en eventos");
		$tipos = pg_fetch_all_columns($resultado); //Array con los tipos de eventos

		$query = "SELECT descripcion FROM eventos ORDER BY fecha ASC";
		$resultado = pg_query($conexion, $query) or die("Error al obtener datos en eventos");
		$descs = pg_fetch_all_columns($resultado); //Array con las desc de eventos

		$totalEventos = count($eventos);

		for($count = 0; $count<$totalEventos; $count++){ //Por cada evento obtiene valores
			$evento[$count] = $eventos[$count];
			$eventoDia[$count] = substr($evento[$count], -2);
			$eventoMes[$count] = substr($evento[$count], -5, -3);
			$eventoAño[$count] = substr($evento[$count], 0, 4);

			if(substr($evento[$count], -5, -3)<10){ //Eliminar el 0 de mes
				$eventoMes[$count] = str_replace("0", "", $eventoMes[$count]);
			}

			$nombre[$count] = $nombres[$count];
			$tipo[$count] = $tipos[$count];
			$desc[$count] = $descs[$count];

			$evt[$count] = $evento[$count] . ", " . $tipo[$count] . ", " . $nombre[$count] . ", " . $desc[$count] . "."; //No se como seguirle
		}
		*/

		if($filaDia<7){ //Meses que no comienzan en domingo
			echo "<tr>"; //Fila
			for($blanks = 1; $blanks <= $filaDia; $blanks++){
				echo "<td></td>"; //Cada dia en blanco
			}
		}else if($filaDia==7){//Meses que comienzan en domingo
			$filaDia=0; 
			echo "<tr>"; //Fila
			for($blanks = 1; $blanks <= $filaDia; $blanks++){
				echo "<td></td>"; //Cada dia en blanco
			}
		}	
		
		for($dias = 1; $dias <= $diasMes; $dias++){ //Todos los dias del mes
			$filaDia++; //A partir del ultimo dia en blanco cuenta las columnas
			if($dias==$dia && $mes==date('n') && $año==date('Y')){//Día de hoy yyyy-mm-dd
				echo "<td class='w3-black evt w3-hover-opacity'>"  . $dias . "<br><span class='w3-tiny'>HOY</span></td>"; //Dia actual				

				if($filaDia==7){ //Ultima columna
					echo "</tr><tr>"; //Cierre de fila y nueva fila	
				}											
			}else if($dias==$aniversarioDia && $mes==$aniversarioMes && $año==$aniversarioAño){//Día de aniversario
				echo "<td class='w3-black evt w3-hover-opacity'>"  . $dias . "<br><span class='w3-tiny'>ANIVERSARIO</span></td>"; //Dia aniv				

				if($filaDia==7){ //Ultima columna
					echo "</tr><tr>"; //Cierre de fila y nueva fila	
				}
			}else{ //Dia cualquiera
				echo "<td>"  . $dias . "</td>"; //Dia del mes
				if($filaDia==7){ //Ultima columna
					echo "</tr><tr>"; //Cierre de fila y nueva fila
				}
			}

			if($filaDia==7){ //Ultima columna
				$filaDia = 0; //Inicia desde la primer columna
			}								
		}
		echo "</tr>"; //Cierre filas
	?>						
</table>