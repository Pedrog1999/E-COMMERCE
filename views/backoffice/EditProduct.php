<?php
require_once '../../models/conexion.php';
require_once '../../models/funciones.php';

// === AGREGAR PRODUCTO ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $id_countries = null;

    if (agregarProducto($pdo, $name, $description, $price, $stock, $id_countries)) {
        header("Location: ../views/backoffice/panel.php?success=1");
        exit;
    } else {
        header("Location: ../views/backoffice/addProduct.php?error=1");
        exit;
    }
}

// === ACTUALIZAR PRODUCTO ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $id_countries = null;

    if (actualizarProducto($pdo, $id, $name, $description, $price, $stock, $id_countries)) {
        header("Location: ../views/backoffice/panel.php?updated=1");
        exit;
    } else {
        header("Location: ../views/backoffice/editProduct.php?id={$id}&error=1");
        exit;
    }
}

// === ELIMINAR PRODUCTO ===
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (eliminarProducto($pdo, $id)) {
        header("Location: ../views/backoffice/panel.php?deleted=1");
        exit;
    } else {
        header("Location: ../views/backoffice/panel.php?error=1");
        exit;
    }
}
