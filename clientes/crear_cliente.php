<?php
// Establecer el header JSON al inicio
header('Content-Type: application/json');

// Incluimos la configuración de la conexión a la base de datos
include_once '../config/database.php';

// Verifico si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtengo los datos del formulario
    $nombre = $_POST['nombre'] ?? null; 
    $email = $_POST['email'] ?? null; 
    $telefono = $_POST['telefono'] ?? null;
    $direccion = $_POST['direccion'] ?? null;  // Faltaba este campo
    $ciudad = $_POST['ciudad'] ?? null;
    $codigo_postal = $_POST['codigo_postal'] ?? null;

    
    // Valido los datos obligatorios (nombre y email según tu código original)
    if (empty($nombre) || empty($email)) {
        echo json_encode(["error" => "Nombre y email son obligatorios"]);
        exit;
    }

    try {
        // Creo la consulta SQL para insertar el cliente en la base de datos
        $sql = "INSERT INTO clientes 
        (nombre, email, telefono, direccion, ciudad, codigo_postal, fecha_creacion) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

        // Preparo la consulta SQL
        $stmt = $conexion->prepare($sql);

        // Ejecuto la consulta SQL
        $stmt->execute([
            $nombre, 
            $email, 
            $telefono,
            $direccion, 
            $ciudad, 
            $codigo_postal
        ]);
        
        // Si se ejecuta correctamente, muestro un mensaje de éxito
        echo json_encode([
            "mensaje" => "Cliente creado correctamente",
            "id" => $conexion->lastInsertId()
        ]);
        
    } catch (PDOException $e) {
        // Manejo de errores
        echo json_encode([
            "error" => "Error al crear cliente: " . $e->getMessage()
        ]);
    }
} else {
    // Si no es POST, devolver error
    echo json_encode([
        "error" => "Método no permitido. Use POST"
    ]);
}
?>