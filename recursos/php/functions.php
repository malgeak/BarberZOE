<script type="text/javascript">
    <?php
    /* Funciones para los buscadores */
    #Una funcion de PHP para crear funciones de JS
    function crearFiltrador($titulo){
      echo "function filtrador".$titulo."() {";
        echo "var input, filter, table, tr, td, i;";
        echo "input = document.getElementById(\"buscador".$titulo."\");";
        echo "filter = input.value.toUpperCase();";
        echo "table = document.getElementById(\"tabla".$titulo."\");";
        echo "tr = table.getElementsByTagName(\"tr\");";
        
        echo "for (i = 0; i < tr.length; i++) {";
          echo "td = tr[i].getElementsByTagName(\"td\")[1];";
          
          echo "if (td) {";
            echo "if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {";
              echo "tr[i].style.display = \"\";";
            echo "} else {";
              echo "tr[i].style.display = \"none\";";
            echo "}";
          echo "}";  
        echo "}";
      echo "}";
    }

    crearFiltrador("Productos");
    crearFiltrador("Materiales");
    crearFiltrador("Ventas");
    crearFiltrador("Gastos");
  ?>

  function openLink(evt, animName) { //Pestañas generales
    var i, x, tablinks;
    x = document.getElementsByClassName("hidden");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }

     tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < x.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" w3-black", "");
      }
    
    document.getElementById(animName).style.display = "block";

     evt.currentTarget.className += " w3-black";
  }

  function openTab(evt, inv) { //Pestañas de inventario
    	var i, x, tablinks;
    	x = document.getElementsByClassName("buttonInv");
    	for (i = 0; i < x.length; i++) {
        	x[i].style.display = "none";
    	}
    	tablinks = document.getElementsByClassName("tabs");
    	for (i = 0; i < x.length; i++) {
        	tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
    	}
    	document.getElementById(inv).style.display = "block";
    	evt.currentTarget.className += " w3-red";
  }

  function openTab2(evt, gan) { //Pestañas de movimientos
    	var i, x, tablinks;
    	x = document.getElementsByClassName("buttonGan");
    	for (i = 0; i < x.length; i++) {
        	x[i].style.display = "none";
    	}
    	tablinks = document.getElementsByClassName("tabs2");
    	for (i = 0; i < x.length; i++) {
        	tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
    	}
    	document.getElementById(gan).style.display = "block";
    	evt.currentTarget.className += " w3-red";
  }

  function openEl(elementoA) { //Abrir elementos
    var elementoA = document.getElementById(elementoA);
      elementoA.style.display = "block";
  }

  function closeEl(elementoB) { //Cerrar elementos
    var elementoB = document.getElementById(elementoB);
      elementoB.style.display = "none";
  }

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

  	document.getElementById('dateToday').value = today;
  	document.getElementById('timeNow').value = time;
  	document.getElementById('timeSave').value = time;
  	document.getElementById('dateSave').value = today;			
  	document.getElementById('dateSave2').value = today;
  	document.getElementById('dateSave3').value = today;
  }

  function sistema(){
  	alerta("El sistema ha cargado correctamente");
  }

  function alerta(mensaje) { //Popup de alertas
      var x = document.getElementById("snackbar");
      x.className = "show";
      document.getElementById("snackbar").innerHTML = mensaje;
      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 10000);
  }

  function windowOpen(enlace){
    var ancho = screen.width;
    var largo = screen.height;

    var windowO = window.open(enlace, "imprimir", "menubar=no,location=no,resizable,scrollbars=yes,status=no,width="+ancho+", height="+largo);
    window.moveTo(0,0);
  }

  function check(id){ //Para evitar enviar ventas sin cantidad
  	var name = "check" + id.toString();
  	var cant = "canti" + id.toString();
  	var checkbox = document.getElementById(name);
  	if (checkbox.checked == true){
  	    document.getElementById(cant).required = "required";
  	}else if(checkbox.checked != true){
  		document.getElementById(cant).required = "";
  	}
  }
</script>