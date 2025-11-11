<?php
require_once __DIR__ . '/../models/conexion.php';
require_once __DIR__ . '/../models/funciones.php';

$country_id = 4; // Argentina
$porPagina = 6;
$pagina = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($pagina - 1) * $porPagina;

// Capturar orden (asc o desc)
$ordenPrecio = isset($_GET['orden']) && $_GET['orden'] === 'desc' ? 'desc' : 'asc';


// Obtener productos ordenados
$productos = obtenerProductosPorPaisOrdenados($pdo, $country_id, $porPagina, $offset, $ordenPrecio);

$totalProductos = contarProductosPorPais($pdo, $country_id);
$totalPaginas = ceil($totalProductos / $porPagina);
