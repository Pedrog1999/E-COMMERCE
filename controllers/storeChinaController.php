<?php
require_once __DIR__ . '/../models/conexion.php';
require_once __DIR__ . '/../models/funciones.php';

$countryId = 3; // china
$porPagina = 6;
$pagina = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($pagina - 1) * $porPagina;

// Obtener productos
$productos = obtenerProductosPorPais($pdo, $countryId, $porPagina, $offset);

// Contar total
$totalProductos = contarProductosPorPais($pdo, $countryId);
$totalPaginas = ceil($totalProductos / $porPagina);
