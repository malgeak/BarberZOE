<!-- RECURSOS -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" type="image/x-icon" href="recursos/imagenes/favicon.ico">
<script src="recursos/js/w3.js" type="text/javascript"></script>
<link rel="stylesheet" href="recursos/css/barberia.css">
<link rel="stylesheet" href="recursos/css/w3.css">

<?php
	function test_input($data, $maxlenght=1000) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlentities($data);
		$data = htmlspecialchars($data);
		$data = str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
				array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
					"&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $data);
		$data = mb_strimwidth($data, 0, $maxlenght, "");
		return $data;
	}

	function redireccionar($accion){ #Volver a carperta raiz
		if(empty($accion)){
			echo '<META HTTP-EQUIV="REFRESH" CONTENT="'.$GLOBALS['tiempoRedir'].';URL='.$GLOBALS['raiz'].'">';
		}else{
			echo '<META HTTP-EQUIV="REFRESH" CONTENT="'.$GLOBALS['tiempoRedir'].';URL='.$GLOBALS['raiz'].$accion.'">';
		}		
	}

	//Modal generator	-> Mejorar
	function modal($id,$texto,$alerta="accion",$abrir="si",$marco="blink"){
		if($alerta=="correcto"){
	    	$alerta="<i class='fa fa-check-circle-o w3-text-green'></i>";
	    }else if($alerta=="alerta"){
	    	$alerta="<i class='fa fa-exclamation-triangle w3-text-yellow'></i>";
	    }else if($alerta=="error"){
	    	$alerta="<i class='fa fa-window-close-o w3-text-red'></i>";
	    }else{
	    	$alerta="<i class='fa fa-terminal'></i>";
	    }		

		echo '<div id="'.$id.'" class="w3-modal w3-animate-opacity">';
			echo '<div class="w3-modal-content w3-display-middle w3-padding w3-margin-bottom w3-margin-top '.$marco.'" style="border-radius: 32px 0px 32px 32px;">';
				echo '<div class="w3-container w3-large w3-padding-24">';
					echo "<span onclick=\"w3.hide('#".$id."');\" class=\"w3-button w3-red w3-hover-opacity w3-display-topright w3-xlarge\" title=\"Cerrar ventana\">&times;</span>";
						echo '<p class="w3-center">'.$alerta.' '.$texto.'</p>';
				echo '</div>';
			echo '</div>';
		echo '</div>';

		if($abrir=="si"){echo "<script>w3.show('#".$id."');</script>";}		
	}
?>

<script type="text/javascript">
	function SetDate(){ //Fecha para registrar venta
		var date = new Date();
		var day = date.getDate();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		var hours = date.getHours();
		var minutes = date.getMinutes();

		if (month < 10) month = "0" + month;
		if (day < 10) day = "0" + day;
		if(hours < 10) hours = '0' + hours; 
		if(minutes < 10) minutes = '0' + minutes; 

		var today = year + "-" + month + "-" + day;
		var time = hours + ':' + minutes;

		document.getElementById('dateToday').value = today; //Ventas
		document.getElementById('dateToday2').value = today; //Gastos
		document.getElementById('timeNow').value = time;
	}

	function alerta(mensaje, tipo) { //Barra alertas
	    var x = document.getElementById("snackbar");
	    x.className = "show";
	    if(tipo=="correcto"){
	    	tipo="<i class='fa fa-check-circle-o w3-text-green'></i>";
	    }else if(tipo=="alerta"){
	    	tipo="<i class='fa fa-exclamation-triangle w3-text-yellow'></i>";
	    }else if(tipo=="error"){
	    	tipo="<i class='fa fa-window-close-o w3-text-red'></i>";
	    }else{
	    	tipo="<i class='fa fa-terminal'></i>";
	    }
	    x.innerHTML = tipo+" "+mensaje;
	    setTimeout(function(){x.className = x.className.replace("show", ""); }, 3000);    
	}
	function windowOpen(enlace){
		var ancho = screen.width;
		var largo = screen.height;

		var windowO = window.open(enlace, "imprimir", "menubar=no,location=no,resizable,scrollbars=yes,status=no,width="+ancho+", height="+largo);
		window.moveTo(0,0);
	}

	function checkField(check, field){ //Para evitar enviar ventas sin cantidad
		var checkbox = document.getElementById(check);
		var fieldtext = document.getElementById(field);
		if (checkbox.checked == true){
		    fieldtext.disabled = "";
		    fieldtext.required = "required";
		}else if(checkbox.checked != true){
			fieldtext.disabled = "disabled";
			fieldtext.value = "";
			fieldtext.required = "";
		}
	}
</script>