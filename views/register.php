<?php
session_start();

function mostrarMensaje($tipo) {
    if (isset($_SESSION[$tipo])) {
        echo '<div class="alert alert-' . ($tipo === 'error' ? 'danger' : 'success') . ' text-center">' . $_SESSION[$tipo] . '</div>';
        unset($_SESSION[$tipo]);
        session_write_close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

</head>
<body>
    <div class="auth-container">
        <div class="auth-card animate__animated animate__fadeInDown">
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Please, complete the form to register</p>
            
<?= mostrarMensaje('error'); ?>
<?= mostrarMensaje('success'); ?>

            
            <form method="POST" action="../controllers/RegisterController.php">
                <div class="form-group">
                    <label for="usuario" class="form-label">Username</label>
                    <input type="text" id="usuario" name="usuario" class="form-input" placeholder="Choose a username" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="********" required>
                </div>

                <button type="submit" class="btn-auth animate__animated animate__pulse">Register</button>
            </form>

            <p class="auth-footer">
                Already have an account? <a href="../index.php">Log in</a>
            </p>
        </div>
    </div>
</body>
</html>
