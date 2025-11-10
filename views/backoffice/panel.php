<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';

// Obtener país seleccionado (si hay)
$selectedCountry = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;

// Obtener lista de países
$stmt = $pdo->query("SELECT id, name FROM countries ORDER BY name ASC");
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener productos (por país o todos)
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
  </style>
</head>
<body>
  <div class="container-fluid p-0 d-flex">

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

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <a href="addProduct.php" class="btn btn-dark me-2">
              <i class="fa-solid fa-plus me-1"></i> Add product
            </a>
          </div>
          <form method="GET" class="d-flex align-items-center">
            <select name="country_id" class="form-select me-2" style="width: 200px;">
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
        <?php endif; ?>

        <table class="table table-dark table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Stock</th>
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
                  <td><?= htmlspecialchars($p['stock'] ?? 0) ?></td>
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
                      <!-- CORRECCIÓN: usamos $p['id'] y ruta correcta ../../controllers/... -->
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
    </main>
  </div>
<script>
const countrySelect = document.querySelector('select[name="country_id"]');
const tbody = document.querySelector('tbody');

countrySelect.addEventListener('change', async () => {
  const countryId = countrySelect.value;

  const response = await fetch(`../../controllers/fetchProducts.php?country_id=${countryId}`);
  const productos = await response.json();

  tbody.innerHTML = productos.length
    ? productos.map(p => `
      <tr>
        <td>${p.name}</td>
        <td>${p.description}</td>
        <td>$${parseFloat(p.price).toFixed(2)}</td>
        <td>${p.stock}</td>
        <td>${p.country_name ?? '—'}</td>
        <td>
          ${p.first_image
            ? `<img src="../../${p.first_image}" width="80" height="80" style="object-fit:cover;border-radius:6px;">`
            : `<span class="text-muted">Sin imagen</span>`}
        </td>
        <td>
          <div class="actions">
            <a href="editProduct.php?id=${p.id}" class="btn-edit">
              <i class="fa-solid fa-pen-to-square me-1"></i> Edit
            </a>
            <a href="../../controllers/productsController.php?delete=${p.id}"
               class="btn-delete"
               onclick="return confirm('¿Seguro que querés eliminar este producto?');">
              <i class="fa-solid fa-trash me-1"></i> Delete
            </a>
          </div>
        </td>
      </tr>
    `).join('')
    : `<tr><td colspan="7" class="text-center text-muted">No hay productos cargados.</td></tr>`;
});
</script>


</body>
</html>
