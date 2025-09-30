<?php
require_once __DIR__ . "/../models/funciones.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $email = $_POST["email"] ?? "";
    $direccion = $_POST["direccion"] ?? "";

    if (!empty($nombre) && !empty($telefono) && !empty($email)) {
        agregarContacto($pdo, $nombre, $telefono, $email, $direccion);
    }

    
    header("Location: ../index.php");
exit();
} else {
    echo "Acceso inválido.";
}
?>