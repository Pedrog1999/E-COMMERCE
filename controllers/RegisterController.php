<?php
require_once "../models/funciones.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($usuario) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../views/register.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header("Location: ../views/register.php");
        exit;
    }

    // Hasheamos la contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    
    $result = crearUsuario($usuario, $hash, 0, $email); // admin = 0

    if ($result) {
        $_SESSION['success'] = "Account created successfully! You can log in now.";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error'] = "Username or email already exists.";
        header("Location: ../views/register.php");
        exit;
    }
}
?>
