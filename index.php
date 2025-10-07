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
  <title>E-commerce Login</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="assets/style.css">

</head>
<body>
  <!-- Solapa de tecnologías arriba a la izquierda -->
  <div style="position: absolute; top: 20px; left: 20px; z-index: 100;">
    <a href="views/tecnologias.php" class="btn btn-info">
      <i class="fa fa-cogs"></i> Tecnologías
    </a>
  </div>
  

<button id="freno-button" class="freno" title="Activar/Desactivar freno">
  
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="40" height="40">
    <polygon points="30,0 90,0 120,30 120,90 90,120 30,120 0,90 0,30" fill="red" stroke="white" stroke-width="6"/>
    <text x="50%" y="60%" text-anchor="middle" fill="white" font-size="32" font-family="Arial Black" dy=".3em">STOP</text>
  </svg>

</button>


  <div class="login-container">
    <div class="login-card animate__animated animate__fadeInDown">
      <h1 class="login-title">Welcome to Giani Import Solutions</h1>
      <p class="login-subtitle">Enter your credentials to continue</p>

      <?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger text-center">
    <?= $_SESSION['error']; ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?= mostrarMensaje('error'); ?>
<?= mostrarMensaje('success'); ?>


              
      <form method="POST" action="controllers/LoginController.php" id="login-form">
        <div class="form-group">
          <label for="usuario"><i class="fa fa-user"></i> User</label>
          <input type="text" id="usuario" name="usuario" placeholder="Your user">
        </div>

        <div class="form-group">
          <label for="password"><i class="fa fa-lock"></i> Password</label>
          <input type="password" id="password" name="password" placeholder="********">
        </div>

        <button type="submit" class="btn-login animate__animated animate__pulse">Log-in</button>
      </form>

      <p class="text-center mt-3 text-muted">
        Forgot your password? <a href="views/recoverit.php">Recover it</a><br>
        Don’t have an account? <a href="views/register.php">Create one</a>
      </p>
    </div>

    <div class="github-container">
      <a href="https://github.com/Pedrog1999/E-COMMERCE.git" target="_blank" class="github-button">
        <i class="fab fa-github"></i> Open in GitHub
      </a>
    </div>
  </div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const button = document.querySelector(".github-button");
    const freno = document.getElementById("freno-button");

    let frenado = false;

    button.addEventListener("mouseenter", () => {
      if (frenado) return; 

      const offsetX = (Math.random() - 0.5) * window.innerWidth * 0.6;
      const offsetY = (Math.random() - 0.5) * window.innerHeight * 0.6;

      button.style.transform = `translate(${offsetX}px, ${offsetY}px)`;

      setTimeout(() => {
        button.style.transform = "translate(0,0)";
      }, 1000);
    });

    freno.addEventListener("click", () => {
      frenado = !frenado;
      freno.style.background = frenado ? "green" : "crimson";
    });
  });
</script>
</body>
</html>
