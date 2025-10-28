<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';
// Detecta automáticamente el path base del proyecto
$basePath = dirname(__DIR__, 2); // sube dos niveles desde frontend/
$baseUrl = str_replace($_SERVER['DOCUMENT_ROOT'], '', $basePath);

//paginación
$porPagina = 8; // 8 por pagina, a corregir
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$totalProductos = contarProductos($pdo);
$totalPaginas = ceil($totalProductos / $porPagina);
$offset = ($pagina - 1) * $porPagina;

// Obtener productos con límite
$productos = obtenerProductosPaginados($pdo, $porPagina, $offset);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tienda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .product-card {
      border-radius: 12px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .product-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .product-img {
      height: 220px;
      width: 100%;
      object-fit: cover;
    }
    .product-info {
      padding: 1rem;
    }
    .product-name {
      font-size: 1.1rem;
      font-weight: 600;
    }
    .product-price {
      font-size: 1.1rem;
      color: #28a745;
      font-weight: 600;
    }
    .pagination .page-link {
      color: #000;
      border: none;
    }
    .pagination .active .page-link {
      background-color: #000;
      color: #fff;
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <h1 class="text-center mb-4">All-Products</h1>

    <?php if (empty($productos)): ?>
      <div class="text-center text-muted fs-5">No hay productos disponibles.</div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($productos as $p): ?>
          <?php
            $imagenes = obtenerImagenesProducto($pdo, $p['id']);
           $img = !empty($imagenes)
  ? '../../' . htmlspecialchars($imagenes[0])
  : 'https://via.placeholder.com/300x220?text=Sin+imagen';



          ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="product-card h-100">
              <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="product-img">
              <div class="product-info">
                <div class="product-name mb-2"><?= htmlspecialchars($p['name']) ?></div>
                <div class="text-muted mb-2"><?= htmlspecialchars($p['description']) ?></div>
                <div class="product-price mb-3">$<?= number_format($p['price'], 2, ',', '.') ?></div>
                <button class="btn btn-dark w-100">Agregar al carrito</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <nav class="mt-5">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
              <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>

</body>
</html>

<?php // paginadores 
// tabla de imagenes foreng key a la tabla de productos
// ruta con una misma columna en productos 
