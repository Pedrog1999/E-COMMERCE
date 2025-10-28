<?php
require_once "../models/funciones.php";
global $pdo;

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :usuario LIMIT 1");
    $stmt->execute([":usuario" => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
   /* var_dump($user, $password);
exit;
*/
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION['usuario'] = $user["name"];
        $_SESSION['admin'] = $user["admin"];

        if ($user["admin"] == 1) {
            header("Location: ../views/backoffice/panel.php");
        } else {
            header("Location: ../views/frontend/store.php");
        }
        exit;
    } else {
        $_SESSION['error'] = "invalid credentials, please try again.";
        header("Location: ../index.php");
        exit;
    }
}
