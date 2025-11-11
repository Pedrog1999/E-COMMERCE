<?php
require_once 'conexion.php';

function obtenerVentas($pdo) {
    $stmt = $pdo->query("
        SELECT 
          c.id,
          c.nombre_apellido,
          c.tarjeta,
          c.codigo_postal,
          c.direccion,
          c.costo_envio,
          c.fecha_compra,
          p.name AS producto_nombre,
          p.price AS producto_precio
        FROM compras c
        LEFT JOIN products p ON c.product_id = p.id
        ORDER BY c.fecha_compra DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
