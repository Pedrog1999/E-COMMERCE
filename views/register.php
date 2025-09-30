<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Create Account</h1>
            <p class="login-subtitle">Fill the form to register</p>
            
            <form method="POST" action="controllers/RegisterController.php">
                <div class="form-group">
                    <label for="usuario"><i class="fa fa-user"></i> User</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Choose a username" required>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fa fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>

                <button type="submit" class="btn-login">Register</button>
            </form>

            <p class="text-center mt-3 text-muted">
                Already have an account? <a href="index.php">Log in</a>
            </p>
        </div>
    </div>
</body>
</html>
