<!-- MENU -->			
<div class="w3-center w3-padding w3-block whiteTransparent w3-display-container" style="background: rgba(255, 255, 255, .9);">
	<h1 class="w3-jumbo w3-animate-top shadow hide" id="zoe" style="font-family: Old English Text MT;"><?php echo $negocio; ?></h1>
	<button onclick="w3.show('#portada'); w3.show('#zoe'); w3.hide('#inventario'); w3.hide('#movimientos'); w3.hide('#agenda');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top">Portada</button>
	<button onclick="w3.show('#inventario'); w3.hide('#zoe'); w3.hide('#portada'); w3.hide('#movimientos'); w3.hide('#agenda');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top">Inventario</button>
	<button onclick="w3.show('#movimientos'); w3.hide('#zoe'); w3.hide('#portada'); w3.hide('#inventario'); w3.hide('#agenda');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top">Movimientos</button>
	<button onclick="w3.show('#agenda'); w3.hide('#zoe'); w3.hide('#portada'); w3.hide('#inventario'); w3.hide('#movimientos');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top">Agenda</button>
</div>