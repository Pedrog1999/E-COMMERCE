<?php
require_once '../models/conexion.php';
require_once '../models/funciones.php';

// ✅ Si viene por GET con ?delete=ID → eliminar producto
if (isset($_GET['delete'])) {
    $productId = intval($_GET['delete']);

    try {
        eliminarProducto($pdo, $productId);
        header("Location: ../views/backoffice/panel.php?deleted=1");
        exit;
    } catch (Exception $e) {
        error_log("Error al eliminar producto: " . $e->getMessage());
        header("Location: ../views/backoffice/panel.php?errorDelete=1");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : null;

    $providerId = null;

    try {
        // Si el país es Japón, agregamos proveedor
        if ($country_id === 1) {
            $providerName = trim($_POST['provider_name'] ?? '');
            $providerLocation = trim($_POST['provider_location'] ?? '');
            $providerPhone = trim($_POST['provider_phone'] ?? '');
            $providerImagePath = null;

            if (!empty($_FILES['provider_image']['name'])) {
                $uploadDir = "../assets/uploads/providers/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . "_" . basename($_FILES['provider_image']['name']);
                $targetFile = $uploadDir . $fileName;
                move_uploaded_file($_FILES['provider_image']['tmp_name'], $targetFile);
                $providerImagePath = "assets/uploads/providers/$fileName";
            }

            if ($providerName) {
                $providerId = agregarProveedor($pdo, $providerName, $providerLocation, $providerPhone, $providerImagePath);
            }
        }

        // Insertamos el producto
        $sql = "INSERT INTO products (name, description, price, stock, country_id, provider_id)
                VALUES (:name, :description, :price, :stock, :country_id, :provider_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":description" => $description,
            ":price" => $price,
            ":stock" => $stock,
            ":country_id" => $country_id,
            ":provider_id" => $providerId
        ]);
        $productId = $pdo->lastInsertId();

        // 📁 Ahora sí definimos el directorio con el ID correcto
        $uploadDir = "../assets/uploads/products/$productId/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        // Manejo de imágenes del producto
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                    $fileName = basename($_FILES['images']['name'][$index]);
                    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
                    $targetFile = $uploadDir . $fileName;
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
