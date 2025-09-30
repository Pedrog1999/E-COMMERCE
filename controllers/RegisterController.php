<?php
require_once "../models/funciones.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    if (empty($usuario) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../register.php");
        exit;
    }

    // Hashear contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Intentar crear usuario
    $result = crearUsuario($usuario, $hash, 0); // admin=0 por defecto

    if ($result) {
        $_SESSION['success'] = "Account created successfully! You can log in now.";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error'] = "Username already exists.";
        header("Location: ../register.php");
        exit;
    }
}
?>
