<!-- AGENDA -->
<div id="Agenda" style="height: 100%;" class="hidden w3-animate-opacity w3-content w3-padding-large w3-margin-top">			
	<div class="w3-white w3-card-4 w3-margin-bottom">
		<div class="w3-row">
			<div class="w3-padding">
				<h1 class="w3-jumbo w3-center shadow w3-animate-opacity w3-hide-small" style="font-family: Old English Text MT;">Agenda</h1>
				<p class="w3-xxlarge w3-animate-opacity w3-center shadow w3-hide-medium w3-hide-large" style="font-family: Old English Text MT;">Agenda</p>						
			</div>
		</div>
	</div>

	<div class="w3-white w3-card-4 w3-margin-top">
		<div class="w3-row">
			<div class="w3-padding-32 w3-center" style="margin:0;"> 
				<form method="get" action="<?php echo $raiz;?>">
					<div class="w3-twothird">
						<h1 style="text-transform: uppercase;"><?php echo $meses[$mes-1];?></h1>
						<h2><?php echo $año;?></h2>
					</div>

					<div class="w3-third w3-padding">
						<select class="w3-input w3-border" style="text-transform: uppercase;" name="mes">
							<?php
								for($mess=1; $mess<=12; $mess++){							
									if($mess==$mes){
										echo "<option value='".$mess."' selected>".$meses[$mess-1]."</option>";
									}else{
										echo "<option value='".$mess."'>".$meses[$mess-1]."</option>";
									}
								}
							?>
						</select>
						<input class="w3-input w3-border w3-large" name="año" type="number" min="1900" max="2100" value="<?php echo $año ?>" placeholder="<?php echo $año ?>">
						<button class="w3-border w3-white w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top" type="submit" name="pestaña" value="agenda">Mostrar</button>
					</div>					
	    		</form>
			</div>

			<?php include "calendario.php";?>
		</div>

		<div class="w3-row w3-margin-top">
			<div class="w3-center w3-padding w3-block w3-margin-top">
				<button onclick="openEl('agregarEvento'); SetDate(); alerta('Llene todos los campos')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Agregar</button>
				<button onclick="openEl('eliminarEvento'); alerta('Seleccione los eventos a eliminar')" class="w3-border w3-white w3-hover-red w3-button w3-round-medium w3-ripple w3-margin-bottom">Eliminar</button>
				<button onclick="openEl('revisarEventos'); alerta('Son todos los eventos registrados')" class="w3-border w3-white w3-hover-blue w3-button w3-round-medium w3-ripple w3-margin-bottom">Revisar</button>
			</div>
		</div>
	</div>
</div>

<?php
	include "ventanas.php";
?>