<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Backoffice</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Font Awesome (iconos) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/backoffice.css">
</head>
<body>
  <div class="container-fluid p-0 d-flex">
    
    <!-- SIDEBAR -->
    <aside class="sidebar d-flex flex-column">
      <div class="logo mb-4">Panel Admin</div>
      <nav class="menu nav flex-column gap-2">
        <a href="#" class="nav-link active d-flex align-items-center">
          <i class="fa-solid fa-box me-2"></i> Productos
        </a>
        <a href="#" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-warehouse me-2"></i> Stock
        </a>
        <a href="#" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-clock-rotate-left me-2"></i> Historial
        </a>
        <a href="../../index.php" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-right-from-bracket me-2"></i> Salir
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content flex-grow-1 animate__animated animate__fadeIn">
      <div class="section active">
        <h1 class="mb-3">Gestión de Productos</h1>

        <button class="btn btn-dark animate__animated animate__pulse animate__infinite" id="nuevoProducto">
          <i class="fa-solid fa-plus me-1"></i> Nuevo Producto
        </button>

        <table class="tabla table table-dark table-striped mt-4">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Remera Oversize</td>
              <td>$15.000</td>
              <td>20</td>
              <td>
                <button class="btn btn-sm btn-secondary me-1 animate__animated animate__fadeInUp">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="btn btn-sm btn-danger animate__animated animate__fadeInUp">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

  </div>
</body>
</html>
