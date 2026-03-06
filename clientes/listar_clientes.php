<?php

// Incluyo la configuración de la conexión a la base de datos
include_once '../config/database.php';

$sql = "SELECT * FROM clientes"; // Creo la consulta SQL para listar los clientes en la base de datos
$stmt = $conexion->prepare($sql); // Preparo la consulta SQL
$stmt->execute(); // Ejecuto la consulta SQL

// Obtengo los datos de la consulta SQL
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si se ejecuta correctamente, muestro los datos de la consulta SQL
echo json_encode([
    "clientes" => $clientes
]);
