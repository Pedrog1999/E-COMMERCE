<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Login</title>

    <!-- Bootstrap moderno -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css para efectos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Google Fonts para modernidad -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- CSS propio -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card animate__animated animate__fadeInDown">
            <h1 class="login-title">Welcome to Giani Import Solutions</h1>
            <p class="login-subtitle">Enter your credentials to continue</p>
                
            <form method="POST" action="controllers/LoginController.php" id="login-form">
                
                <div class="form-group">
                    <label for="usuario"><i class="fa fa-user"></i> User</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Your user" required>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fa fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>

                <button type="submit" class="btn-login animate__animated animate__pulse">Log-in</button>
            </form>

            <p class="text-center mt-3 text-muted">
                ¿Forgot your password? <a href="#">Recover it</a>
            </p>
        </div>
    </div>
</body>
</html>



