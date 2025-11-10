<?php
require_once '../models/conexion.php';
require_once '../models/funciones.php';

$countryId = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;

if ($countryId > 0) {
    $stmt = $pdo->prepare("
        SELECT p.id, p.name, p.description, p.price, p.stock, c.name AS country_name
        FROM products p
        LEFT JOIN countries c ON p.country_id = c.id
        WHERE p.country_id = ?
        ORDER BY p.id DESC
    ");
    $stmt->execute([$countryId]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $productos = obtenerProductos($pdo);
}

// Agregar la primera imagen de cada producto
foreach ($productos as &$p) {
    $imagenes = obtenerImagenesProducto($pdo, $p['id']);
    $p['first_image'] = $imagenes[0] ?? null;
}

echo json_encode($productos);
