<?php
	$servername = "localhost";
	$username = "omcodemc_omcodem";
	$password = "COC4L4jroKs7";
	$dbname = "omcodemc_database";
	$specialKey = "omcodemc_database";

	function test_input($data, $maxlenght=1000) { //UNTOUCHABLE
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

	function topic($titulo, $icono, $texto, $tamaño){ // -> Mejorar
		echo "<figure class=\"figurefx flipreveal w3-padding-64 topic ".$tamaño."\">";
			echo "<h1><b>".$titulo."</b></h1>";
			echo "<i class=\"".$icono." w3-text-theme w3-jumbo\"></i>";
			echo "<figcaption class=\"w3-theme w3-display-container\">";
			echo "<p class=\"w3-display-middle\" style=\"width:90%;\"><span class=\"".$icono." w3-jumbo w3-block\"></span>";
			echo "<span class='w3-hide-medium'>".$texto."</span>";
			echo "<span class='w3-hide-small w3-hide-large w3-small'>".$texto."</span>";
			echo "</p></figcaption>";
		echo "</figure>";
	}
	
	function portada($imagen, $encabezado, $fondo, $animacion){ //-> Mejorar
		echo "<!-- Portada -->";
		echo "<div class=\"w3-display-container w3-row w3-dark-grey w3-padding-64\" style=\"background-image: url(".$imagen."); background-position: center center; background-size: cover; height: 300px; overflow: hidden;\">";
			echo "<div class=\"".$fondo."\">";
				echo "<div class=\"w3-row-padding w3-display-middle w3-center ".$animacion."\">";
					echo "<h1><b>".$encabezado."</b></h1>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}

	//Modal generator	-> Mejorar
	function modal($id,$texto,$alerta="accion",$abrir="si"){
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
			echo '<div class="w3-modal-content w3-display-middle w3-padding w3-margin-bottom w3-margin-top blink" style="border-radius: 32px 0px 32px 32px;">';
				echo '<div class="w3-container w3-large w3-padding-24">';
					echo "<span onclick=\"w3.hide('#".$id."');\" class=\"w3-button w3-red w3-hover-opacity w3-display-topright w3-xlarge\" title=\"Cerrar ventana\">&times;</span>";
						echo '<p class="w3-center">'.$alerta.' '.$texto.'</p>';
				echo '</div>';
			echo '</div>';
		echo '</div>';

		if($abrir=="si"){echo "<script>w3.show('#".$id."');</script>";}		
	}
?>