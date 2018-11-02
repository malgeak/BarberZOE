<?php
	try { //Implementación con PDO
	    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Tipo de conexión -> PDO

	    #echo "Se conectó correctamente con la BD. <br>";

	    //Nuestro SQL si es dato de seguridad usar AES_ENCRYPT
	    //Ejemplo de uso ENCRYPT
	    //$sql = "INSERT INTO newsletter(correo, notificaciones) VALUES (AES_ENCRYPT(?, '$specialKey'), ?)";
	    //AES_ENCRYPT(datoAGuardar, 'LLAVE DE SEGURIDAD')
	    //Es necesario que ese campo esté como dato VARBINARY y no VARCHAR u OTRO
	    //Para des-encriptar se usa AES_DECRYPT del mismo modo que en un AES_ENCRYPT dentro de printf o #echo

	    $sql = "CREATE TABLE IF NOT EXISTS negocio (nombre_negocio VARCHAR(100) PRIMARY KEY NOT NULL)";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute(); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'negocio' en base la de datos. <br>";

	    $sql = "INSERT INTO negocio VALUES ('$negocio') ON DUPLICATE KEY UPDATE nombre_negocio='$negocio'";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$negocio]); //Ejecutamos el SQL con los datos a guardar
	    #echo "Insertado o actualizado en la tabla negocio el registro '" . $negocio . "' correctamente. <br>";

	    $sql = "CREATE TABLE IF NOT EXISTS inventario (id_inventario INT PRIMARY KEY NOT NULL AUTO_INCREMENT, nombre_negocio VARCHAR(100) DEFAULT ?, descripcion VARCHAR(200), FOREIGN KEY (nombre_negocio) REFERENCES negocio(nombre_negocio))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$negocio]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'inventario' en base la de datos. <br>";

	    $sql = "INSERT INTO inventario (id_inventario, descripcion) VALUES (?, ?) ON DUPLICATE KEY UPDATE nombre_negocio='$negocio'";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([1, 'Productos de la barber&iacute;a']); //Ejecutamos el SQL con los datos a guardar

	    $sql = "INSERT INTO inventario (id_inventario, descripcion) VALUES (?, ?) ON DUPLICATE KEY UPDATE nombre_negocio='$negocio'";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([2, 'Materiales de la peluquer&iacute;a']); //Ejecutamos el SQL con los datos a guardar
	    #echo "Insertados o actualizados los registros en la tabla de inventario correctamente. <br>";

	    $sql = "CREATE TABLE IF NOT EXISTS productos (id_inventario INT DEFAULT ?, codigo INT PRIMARY KEY NOT NULL, marca VARBINARY(100), nombre VARBINARY(100), stock VARBINARY(50), precio VARBINARY(50), FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([1]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'productos' en base la de datos. <br>";

	    $sql = "CREATE TABLE IF NOT EXISTS materiales (id_inventario INT DEFAULT ?, id_material INT PRIMARY KEY NOT NULL, nombre VARBINARY(100), stock VARBINARY(50), precio VARBINARY(50), FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([2]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'materiales' en base la de datos. <br>";

	    $sql = "CREATE TABLE IF NOT EXISTS agenda (nombre_negocio VARCHAR(100) DEFAULT ?, fecha DATE NOT NULL PRIMARY KEY, FOREIGN KEY (nombre_negocio) REFERENCES negocio(nombre_negocio))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$negocio]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'agenda' en base la de datos. <br>";

	    #Cada día valida que esté disponible para realizar registros en eventos, ventas y gastos
		$fecha_hoy = date("Y-m-d"); //AAAA-MM-DD

		$sql = "INSERT INTO agenda (fecha) VALUES (?) ON DUPLICATE KEY UPDATE fecha='$fecha_hoy'";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$fecha_hoy]); //Ejecutamos el SQL con los datos a guardar
	    #echo "Insertada o actualizada la fecha de hoy (" . $fecha_hoy . ") en la tabla de agenda correctamente. <br>";

	    #Día de aniversario del negocio
	    $sql = "INSERT INTO agenda (fecha) VALUES (?) ON DUPLICATE KEY UPDATE fecha='$aniversario'";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$aniversario]); //Ejecutamos el SQL con los datos a guardar
	    #echo "Insertada o actualizada la fecha de aniversario (" . $aniversario . ") en la tabla de agenda correctamente. <br>";

	    $sql = "CREATE TABLE IF NOT EXISTS eventos (id_evento INT NOT NULL PRIMARY KEY AUTO_INCREMENT, fecha DATE NOT NULL DEFAULT ?, hora VARBINARY(10), nombre VARBINARY(200), tipo VARBINARY(50), descripcion VARBINARY(250), recordatorio VARBINARY(100), FOREIGN KEY (fecha) REFERENCES agenda(fecha))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$fecha_hoy]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'eventos' en base la de datos. <br>";

	    #El primer registro en los eventos es el aniversario del negocio
	    $sql = "INSERT INTO eventos VALUES (?, ?, AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey')) ON DUPLICATE KEY UPDATE fecha='$aniversario'";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([1, $aniversario, "10:00", "Aniversario de negocio", "aniversario", "Hagamos fiesta de aniversario.", "todo el d&iacute;a"]); //Ejecutamos el SQL con los datos a guardar
	    #echo "Insertada o actualizada la fecha de aniversario (" . $aniversario . ") del negocio en la tabla de eventos correctamente. <br>";

	    $sql = "CREATE TABLE IF NOT EXISTS gastos (id_gasto INT NOT NULL PRIMARY KEY AUTO_INCREMENT, fecha DATE NOT NULL DEFAULT ?, costo_total VARBINARY(50), descripcion VARBINARY(350), FOREIGN KEY (fecha) REFERENCES agenda(fecha))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$fecha_hoy]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'gastos' en base la de datos. <br>";

	    $sql = "CREATE TABLE IF NOT EXISTS ventas (id_venta INT NOT NULL PRIMARY KEY AUTO_INCREMENT, fecha DATE NOT NULL DEFAULT ?, costo_total VARBINARY(50), descuento INT, descripcion VARBINARY(1500), hora VARBINARY(50), FOREIGN KEY (fecha) REFERENCES agenda(fecha))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$fecha_hoy]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'ventas' en base la de datos. <br>";

	    #Tabla de registros de cambios en la BD
	    $sql = "CREATE TABLE IF NOT EXISTS registros (id_registro INT NOT NULL PRIMARY KEY AUTO_INCREMENT, momento TIMESTAMP DEFAULT CURRENT_TIMESTAMP, tabla VARCHAR(25), acciones VARCHAR(350), nombre_negocio VARCHAR(100) DEFAULT ?, FOREIGN KEY (nombre_negocio) REFERENCES negocio(nombre_negocio))";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([$negocio]); //Ejecutamos el SQL
	    #echo "Creada o actualizada tabla 'registros' para la base de datos. <br>";

	    #El primer registro es que se crea correctamente la estructura de la BD
	    $sql = "INSERT INTO registros (id_registro, tabla, acciones) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE id_registro=1";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute([1, "GENERAL", "Se ha creado la estructura de la base de datos correctamente."]); //Ejecutamos el SQL con los datos a guardar
	    #echo "Registro guardado correctamente.";

	}catch(PDOException $e){
		$e = $e->getMessage();
		modal("errorDatabase", "<b>Error en database.php: </b><br><tt>" . $e . "</tt>", "error");
   		//Errores (Muestra donde se detiene)
    }
?>