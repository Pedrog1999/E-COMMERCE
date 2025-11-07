<?php
require_once "models/funciones.php";
session_start();

$token = $_GET['token'] ?? '';
if (!$token) {
    die("Invalid token");
}

$data = obtenerResetPorToken($token);
if (!$data || strtotime($data['expires_at']) < time()) {
    die("Token expired or invalid.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card animate__animated animate__fadeInDown">
            <h1 class="auth-title">Reset your password</h1>

            <form method="POST" action="controllers/ResetController.php">
                <input type="hidden" name="email" value="<?= htmlspecialchars($data['email']) ?>">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div class="form-group mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-input form-control" required>
                </div>

                <button type="submit" class="btn-auth">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>
