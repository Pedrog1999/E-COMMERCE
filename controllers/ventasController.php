<?php
require_once '../models/conexion.php';
require_once '../models/ventasModel.php';

$ventas = obtenerVentas($pdo);

// Si el controlador se llama directamente por AJAX
if (isset($_GET['json'])) {
    header('Content-Type: application/json');
    echo json_encode($ventas);
    exit;
}
