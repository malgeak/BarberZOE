<!-- MENU -->			
<div class="w3-center w3-padding w3-block whiteTransparent" style="background: rgba(255, 255, 255, .9);">
	<h1 class="w3-jumbo w3-animate-top shadow w3-hide-small" id="zoe" style="font-family: Old English Text MT;"><?php echo $negocio; ?></h1>
	<button id="p" onclick="openLink(event, 'main'); openEl('zoe');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top tablink">Portada</button>
	<button id="i" onclick="openLink(event, 'Inventario'); closeEl('zoe');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top tablink">Inventario</button>
	<button id="m" onclick="openLink(event, 'Movimientos'); closeEl('zoe');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top tablink">Movimientos</button>
	<button id="a" onclick="openLink(event, 'Agenda'); closeEl('zoe');" class="w3-border w3-black w3-hover-black w3-button w3-round-medium w3-ripple w3-margin-bottom w3-margin-top tablink">Agenda</button>
</div>