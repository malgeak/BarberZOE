<table class="w3-table w3-bordered w3-centered w3-margin-bottom">
	<tr class="w3-light-grey">
		<?php
			for($diasNumb=0; $diasNumb<7; $diasNumb++){
				echo "<th style='text-transform:uppercase;'>".$dias[$diasNumb]."</th>";
			}
		?>
	</tr>

	<style type="text/css">
		.evt:hover{
			cursor: cell;
		}
	</style>

	<?php
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