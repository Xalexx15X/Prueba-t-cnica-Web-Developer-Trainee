<?php

// Incluyo la configuración de la conexión a la base de datos
require_once "../config/database.php";

// Obtengo los datos en json y con el decode los obtengo en un array
$data = json_decode(file_get_contents("php://input"), true);

$clientes_id = $data["clientes_id"] ?? null;
$notas = $data["notas"] ?? null;
$productos = $data["productos"] ?? [];

// Valido los datos del formulario
if (!$clientes_id || empty($productos)) {
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

// Creo la consulta SQL para insertar el pedido en la base de datos
try {

    // Inicio transacción
    $conexion->beginTransaction();


    // añado cliente al pedido
    $sql = "INSERT INTO pedidos (clientes_id, fecha_pedido, estado, notas)
            VALUES (?, NOW(), 'pendiente', ?)";
    // Preparo la consulta SQL
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$clientes_id, $notas]); // Ejecuto la consulta SQL

    // Obtengo el id del pedido recién creado
    $pedido_id = $conexion->lastInsertId();

    // añado productos al pedido
    foreach ($productos as $producto) {

        // Obtener id del producto
        $productos_id = $producto["productos_id"];
        // Obtener cantidad del producto
        $cantidad = $producto["cantidad"]; 

        // obtengo el precio del producto
        $sqlProducto = "SELECT precio FROM productos WHERE id = ?";
        $stmtProducto = $conexion->prepare($sqlProducto);
        $stmtProducto->execute([$productos_id]);

        // obtengo los datos del producto
        $productoData = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        // si no se encuentra el producto, lanzo una excepción
        if (!$productoData) {
            throw new Exception("Producto no encontrado");
        }

        // obtengo el precio del producto
        $precio = $productoData["precio"];

        // Inserto el producto en la base de datos
        $sqlDetalle = "INSERT INTO detalle_pedidos 
                       (productos_id, pedidos_id, cantidad, precio_compra)
                       VALUES (?, ?, ?, ?)";

        // Preparo la consulta SQL
        $stmtDetalle = $conexion->prepare($sqlDetalle);
        $stmtDetalle->execute([
            $productos_id,
            $pedido_id,
            $cantidad,
            $precio
        ]);
    }

    // Confirmo la transacción
    $conexion->commit();

    // Si se ejecuta correctamente, muestro un mensaje de éxito
    echo json_encode([
        "mensaje" => "Pedido creado correctamente",
        "pedido_id" => $pedido_id
    ]);
} catch (Exception $e) {

    // Si hay un error, rollback y muestro el mensaje de error
    $conexion->rollBack();
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}