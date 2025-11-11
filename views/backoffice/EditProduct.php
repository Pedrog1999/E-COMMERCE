<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';

// --- Validar ID ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: panel.php?error=invalidId");
    exit;
}

$productId = intval($_GET['id']);
$producto = obtenerProductoPorId($pdo, $productId);

if (!$producto) {
    header("Location: panel.php?error=notFound");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/backoffice.css">
</head>
<body class="bg-dark text-light">
  <div class="container py-5">
    <a href="panel.php" class="btn btn-secondary mb-4">&larr; Volver al panel</a>

    <div class="card bg-secondary text-light shadow-lg">
      <div class="card-body">
        <h2 class="mb-4">Editar producto</h2>

        <form action="../../controllers/ProductsController.php" method="POST">
          <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
          <input type="hidden" name="updateProduct" value="1">

          <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= htmlspecialchars($producto['name']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($producto['description']) ?></textarea>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price"
                   value="<?= htmlspecialchars($producto['price']) ?>" required>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="panel.php" class="btn btn-outline-light">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
