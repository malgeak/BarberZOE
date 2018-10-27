function openEl(elementoA) { //Abrir elementos -> CAMBIAR POR W3.JS
	var elementoA = document.getElementById(elementoA);
    elementoA.style.display = "block";
}

function closeEl(elementoB) { //Cerrar elementos -> CAMBIAR POR W3.JS
	var elementoB = document.getElementById(elementoB);
    elementoB.style.display = "none";
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

function textCounter(field,counter,maxlimit,linecounter) { //Limite de texto en contenedor -> Crear php función
    var fieldWidth =  parseInt(field.offsetWidth);
    var charcnt = field.value.length;        

    if (charcnt > maxlimit) { 
        field.value = field.value.substring(0, maxlimit);
    }else { 
        var percentage = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
        document.getElementById(counter).style.width =  parseInt((fieldWidth*percentage)/100)+"px";
        document.getElementById(counter).innerHTML=percentage+"%";
    }
}

function detailedBackground(cantidad, icono){ //-> Mejorar
    for (var i = 0; i <= cantidad; i++) {
      var vertical = Math.round(Math.random()*(100));
      var horizontal = Math.round(Math.random()*(100));
      //var rotate = Math.round(Math.random()*(45));
      var size = Math.round(Math.random()*(50));
      var opacity = Math.round(Math.random()*(4));
      if ((i%2)==0) {
        document.write('<span class="fa '+icono+'" style="position: absolute; top:'+vertical+'%; left:'+horizontal+'%; font-size:'+size+'px; opacity:.'+opacity+'; color: #cfcfcf; z-index: -1;"></span>');
      }else{
        document.write('<span class="fa '+icono+'" style="position: absolute; bottom:'+vertical+'%; right:'+horizontal+'%; font-size:'+size+'px; opacity:.'+opacity+'; color: #cfcfcf; z-index: -1;"></span>');
      }
    }
}

function check(checkbox, id){
  var input = document.getElementById(id);
  if (checkbox.checked == true){
    input.style.display = "block";
      input.required = "required";
  }else if(checkbox.checked != true){
    input.required = "";
    input.style.display = "none";
  }
}

function terminos(readed, button){
  var subm = document.getElementById(button);
  if (readed.checked == true){
      subm.disabled = "";
  }else if(readed.checked != true){
    subm.disabled = "disabled";
  }
}

function disableSelection(target){
  if (typeof target.onselectstart!="undefined") //IE
    target.onselectstart=function(){return false}
  else if (typeof target.style.MozUserSelect!="undefined") //Firefox
    target.style.MozUserSelect="none"
  else //All
    target.onmousedown=function(){return false}
  target.style.cursor = "default"
}