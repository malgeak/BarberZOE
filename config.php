<?php
	#Base de datos
	$user = "root"; //Usuario
	$pass = ""; //Contraseña
	$dbname = "barberzoe"; //CREAR MANUALMENTE!
	$host = "localhost"; //Host
	$negocio = "Barber ZOE"; //Nombre del negocio	
	$fondo = "recursos/imagenes/barberia.jpg"; //Fondo de pagina
	$aniversario = "2016/04/18"; //Fecha de aniversario del negocio
	$specialKey = "BarberXianStencil"; //Llave de seguridad para encriptar y desencriptar datos

	#Carpeta en la que se encuentra el proyecto
	$raiz = "/"; //    /carpeta/subcarpeta/

	#Tiempo de redireccion
	$tiempoRedir = 0; //Segundos en redireccionar

    require "recursos/php/basics.php"; //Funciones, visuales, eventos...
    require "acciones.php"; //Agregar, actualizar y eliminar
	require "database.php"; //Conecta con la base de datos y revisa las tablas de la BD
	include "FILLS.php"; //Registros de prueba -> Falta añadir nombres y marcas reales; ventas y gastos.

	//Revisar, algunas variables nunca se utilizan
	#Variables de operaciones 
	$costoTotal = null; //Para operaciones en ventas
	$costoProducto = null; //Para operaciones en ventas
	$nuevoCosto = null; //Para operaciones en ventas
	$costoFinal = null; //Para operaciones en ventas
	$newStock = null; //Para el nuevo inventario
	$totalRegs = null; //Contador consultas (total)
	$numRows = null; //Contador filas (total)
	$desc = null; //Para operaciones en ventas
	$counts = null; //Cuenta el total de seleccionados	

	#Agenda gral.
	$days = null; //Cuenta el total de registros en agenda
	$lastDay = null; //Obtiene el ultimo dia registrado en agenda
	$filaDia = null; //Para dias en blanco antes del dia 1 del mes	
	$diasMes = null; //Para dias en total que tiene el mes
	$dia = null; //Dia actual
	$hoy = null; //Fecha YYYY-MM-DD actual
	$mes = null; //Mes actual -> Por # Se cambia por TXT	
	$mesActual = null; //Mes actual en TXT
	$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"); //Meses
	$dias = array("domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sábado");

	//Obtiene los datos por separado del aniv. -> Mejorar junto con calendario
	$aniversarioDia = null;//Obtiene los datos por separado del aniv.
	$aniversarioMes = null;//Obtiene los datos por separado del aniv.
	$aniversarioAño = null;//Obtiene los datos por separado del aniv.
	$aniversarioDia = substr($aniversario, -2);
	$aniversarioMes = substr($aniversario, -5, -3);
	$aniversarioAño = substr($aniversario, 0, 4);

	#Zona horaria
	date_default_timezone_set('UTC');
	date_default_timezone_set("America/Mexico_City");
	setlocale(LC_TIME, 'spanish');	

	##### POST/GET ######
	//Calendario -> Correcto
	if(empty($_GET["mes"])){
		$mes = date('n'); /*Mes actual*/
	}else{
		if($_GET["mes"]>0&$_GET["mes"]<13){
			$mes = $_GET["mes"]; /*Mes pedido*/
		}else{
			$mes = date('n'); /*Mes actual*/	
		}
	}

	if(empty($_GET["año"])){
		$año = date('Y'); /*Año actual*/
	}else{
		if($_GET["año"]>=1900&$_GET["año"]<=2100){
			$año = $_GET["año"]; /*Año pedido*/
		}else{
			$año = date('Y'); /*Año actual*/	
		}	
	}
	##### POST/GET ######

	//Calendario -> Correcto
	$dia = date('d'); //Día actual 
	$filaDia = date('N', mktime(0, 0, 0, $mes, 1, $año)); //Dias en blanco antes del dia 1 del mes	
	$diasMes = date('t', mktime(0, 0, 0, $mes, 1, $año)); //Dias en total que tiene el mes
	$mesActual = $meses[date('n')-1]; //MesActual para array [Index - 1] por posición de array
	$evt = null; //Por cada evento -> array
	$evt = array();	
?>