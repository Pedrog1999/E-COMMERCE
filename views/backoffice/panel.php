<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';
require_once '../../models/ventasModels.php';

// --- Obtener país seleccionado ---
$selectedCountry = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;

// --- Obtener lista de países ---
$stmt = $pdo->query("SELECT id, name FROM countries ORDER BY name ASC");
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Obtener productos ---
if ($selectedCountry > 0) {
    $productos = $pdo->prepare("
        SELECT p.id, p.name, p.description, p.price, p.stock, c.name AS country_name
        FROM products p
        LEFT JOIN countries c ON p.country_id = c.id
        WHERE p.country_id = ?
        ORDER BY p.id DESC
    ");
    $productos->execute([$selectedCountry]);
    $productos = $productos->fetchAll(PDO::FETCH_ASSOC);
} else {
    $productos = obtenerProductos($pdo);
}

// --- Obtener ventas ---
$ventas = obtenerVentas($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/backoffice.css">
  <script src="https://kit.fontawesome.com/a2d0421c23.js" crossorigin="anonymous"></script>
  <style>
    .actions { display:flex; gap:8px; justify-content:center; }
    .sidebar { width:250px; min-height:100vh; background:#111; color:#fff; padding:20px; }
    .nav-link { color:#ccc; }
    .nav-link.active, .nav-link:hover { color:#fff; font-weight:500; }
    .main-content { background:#1f1f1f; color:#e4e4e4; min-height:100vh; }
    .btn-edit, .btn-delete { color:#fff; text-decoration:none; }
    .btn-edit:hover { color:#0dcaf0; }
    .btn-delete:hover { color:#dc3545; }
  </style>
</head>
<body>
  <div class="container-fluid p-0 d-flex">

    <!-- SIDEBAR -->
    <aside class="sidebar d-flex flex-column">
      <div class="logo mb-4 fs-4 fw-bold">Panel Admin</div>
      <nav class="menu nav flex-column gap-2">
        <a href="#" class="nav-link active d-flex align-items-center" onclick="mostrarSeccion('productos')">
          <i class="fa-solid fa-box me-2"></i> Products
        </a>
        <a href="#" class="nav-link d-flex align-items-center" onclick="mostrarSeccion('ventas')">
          <i class="fa-solid fa-clock-rotate-left me-2"></i> Sales history
        </a>
        <a href="../../index.php" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-right-from-bracket me-2"></i> Exit
        </a>
      </nav>
    </aside>

    <!-- MAIN -->
    <main class="main-content flex-grow-1 p-4">

      <!-- SECCIÓN PRODUCTOS -->
      <div class="section" id="productos">
        <h1 class="mb-3">Product management</h1>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <a href="addProduct.php" class="btn btn-dark me-2">
              <i class="fa-solid fa-plus me-1"></i> Add product
            </a>
          </div>
          <form method="GET" class="d-flex align-items-center">
            <select name="country_id" class="form-select me-2" style="width: 200px;" onchange="this.form.submit()">
              <option value="0">All countries</option>
              <?php foreach ($countries as $country): ?>
                <option value="<?= $country['id'] ?>" <?= ($selectedCountry === (int)$country['id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($country['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </form>
        </div>

        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">The product was added successfully.</div>
        <?php elseif (isset($_GET['deleted'])): ?>
          <div class="alert alert-warning">The product was deleted successfully.</div>
          <?php elseif (isset($_GET['updated'])): ?>
          <div class="alert alert-info">El producto fue actualizado correctamente.</div>
        <?php endif; ?>
        

        <table class="table table-dark table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Country</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($productos)): ?>
              <?php foreach ($productos as $p): ?>
                <tr>
                  <td><?= htmlspecialchars($p['name']) ?></td>
                  <td><?= htmlspecialchars($p['description']) ?></td>
                  <td>$<?= number_format($p['price'], 2, ',', '.') ?></td>
                  <td><?= htmlspecialchars($p['country_name'] ?? '—') ?></td>
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
                    <div class="actions">
                      <a href="editProduct.php?id=<?= $p['id'] ?>" class="btn-edit">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                      </a>
                      <a href="../../controllers/productsController.php?delete=<?= $p['id'] ?>"
                         class="btn-delete"
                         onclick="return confirm('¿Seguro que querés eliminar este producto?');">
                        <i class="fa-solid fa-trash me-1"></i> Delete
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted">No hay productos cargados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- SECCIÓN VENTAS -->
      <div class="section" id="ventas" style="display:none;">
        <h1 class="mb-3">Sales history</h1>
        <table class="table table-dark table-striped">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Product</th>
              <th>Price</th>
              <th>Address</th>
              <th>Postal Code</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($ventas)): ?>
              <?php foreach ($ventas as $v): ?>
                <tr>
                  <td><?= htmlspecialchars($v['nombre_apellido']) ?></td>
                  <td><?= htmlspecialchars($v['producto_nombre'] ?? '—') ?></td>
                  <td>$<?= number_format($v['producto_precio'] ?? 0, 2, ',', '.') ?></td>
                  <td><?= htmlspecialchars($v['direccion']) ?></td>
                  <td><?= htmlspecialchars($v['codigo_postal']) ?></td>
                  <td><?= date('d/m/Y H:i', strtotime($v['fecha_compra'])) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="text-center text-muted">No hay ventas registradas.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>

  <script>
  function mostrarSeccion(id) {
    document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
    document.getElementById(id).style.display = 'block';
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    event.target.closest('.nav-link').classList.add('active');
  }
  </script>
</body>
</html>
