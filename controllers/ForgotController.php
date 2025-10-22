<?php
require_once "../models/funciones.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');

    if (empty($email)) {
        $_SESSION['error'] = "Please enter your email.";
        header("Location: ../forgot.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address.";
        header("Location: ../forgot.php");
        exit;
    }

    // Verificar que el mail exista
    if (!existeEmail($email)) {
        $_SESSION['error'] = "This email is not registered.";
        header("Location: ../forgot.php");
        exit;
    }

    // Generar token y expiración (30 minutos)
    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', time() + 1800);

    guardarTokenRecuperacion($email, $token, $expires);

    // En una app real, se enviaría por mail:
    $_SESSION['success'] = "Recovery link (for test): recuperar.php?token=$token";
    header("Location: ../forgot.php");
    exit;
}
?>
