<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';

if (!isset($_GET['id'])) {
  die("Proveedor no especificado");
}

$idProveedor = intval($_GET['id']);
$proveedor = obtenerProveedorPorId($pdo, $idProveedor);

if (!$proveedor) {
  die("Proveedor no encontrado");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($proveedor['name']) ?> | Proveedor</title>
  <link href="../../assets/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/proveedor.css" rel="stylesheet">
</head>
<body>
  <div class="proveedor-container">
    <div class="proveedor-card">
      <div class="proveedor-img-wrapper">
        <img src="../../<?= htmlspecialchars($proveedor['image']) ?>" alt="<?= htmlspecialchars($proveedor['name']) ?>" class="proveedor-img">
      </div>

      <div class="proveedor-info">
        <h1 class="proveedor-nombre"><?= htmlspecialchars($proveedor['name']) ?></h1>
        <p class="proveedor-ubicacion">📍 <?= htmlspecialchars($proveedor['location']) ?></p>
        <p class="proveedor-telefono">📞 <?= htmlspecialchars($proveedor['phone']) ?></p>

        <?php if (!empty($proveedor['description'])): ?>
          <p class="proveedor-descripcion"><?= nl2br(htmlspecialchars($proveedor['description'])) ?></p>
        <?php else: ?>
          
        <?php endif; ?>

        <a href="javascript:history.back()" class="volver-btn">Back</a>
      </div>
    </div>
  </div>
</body>
</html>
