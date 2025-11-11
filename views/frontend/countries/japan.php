<?php
require_once '../../../controllers/storeJapanController.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Japan Store</title>
  <link href="../../../assets/bootstrap.min.css" rel="stylesheet">
  <link href="../../../assets/storeJapan.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <h1>日本へようこそ！</h1>
    <p>当社は大手ブランドに支えられています。当社に対して疑念を抱くことは、当社についてよりもむしろお客様について多くを物語っています。</p>

    <div class="filter-bar">
    <span class="filter-label">Ordenar por precio:</span>
    <a href="?orden=asc" class="filter-btn <?= (isset($_GET['orden']) && $_GET['orden'] === 'asc') ? 'active' : '' ?>">Menor a mayor</a>
    <a href="?orden=desc" class="filter-btn <?= (isset($_GET['orden']) && $_GET['orden'] === 'desc') ? 'active' : '' ?>">Mayor a menor</a>
  </div>
  
    <div class="product-grid">
      <?php foreach ($productos as $producto): ?>
        <?php
          $imagenes = obtenerImagenesProducto($pdo, $producto['id']);
          $imgSrc = !empty($imagenes) ? "../../../" . htmlspecialchars($imagenes[0]) : "../../../assets/img/no-image.jpg";
          $proveedorId = htmlspecialchars($producto['provider_id'] ?? '');

        ?>

        <div class="product-card" onclick="window.location.href='../proveedor.php?id=<?= $proveedorId ?>'">

          <div class="product-img-wrapper">
            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($producto['name']) ?>" class="product-img">
          </div>
          <div class="product-info">
            <h3 class="product-name"><?= htmlspecialchars($producto['name']) ?></h3>
            <p class="product-desc"><?= htmlspecialchars($producto['description']) ?></p>
            <span class="product-price">$<?= number_format($producto['price'], 2) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="pagination">
      <?php if ($pagina > 1): ?>
        <a href="?page=<?= $pagina - 1 ?>" class="page-link">&laquo; Anterior</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="?page=<?= $i ?>" class="page-link <?= $i == $pagina ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>

      <?php if ($pagina < $totalPaginas): ?>
        <a href="?page=<?= $pagina + 1 ?>" class="page-link">Siguiente &raquo;</a>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
