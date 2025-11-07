<?php
require_once '../../models/conexion.php';

$stmt = $pdo->query("SELECT id, name FROM countries ORDER BY name ASC");
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto</title>
  <link rel="stylesheet" href="../../assets/addproduct.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
  <div class="container py-5">
    <h1 class="mb-4">Add Product</h1>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger">Ocurrió un error al agregar el producto.</div>
    <?php endif; ?>

    <form action="../../controllers/productsController.php" method="POST" enctype="multipart/form-data" class="bg-secondary p-4 rounded">

      <!-- PRODUCTO -->
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Country</label>
        <select id="country" name="country_id" class="form-control" required>
          <option value="">Select a country</option>
          <?php foreach ($countries as $country): ?>
            <option value="<?= $country['id'] ?>"><?= htmlspecialchars($country['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- CAMPOS PROVEEDOR -->
      <div id="providerFields" class="bg-dark p-3 rounded mt-4" style="display: none;">
        <h5 id="providerTitle">Proveedor</h5>
        <div class="mb-2">
          <label class="form-label">Nombre del proveedor</label>
          <input type="text" name="provider_name" class="form-control">
        </div>
        <div class="mb-2">
          <label class="form-label">Ubicación</label>
          <input type="text" name="provider_location" class="form-control">
        </div>
        <div class="mb-2">
          <label class="form-label">Teléfono</label>
          <input type="text" name="provider_phone" class="form-control">
        </div>
        <div class="mb-2">
          <label class="form-label">Imagen del proveedor</label>
          <input type="file" name="provider_image" class="form-control" accept="image/*">
        </div>
      </div>

      <div class="mb-3 mt-4">
        <label for="images" class="form-label">Images</label>
        <input type="file" class="form-control" name="images[]" multiple accept="image/*">
      </div>

      <button type="submit" class="btn btn-light">Save</button>
      <a href="panel.php" class="btn btn-outline-light">Back</a>
    </form>
  </div>

  <script>
const countrySelect = document.getElementById('country');
const providerFields = document.getElementById('providerFields');
const providerTitle = providerFields.querySelector('h5');

countrySelect.addEventListener('change', () => {
  if (countrySelect.value == '1') { // Japón
    providerFields.style.display = 'block';
    providerTitle.textContent = 'Proveedor (solo Japón)';
  } else if (countrySelect.value == '2') { // USA
    providerFields.style.display = 'block';
    providerTitle.textContent = 'Proveedor (Estados Unidos)';
  } else if (countrySelect.value == '3') { // China
    providerFields.style.display = 'block';
    providerTitle.textContent = 'Proveedor (China)';
  } else {
    providerFields.style.display = 'none';
  }
});
</script>


</body>
</html>
