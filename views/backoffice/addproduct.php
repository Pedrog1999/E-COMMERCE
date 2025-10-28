<?php
require_once '../../models/conexion.php';
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
      <div class="alert alert-danger"> Ocurrió un error al agregar el producto.</div>
    <?php endif; ?>

    <form action="../../controllers/productsController.php" method="POST" enctype="multipart/form-data" class="bg-secondary p-4 rounded">

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
        <label for="images" class="form-label">Images</label>
        <input type="file" class="form-control" name="images[]" multiple accept="image/*">
        </div>

      <button type="submit" class="btn btn-light">Save</button>
      <a href="panel.php" class="btn btn-outline-light">Back</a>
    </form>
  </div>
</body>
</html>
