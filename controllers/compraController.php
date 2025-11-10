<?php
require_once '../models/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $nombre_apellido = trim($_POST['nombre_apellido']);
    $tarjeta = trim($_POST['tarjeta']);
    $codigo_postal = trim($_POST['codigo_postal']);
    $direccion = trim($_POST['direccion']);

    if ($product_id && $nombre_apellido && $tarjeta && $codigo_postal && $direccion) {
        try {
            // Registrar compra
            $sql = "INSERT INTO compras (product_id, nombre_apellido, tarjeta, codigo_postal, direccion, fecha_compra)
                    VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$product_id, $nombre_apellido, $tarjeta, $codigo_postal, $direccion]);

            // Marcar producto como vendido
            $update = $pdo->prepare("UPDATE products SET estado = 'vendido' WHERE id = ?");
            $update->execute([$product_id]);

            // Mensaje de éxito
            $_SESSION['success'] = "✅ COMPRA EXITOSA, PUEDE SEGUIR EXPLORANDO LOS PRODUCTOS.";

            // Redirigir a la página de Argentina
            header("Location: ../views/frontend/countries/argentina.php");
            exit;

        } catch (PDOException $e) {
            $_SESSION['error'] = "❌ Error al registrar la compra: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "⚠️ Por favor completá todos los campos.";
    }
}

// Si hubo error, redirige de nuevo al formulario
header("Location: ../views/frontend/compra.php?id=" . $product_id);
exit;
