<?php
require_once '../models/conexion.php';
require_once '../models/funciones.php';
$uploadDir = __DIR__ . "/../assets/uploads/products/$productId/";

// === AGREGAR PRODUCTO === //
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $id_countries = null; // lo dejamos null por ahora

    try {
        // 1️⃣ Insertamos el producto y obtenemos su ID
        $productId = agregarProducto($pdo, $name, $description, $price, $stock, $id_countries);

        // 2️⃣ Si se subieron imágenes, procesarlas
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = "../assets/uploads/products/$productId/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                    $fileName = basename($_FILES['images']['name'][$index]);
                    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName); // limpieza de nombre
                    $targetFile = $uploadDir . $fileName;

                    // mover archivo
                    if (move_uploaded_file($tmpName, $targetFile)) {
                        $relativePath = "assets/uploads/products/$productId/$fileName";
                        guardarImagenProducto($pdo, $productId, $relativePath);
                    }
                }
            }
        }

        header("Location: ../views/backoffice/panel.php?success=1");
        exit;

    } catch (Exception $e) {
        error_log("Error al agregar producto: " . $e->getMessage());
        header("Location: ../views/backoffice/addProduct.php?error=1");
        exit;
    }
}


// === ELIMINAR PRODUCTO === //
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    try {
        if (eliminarProducto($pdo, $id)) {
            // 🧹 eliminar carpeta del producto si existe
            $dir = "../assets/uploads/products/$id";
            if (is_dir($dir)) {
                $files = glob("$dir/*");
                foreach ($files as $file) {
                    if (is_file($file)) unlink($file);
                }
                rmdir($dir);
            }

            header("Location: ../views/backoffice/panel.php?deleted=1");
            exit;
        } else {
            header("Location: ../views/backoffice/panel.php?error=1");
            exit;
        }

    } catch (Exception $e) {
        error_log("Error al eliminar producto: " . $e->getMessage());
        header("Location: ../views/backoffice/panel.php?error=1");
        exit;
    }
}
