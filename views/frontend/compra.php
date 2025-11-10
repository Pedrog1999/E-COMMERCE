<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$producto = obtenerProductoPorIdd($pdo, $productId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Finalizar compra</title>
  <link href="../../assets/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/compra.css" rel="stylesheet">
</head>
<body>

  <div class="compra-card">
    <h2>Finalizar compra</h2>

    <?php if ($producto): ?>
      <p><strong>Producto:</strong> <?= htmlspecialchars($producto['name']) ?></p>
      <p><strong>Precio:</strong> $<?= number_format($producto['price'], 2) ?></p>
      <hr>
    <?php else: ?>
      <p>❌ Producto no encontrado.</p>
    <?php endif; ?>

    <form action="../../controllers/compraController.php" method="POST" id="compraForm">
      <input type="hidden" name="product_id" value="<?= $productId ?>">

      <div class="mb-3">
        <label>Nombre y apellido</label>
        <input type="text" name="nombre_apellido" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Número de tarjeta</label>
        <input type="text" name="tarjeta" class="form-control" maxlength="16" required>
      </div>

      <div class="mb-3">
        <label>Código postal</label>
        <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Dirección de envío</label>
        <input type="text" name="direccion" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Costo de envío:</label>
        <input type="text" id="envio" class="form-control" readonly>
      </div>

      <button type="submit" class="btn-comprar">Confirmar compra</button>
    </form>
  </div>

  <script>
    const cpInput = document.getElementById('codigo_postal');
    const envioInput = document.getElementById('envio');

    cpInput.addEventListener('input', () => {
      const cp = parseInt(cpInput.value);
      let envio = 0;

      if (isNaN(cp)) {
        envioInput.value = '';
        return;
      }

      if (cp >= 1000 && cp < 2000) envio = 2500;
      else if (cp >= 2000 && cp < 3000) envio = 3500;
      else if (cp >= 3000 && cp < 4000) envio = 4000;
      else envio = 5000;

      envioInput.value = "$" + envio.toLocaleString();
    });
  </script>
</body>
</html>
