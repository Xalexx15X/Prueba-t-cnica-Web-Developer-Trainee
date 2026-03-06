<?php
// Configuración de la conexión a la base de datos

// variables de conexión
$host = "localhost"; // Host de la base de datos
$dbname = "happymami"; // Nombre de la base de datos
$username = "root"; // Nombre de usuario
$password = "root"; // Contraseña

// Conexión a la base de datos con PDO
try {
    // Creo un objeto PDO con la conexión a la base de datos
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Establezco el modo de error en excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Si hay un error en la conexión, muestro el mensaje de error
    echo "Error de conexión: " . $e->getMessage();
    exit;
}