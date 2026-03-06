<?php

// incluyo la configuración de la conexión a la base de datos
require_once "../config/database.php";

// creo la consulta sql para listar los pedidos en la base de datos
$sql = "SELECT 
            p.id AS pedido_id,
            p.fecha_pedido,
            p.estado,
            p.notas,
            c.nombre AS cliente,
            pr.nombre AS producto,
            dp.cantidad,
            dp.precio_compra
        FROM pedidos p
        JOIN clientes c ON p.clientes_id = c.id 
        JOIN detalle_pedidos dp ON p.id = dp.pedidos_id
        JOIN productos pr ON dp.productos_id = pr.id
        ORDER BY p.fecha_pedido DESC";

// preparo la consulta sql
$stmt = $conexion->prepare($sql);
// ejecuto la consulta sql
$stmt->execute();

// obtengo los datos de la consulta sql
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// si se ejecuta correctamente, muestro los datos de la consulta sql
echo json_encode([
    "pedidos" => $pedidos
]);