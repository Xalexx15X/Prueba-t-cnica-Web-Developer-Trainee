<?php

// incluyo la configuración de la conexión a la base de datos
require_once "../config/database.php";

// creo la consulta sql para listar los productos en la base de datos   
$sql = "SELECT * FROM productos";

// preparo la consulta sql
$stmt = $conexion->prepare($sql);
// ejecuto la consulta sql
$stmt->execute();

// obtengo los datos de la consulta sql
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// si se ejecuta correctamente, muestro los datos de la consulta sql
echo json_encode([
    "productos" => $productos
]);
