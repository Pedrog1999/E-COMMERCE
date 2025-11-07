<?php
require_once '../../../controllers/storeChinaController.php';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>China Store</title>
  <link href="../../../assets/bootstrap.min.css" rel="stylesheet">
  <link href="../../../assets/storeChina.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <h1>欢迎来到中国商店！</h1>
    <p>我们受到顶级品牌的支持。对我们的怀疑往往更多地说明了您自己。</p>

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

    <!-- PAGINADOR -->
    <div class="pagination">
      <?php if ($pagina > 1): ?>
        <a href="?page=<?= $pagina - 1 ?>" class="page-link">&laquo; 上一页</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="?page=<?= $i ?>" class="page-link <?= $i == $pagina ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>

      <?php if ($pagina < $totalPaginas): ?>
        <a href="?page=<?= $pagina + 1 ?>" class="page-link">下一页 &raquo;</a>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
