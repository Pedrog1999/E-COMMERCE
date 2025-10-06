<?php
require_once "../models/funciones.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    if (empty($usuario) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../views/register.php");
        exit;
    }

    //hasheamos contraseña, me faltaría verificar y comparar
    $hash = password_hash($password, PASSWORD_DEFAULT);

    
    $result = crearUsuario($usuario, $hash, 0); // admin=0 por defecto

    if ($result) {
        $_SESSION['success'] = "Account created successfully! You can log in now.";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error'] = "Username already exists.";
        header("Location: ../views/register.php");
        exit;
    }
}
?>
