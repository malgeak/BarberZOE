<?php
	$query = "CREATE TABLE IF NOT EXISTS negocio (pknombre VARCHAR(100) PRIMARY KEY NOT NULL)";
	$resultado = pg_query($conexion, $query) or die("Error al crear negocio");

	$query = "INSERT INTO negocio VALUES ('$negocio') ON CONFLICT DO NOTHING";
	$resultado = pg_query($conexion, $query) or die("Error al insertar nombre del negocio");

	$query = "CREATE TABLE IF NOT EXISTS inventario (pkinventario NUMERIC(10) PRIMARY KEY NOT NULL, fknombre VARCHAR(100), descripcion VARCHAR(200), FOREIGN KEY (fknombre) REFERENCES negocio(pknombre))";
	$resultado = pg_query($conexion, $query) or die("Error al crear inventario");

	$query = "INSERT INTO inventario VALUES (1, '$negocio', 'Productos de la barbería') ON CONFLICT DO NOTHING";
	$resultado = pg_query($conexion, $query) or die("Error al insertar nombre del negocio");

	$query = "INSERT INTO inventario VALUES (2, '$negocio', 'Materiales de la peluquería') ON CONFLICT DO NOTHING";
	$resultado = pg_query($conexion, $query) or die("Error al insertar nombre del negocio");

	$query = "CREATE TABLE IF NOT EXISTS productos (fkinventario NUMERIC(10), pkserial NUMERIC(50) PRIMARY KEY NOT NULL, marca VARCHAR(200), nombre VARCHAR(200), stock NUMERIC(100), precio NUMERIC(200), FOREIGN KEY (fkinventario)REFERENCES inventario(pkinventario))";
	$resultado = pg_query($conexion, $query) or die("Error al crear productos");

	$query = "CREATE TABLE IF NOT EXISTS materiales (fkinventario NUMERIC(10), pkserial NUMERIC(50) PRIMARY KEY NOT NULL, marca VARCHAR(200), nombre VARCHAR(200), stock NUMERIC(100), precio NUMERIC(200),FOREIGN KEY (fkinventario)REFERENCES inventario(pkinventario))";
	$resultado = pg_query($conexion, $query) or die("Error al crear materiales");

	$query = "CREATE TABLE IF NOT EXISTS agenda (fknombre VARCHAR(100) NOT NULL, pkfecha DATE PRIMARY KEY NOT NULL, FOREIGN KEY (fknombre)REFERENCES negocio(pknombre))";
	$resultado = pg_query($conexion, $query) or die("Error al crear agenda");

	$query = "CREATE TABLE IF NOT EXISTS eventos (pkevento NUMERIC(100) PRIMARY KEY NOT NULL, fkfecha DATE, nombre VARCHAR(100), tipo VARCHAR(100), descripcion VARCHAR(300), fecha DATE, FOREIGN KEY (fkfecha)REFERENCES agenda(pkfecha))";
	$resultado = pg_query($conexion, $query) or die("Error al eventos");

	$query = "CREATE TABLE IF NOT EXISTS gastos (fkfecha DATE, costototal NUMERIC(200), pkgasto NUMERIC(100) PRIMARY KEY NOT NULL, descripcion VARCHAR(300),FOREIGN KEY (fkfecha) REFERENCES agenda(pkfecha))";
	$resultado = pg_query($conexion, $query) or die("Error al crear gastos");

	$query = "CREATE TABLE IF NOT EXISTS ventas (fkfecha DATE, costototal NUMERIC(200), descuento NUMERIC(50), descripcion VARCHAR(1000), pkventa NUMERIC(100) PRIMARY KEY NOT NULL, hora TIME WITHOUT TIME ZONE,FOREIGN KEY (fkfecha) REFERENCES agenda (pkfecha) )";
	$resultado = pg_query($conexion, $query) or die("Error al crear ventas");
?>
