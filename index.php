<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Login</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    
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
                Forgot your password? <a href="#">Recover it</a><br>
                Don’t have an account? <a href="views/register.php">Create one</a>
            </p>
        </div>
    </div> 
           <div class="github-container">
  <a href="https://github.com/Pedrog1999/E-COMMERCE.git" target="_blank" class="github-button">
    <svg height="20" width="20" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;">
      <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 
        6.53 5.47 7.59.4.07.55-.17.55-.38 
        0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52
        -.01-.53.63-.01 1.08.58 1.23.82.72 1.21 
        1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78
        -.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82
        -2.15-.08-.2-.36-1.01.08-2.12 0 
        0 .67-.21 2.2.82a7.7 7.7 0 012 0c1.53-1.04 
        2.2-.82 2.2-.82.44 1.11.16 1.92.08 
        2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 
        3.75-3.65 3.95.29.25.54.73.54 
        1.48 0 1.07-.01 1.93-.01 2.2 
        0 .21.15.46.55.38A8.013 8.013 0 
        0016 8c0-4.42-3.58-8-8-8z"/>
    </svg>
    Open in GitHub
  </a>
</div>
    </footer>
</body>
</html>



