<?php
require_once '../../../controllers/storeArgentinaController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tienda Argentina</title>
  <link href="../../../assets/bootstrap.min.css" rel="stylesheet">
  <link href="../../../assets/storeArgentina.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <h1>¡Bienvenido a Argentina!</h1>
    <p>Orgullo, calidad y pasión por lo nuestro. Descubrí los mejores productos argentinos.</p>

    <div class="product-grid">
      <?php foreach ($productos as $producto): ?>
        <?php
          $imagenes = obtenerImagenesProducto($pdo, $producto['id']);
          $imgSrc = !empty($imagenes) ? "../../../" . htmlspecialchars($imagenes[0]) : "../../../assets/img/no-image.jpg";
        ?>
        <div class="product-card">
          <div class="product-img-wrapper">
            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($producto['name']) ?>" class="product-img">
          </div>
          <div class="product-info">
            <h3 class="product-name"><?= htmlspecialchars($producto['name']) ?></h3>
            <p class="product-desc"><?= htmlspecialchars($producto['description']) ?></p>
            <span class="product-price">$<?= number_format($producto['price'], 2) ?></span>
           <button class="comprar-btn" onclick="window.location.href='../compra.php?id=<?= $producto['id'] ?>'">
  🛒 Comprar ahora
</button>

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


<?php
session_start();

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success text-center" style="margin:20px;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center" style="margin:20px;">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

</body>

</html>
