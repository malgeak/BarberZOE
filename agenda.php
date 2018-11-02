<!-- AGENDA -->
<div id="agenda" class="hidden w3-animate-opacity w3-content w3-padding-large w3-margin-top hide">	

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
	</div>
</div>