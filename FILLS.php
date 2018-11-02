<?php
	try { //Implementación con PDO
	    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //Conexión
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Tipo de concexión -> PDO

	    $sql = "SELECT * FROM productos";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
	    #echo "Datos obtenidos correctamente. <br>";

	    $counter = 0;
	    
		foreach ($conn->query($sql) as $registro) {
			$counter+=1;
		}

		if($counter==0){
		    for ($a=0; $a<25; $a++){
		    	$sql = "INSERT INTO productos VALUES (?, ?, AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey')) ON DUPLICATE KEY UPDATE id_inventario=1";
			    $stmt=$conn->prepare($sql);
			    $stmt->execute([1, rand(11111111, 99999999), "Marca Alguna", "Nombre Alguno", rand(0, 250), rand(100, 350)]);
		    }

		    $sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
		    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
		    $stmt->execute(["productos", "Se insertaron registros de pruebas."]); //Ejecutamos el SQL con los datos a guardar
		    #echo "Registros insertados correctamente.";
		}

		$sql = "SELECT * FROM materiales";
	    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
	    $stmt->execute(); //Ejecutamos el SQL con los datos a obtener
	    #echo "Datos obtenidos correctamente. <br>";

	    $counter = 0;
	    
		foreach ($conn->query($sql) as $registro) {
			$counter+=1;
		}

		if($counter==0){
			for ($a=0; $a<25; $a++){
		    	$sql = "INSERT INTO materiales VALUES (?, ?, AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey'), AES_ENCRYPT(?, '$specialKey')) ON DUPLICATE KEY UPDATE id_inventario=2";
			    $stmt=$conn->prepare($sql);
			    $stmt->execute([2, $a+1, "Nombre alguno", rand(0, 250), rand(100, 350)]);
		    }

		    $sql = "INSERT INTO registros (tabla, acciones) VALUES (?, ?)";
		    $stmt=$conn->prepare($sql); //Preparamos nuestro SQL
		    $stmt->execute(["materiales", "Se insertaron registros de pruebas."]); //Ejecutamos el SQL con los datos a guardar
		    #echo "Registros insertados correctamente.";
		}		
	}catch(PDOException $e){
		$e = $e->getMessage();
		modal("errorFills", "<b>Error en FILLS.php: </b><br><tt>" . $e . "</tt>", "error");
   		//Errores (Muestra donde se detiene)
    }
?>