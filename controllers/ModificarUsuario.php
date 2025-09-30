<?php
require_once __DIR__ . "/../models/funciones.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    actualizarContacto($pdo, $id, $nombre, $telefono, $email, $direccion);

    header("Location: ../index.php");
    exit();
} else {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $contacto = obtenerContactoPorId($pdo, $id);

        if (!$contacto) {
            header("Location: ../index.php");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contacto</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Contacto</h2>
        <form method="POST" action="ModificarUsuario.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($contacto['id']) ?>">

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($contacto['nombre']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($contacto['telefono']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($contacto['email']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Dirección</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($contacto['direccion']) ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <a href="../index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>