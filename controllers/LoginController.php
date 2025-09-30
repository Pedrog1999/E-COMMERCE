<?php
require_once "../models/funciones.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE admin = :admin");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION['usuario'] = $user["name"];
        $_SESSION['admin'] = $user["admin"];

        if ($user["admin"] == 1) {
            header("Location: ../views/backoffice.php");
        } else {
            header("Location: ../views/store.php");
        }
        exit;
    } else {
        $_SESSION['error'] = "Invalid credentials.";
        header("Location: ../index.php");
        exit;
    }
}

