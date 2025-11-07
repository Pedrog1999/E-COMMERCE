<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';

// aca obtengo productos
$productos = obtenerProductos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/backoffice.css">
  <script src="https://kit.fontawesome.com/a2d0421c23.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container-fluid p-0 d-flex">

    <!-- SIDEBAR -->
    <aside class="sidebar d-flex flex-column">
      <div class="logo mb-4">Panel Admin</div>
      <nav class="menu nav flex-column gap-2">
        <a href="panel.php" class="nav-link active d-flex align-items-center">
          <i class="fa-solid fa-box me-2"></i> Products
        </a>
        <a href="#" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-clock-rotate-left me-2"></i> Sales history
        </a>
        <a href="../../index.php" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-right-from-bracket me-2"></i> Exit
        </a>
      </nav>
    </aside>

    <main class="main-content flex-grow-1 p-4">
      <div class="section active">
        <h1 class="mb-3">Product management</h1>

        <a href="addProduct.php" class="btn btn-dark mb-4">
          <i class="fa-solid fa-plus me-1"></i> Add product
        </a>

        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">The product was added successfully.</div>
        <?php elseif (isset($_GET['deleted'])): ?>
          <div class="alert alert-warning">The product was deleted successfully.</div>
        <?php endif; ?>

        <table class="table table-dark table-striped">
          <thead>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Country</th> <!-- ✅ nueva columna -->
    <th>Images</th>
    <th>Actions</th>
  </tr>
</thead>
<tbody>
  <?php if (!empty($productos)): ?>
    <?php foreach ($productos as $p): ?>
    <tr>
      <td><?= $p['id'] ?></td>
      <td><?= htmlspecialchars($p['name']) ?></td>
      <td><?= htmlspecialchars($p['description']) ?></td>
      <td>$<?= number_format($p['price'], 2, ',', '.') ?></td>
      <td><?= $p['stock'] ?></td>
      <td><?= htmlspecialchars($p['country_name'] ?? '—') ?></td> <!-- ✅ muestra país o guion -->
      <td>
        <?php
          $imagenes = obtenerImagenesProducto($pdo, $p['id']);
          if (!empty($imagenes)) {
              echo '<img src="../../' . htmlspecialchars($imagenes[0]) . '" width="80" height="80" style="object-fit:cover;border-radius:6px;">';
          } else {
              echo '<span class="text-muted">Sin imagen</span>';
          }
        ?>
      </td>
      <td>
        <a href="editProduct.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary me-1">
          <i class="fa-solid fa-pen-to-square">UPDATE</i>
        </a>
        <a href="../../controllers/productsController.php?delete=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">
          <i class="fa-solid fa-trash">DELETE</i>
        </a>
      </td>
    </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="8" class="text-center text-muted">No hay productos cargados.</td>
    </tr>
  <?php endif; ?>
</tbody>

        </table>
      </div>
    </main>
  </div>
</body>
</html>
