<?php
// Incluimos la configuración de la conexión a la base de datos
include_once '../config/database.php';

// Verifico si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtengo los datos del formulario
    $nombre = $_POST['nombre'] ?? null; 
    $email = $_POST['email'] ?? null; 
    $telefono = $_POST['telefono'] ?? null;
    $ciudad = $_POST['ciudad'] ?? null;
    $codigo_postal = $_POST['codigo_postal'] ?? null;
    // Valido los datos del formulario
    if (empty($nombre) || empty($email) || empty($telefono) || empty($ciudad) || empty($codigo_postal)) {
        // Si alguno de los datos es vacío, muestro un mensaje de error
        echo "Todos los campos son obligatorios";
        exit;
    }

    // Creo la consulta SQL para insertar el cliente en la base de datos
    $sql = "INSERT INTO clientes 
    (nombre, email, telefono, ciudad, codigo_postal) 
    VALUES (?,?,?,?,?. now())"; // uso ? para los valores que se van a insertar

    // Preparo la consulta SQL
    $stmt = $conexion->prepare($sql);

    // Ejecuto la consulta SQL
    $stmt->execute([
        $nombre, 
        $email, 
        $telefono, 
        $ciudad, 
        $codigo_postal
        ]);
        
        // Si se ejecuta correctamente, muestro un mensaje de éxito
        echo json_encode([
            "mensaje" => "Cliente creado correctamente",
        ]);
}
