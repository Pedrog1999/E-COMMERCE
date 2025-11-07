<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recover Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/register.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card animate__animated animate__fadeInDown">
            <h1 class="auth-title">Recover Password</h1>
            <p class="auth-subtitle">Enter your email to reset your password</p>

            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger text-center">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success text-center">'.$_SESSION['success'].'</div>';
                unset($_SESSION['success']);
            }
            ?>

            <form method="POST" action="controllers/ForgotController.php">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-input form-control" placeholder="you@example.com" required>
                </div>

                <button type="submit" class="btn-auth">Send recovery link</button>
            </form>

            <p class="auth-footer mt-3">
                <a href="index.php">Back to login</a>
            </p>
        </div>
    </div>
</body>
</html>
