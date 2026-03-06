<?php

// incluyo la configuración de la conexión a la base de datos
require_once "../config/database.php";

// verifico si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // obtengo los datos del formulario
    $nombre = $_POST["nombre"] ?? null;
    $descripcion = $_POST["descripcion"] ?? null;
    $precio = $_POST["precio"] ?? null;
    $stock = $_POST["stock"] ?? 0;

    // valido los datos del formulario
    if (!$nombre || !$precio) {
        echo json_encode(["error" => "Nombre y precio son obligatorios"]);
        exit;
    }

    // creo la consulta sql para insertar el producto en la base de datos
    $sql = "INSERT INTO productos 
            (nombre, descripcion, precio, stock, fecha_creacion)
            VALUES (?, ?, ?, ?, NOW())";

    // preparo la consulta sql
    $stmt = $conexion->prepare($sql);

    // ejecuto la consulta sql
    $stmt->execute([
        $nombre,
        $descripcion,
        $precio,
        $stock
    ]);

    // si se ejecuta correctamente, muestro un mensaje 
    echo json_encode([
        "mensaje" => "Producto creado correctamente"
    ]);
}