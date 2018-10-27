<?php
	#Cambia por equipo
	$user = "root";
	$pass = "";
	$dbname = "barberzoe"; //CREAR MANUALMENTE(?)
	$port = "5433";
	$host = "localhost";
	$negocio = "Barber ZOE"; //Nombre del negocio	
	$fondo = "recursos/imagenes/barberia.jpg"; //Fondo de pagina
	$aniversario = "2016/04/18"; //Fecha de aniversario del negocio

	#Carpeta en la que se encuentra el proyecto
	$raiz = "/"; //    /CARPETA/subcarpeta/

	#Tiempo de redireccion
	$tiempoRedir = 0; //Segundos en redireccionar

	$conexion = mysqli_connect($host, $user, $pass) or die ("Error al conectar con el servidor de la base de datos");
    $db = mysqli_select_db ($conexion, $dbname)or die ("Error alconectarse con la base de datos");

	require "database.php"; //Crea las tablas de la BD (Si no existen o faltan llaves primarias)

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
	$days = null; //Cuenta el total de registros en agenda
	$lastDay = null; //Obtiene el ultimo dia registrado en agenda
	$filaDia = null; //Para dias en blanco antes del dia 1 del mes	
	$diasMes = null; //Para dias en total que tiene el mes

	#Variables de uso global
	$estetica = null; //Nombre negocio
	$dia = null; //Dia actual
	$hoy = null; //Fecha YYYY-MM-DD actual
	$mes = null; //Mes actual -> Por # Se cambia por TXT
	$aniversarioDia=null;//Obtiene los datos por separado del aniv.
	$aniversarioMes=null;//Obtiene los datos por separado del aniv.
	$aniversarioAño=null;//Obtiene los datos por separado del aniv.
	$mesActual = null; //Mes actual en TXT
	$meses=array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"); //Meses
	$diasName = array("domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sábado");

	//Obtiene los datos por separado del aniv.
	$aniversarioDia=substr($aniversario, -2);
	$aniversarioMes=substr($aniversario, -5, -3);
	$aniversarioAño=substr($aniversario, 0, 4);

	#Zona horaria
	date_default_timezone_set('UTC');
	date_default_timezone_set("America/Mexico_City");
	setlocale(LC_TIME, 'spanish');

	#Obtener nombre del negocio
	$query = "SELECT * FROM negocio";
	$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos en negocio");
	while ($fila=mysqli_fetch_array($resultado)) {					
		$negocio = $fila['pknombre'];
	}	

	#Cada día valida que esté disponible para realizar registros en eventos, ventas y gastos
	$hoy = date("Y-m-d"); //AAAA-MM-DD
	$query = "SELECT * FROM agenda";
	$resultado = mysqli_query($conexion, $query) or die("Error al obtener datos de agenda");
	$days = mysqli_num_rows($resultado);
	if($days>0){ //Si hay algun registro
		while ($fila=mysqli_fetch_array($resultado)) {
			$lastDay = $fila['pkfecha']; //Busca la ultima fecha insertada
		}

		if ($lastDay!=$hoy) { //Si el ultimo día insertado es diferente al de hoy
			$query = "INSERT INTO agenda VALUES ('$negocio', '$hoy')"; //Inserta datos hoy
			$resultado = mysqli_query($conexion, $query) or die("<script>alert('Error al insertar fecha');</script>");
		}
	}else{
		$query = "INSERT INTO agenda VALUES ('$negocio', '$hoy')"; //Si no hay registros
		$resultado = mysqli_query($conexion, $query) or die("<script>alert('Error al insertar fecha');</script>");
	}

	##### POST/GET ######
	//Calendario
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

	//Calendario	
	$dia = date('d'); //Día actual 
	$filaDia = date('N', mktime(0, 0, 0, $mes, 1, $año)); //Dias en blanco antes del dia 1 del mes	
	$diasMes = date('t', mktime(0, 0, 0, $mes, 1, $año)); //Dias en total que tiene el mes
	$mesActual = $meses[date('n')-1]; //MesActual para array [Index - 1] por posición de array
	$evt = null; //Por cada evento -> array
	$evt = array();

	#Limpia todos los elementos posibles -> Obtiene de $_POST['elemento']
	if(empty($_POST["tabla"])){$tabla = null; $tipo=null;}else{$tabla = $_POST["tabla"]; /*Tabla*/}
	if(empty($_POST["id"])){$place = null;}else{$place = $_POST["id"]; /*Id*/}
	if(empty($_POST["marca"])){$marca = null;}else{$marca = test_input($_POST["marca"]); /*Marca*/}
	if(empty($_POST["nombre"])){$nombre = null;}else{$nombre = test_input($_POST["nombre"]); /*Nombre*/}
	if(empty($_POST["stock"])){$stocks = null;}else{$stocks = $_POST["stock"]; /*Stocks*/}
	if(empty($_POST["precio"])){$precios = null;}else{$precios = $_POST["precio"]; /*Precios*/}
	if(empty($_POST["stock"])){$stock = null;}else{$stock = $_POST["stock"]; /*Stock*/}
	if(empty($_POST["precio"])){$precio = null;}else{$precio = $_POST["precio"]; /*Precio*/}
	if(empty($_POST["registro"])){$registro = null;}else{$registro = $_POST["registro"];/*Registro*/}
	if(empty($_POST["fecha"])){$fecha = null;}else{$fecha = $_POST["fecha"]; /*Fecha*/}
	if(empty($_POST["hora"])){$hora = null;}else{$hora = $_POST["hora"]; /*Hora*/}
	if(empty($_POST["descripcion"])){$descripcion = null;}else{$descripcion = test_input($_POST["descripcion"]); /*Descripcion*/}
	if(empty($_POST["descuento"])){$descuento = null;}else{$descuento = $_POST["descuento"]; /*Descuento*/}
	if(empty($_POST["cantidad"])){$cantidad = null;}else{$cantidad = $_POST["cantidad"]; /*Cantidades*/}
	if(empty($_POST["tipoE"])){$tipoE = null;}else{$tipoE = $_POST["tipoE"]; /*Evento*/}
	if(empty($_POST['selected'])){$elegidos=null;}else{$elegidos = $_POST['selected']; /*Crea array con los checkbox seleccionados*/}

	#Configuracion variable TIPO->TABLA
	if ($tabla == "productos") {
		$tipo = 1;
	}elseif ($tabla == "materiales") {
		$tipo = 2;
	}elseif ($tabla == "ventas") {
		$tipo = 3;
	}elseif ($tabla == "gastos") {
		$tipo = 4;
	}elseif ($tabla == "eventos") {
		$tipo = 5;
	}

	#Configuracion entre inventario y agenda
	if ($tabla == "productos" || $tabla == "materiales") {
		$id = "pkserial";
	}elseif ($tabla == "eventos") {
		$id = "pkevento";
	}

	#Funciones
	function redireccionar($accion){ #Volver a carperta raiz
		if(empty($accion)){
			echo '<META HTTP-EQUIV="REFRESH" CONTENT="'.$GLOBALS['tiempoRedir'].';URL='.$GLOBALS['raiz'].'">';
		}else{
			echo '<META HTTP-EQUIV="REFRESH" CONTENT="'.$GLOBALS['tiempoRedir'].';URL='.$GLOBALS['raiz'].$accion.'">';
		}		
	}

	function test_input($data){ #Corregir tildes y acentos->html->utf8
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlentities($data);
		$data = htmlspecialchars($data, ENT_QUOTES);
		$data = str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ", "'"),
		    array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
		      "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;", "&#039;"), $data);
		return $data;
	}
?>