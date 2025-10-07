<?php
// MODO DEMO: muestra el hash almacenado de la contraseña del usuario (solo local).
require_once __DIR__ . "/../models/conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/recover.php");
    exit;
}

$username = trim($_POST['usuario'] ?? '');

if ($username === '') {
    $_SESSION['error'] = "Por favor ingresa un usuario.";
    header("Location: ../views/recoverit.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT password FROM users WHERE name = :u LIMIT 1");
    $stmt->execute([":u" => $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $_SESSION['error'] = "Usuario no encontrado.";
        header("Location: ../views/recoverit.php");
        exit;
    }

    $hash = $row['password'];

    $msg = "<strong> Here's your hash, sir. " . htmlspecialchars($username) . ":</strong><br><code>" . htmlspecialchars($hash) . "</code>";
    $_SESSION['success'] = $msg;
    header("Location: ../views/recoverit.php");
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("Location: ../views/recoverit.php");
    exit;
}
