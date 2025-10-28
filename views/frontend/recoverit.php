<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Reveal Password Hash (DEV)</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="../../assets/recover.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card animate__animated animate__fadeInDown">
      <h1 class="auth-title">Take your Hash.</h1>
      <p class="auth-subtitle">Enter your username (DEMO MODE) </p>

      <?php
      if (isset($_SESSION['error'])) {
          echo '<div class="alert alert-danger animate__animated animate__fadeInDown">'.$_SESSION['error'].'</div>';
          unset($_SESSION['error']);
      }
      if (isset($_SESSION['success'])) {
          echo '<div class="alert alert-success animate__animated animate__fadeInDown">'.$_SESSION['success'].'</div>';
          unset($_SESSION['success']);
      }
      ?>

      <form method="POST" action="../../controllers/RecoverController.php">
        <div class="form-group">
          <label class="form-label" for="usuario">Username</label>
          <input id="usuario" name="usuario" class="form-input" required>
        </div>
        <button class="btn-auth animate__animated animate__pulse" type="submit">Reveal hash</button>
      </form>

      <p class="auth-footer"><a href="../index.php">Back to login</a></p>
    </div>
  </div>
</body>
</html>
