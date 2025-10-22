<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';

// $productos = getAllProducts($conn);
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
          <i class="fa-solid fa-box me-2"></i> Productos
        </a>
        <a href="#" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-clock-rotate-left me-2"></i> Historial
        </a>
        <a href="../../index.php" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-right-from-bracket me-2"></i> Salir
        </a>
      </nav>
    </aside>

    
    <main class="main-content flex-grow-1 animate__animated animate__fadeIn">
      <div class="section active">
        <h1 class="mb-3">Gestión de Productos</h1>

        <a href="addProduct.php" class="btn btn-dark">
          <i class="fa-solid fa-plus me-1"></i> Nuevo Producto
        </a>

        <table class="table table-dark table-striped mt-4">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>País</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($productos as $p): ?>
            <tr>
              <td><?= $p['id'] ?></td>
              <td><?= htmlspecialchars($p['name']) ?></td>
              <td><?= htmlspecialchars($p['description']) ?></td>
              <td>$<?= number_format($p['price'], 2, ',', '.') ?></td>
              <td><?= $p['stock'] ?></td>
              <td><?= $p['country_name'] ?></td>
              <td>
                <a href="editProduct.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary me-1">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="../../controllers/productsController.php?delete=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
