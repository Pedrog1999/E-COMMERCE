<?php
require_once __DIR__ . "/../models/funciones.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    eliminarContacto($pdo, $id);
}

header("Location: ../index.php");
exit();