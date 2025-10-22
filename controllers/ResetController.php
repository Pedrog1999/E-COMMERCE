<?php
require_once "../models/funciones.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $token = trim($_POST["token"]);
    $password = trim($_POST["password"]);

    $data = obtenerResetPorToken($token);
    if (!$data || $data['email'] !== $email || strtotime($data['expires_at']) < time()) {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: ../forgot.php");
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    if (actualizarPasswordPorEmail($email, $hash)) {
        // Borrar el token usado
        $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);
        $_SESSION['success'] = "Password updated successfully! You can log in now.";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error'] = "Error updating password.";
        header("Location: ../forgot.php");
        exit;
    }
}
?>
