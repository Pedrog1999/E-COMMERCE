<?php
require_once __DIR__ . "/conexion.php";


function obtenerContactos($pdo) {
    $stmt = $pdo->query("SELECT * FROM agenda ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function agregarContacto($pdo, $nombre, $telefono, $email, $direccion) {
    $sql = "INSERT INTO agenda (nombre, telefono, email, direccion) 
            VALUES (:nombre, :telefono, :email, :direccion)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":nombre" => $nombre,
        ":telefono" => $telefono,
        ":email" => $email,
        ":direccion" => $direccion
    ]);
}


function eliminarContacto($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM agenda WHERE id = ?");
    $stmt->execute([$id]);
}


function obtenerContactoPorId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM agenda WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function actualizarContacto($pdo, $id, $nombre, $telefono, $email, $direccion) {
    $stmt = $pdo->prepare("UPDATE agenda SET nombre=?, telefono=?, email=?, direccion=? WHERE id=?");
    $stmt->execute([$nombre, $telefono, $email, $direccion, $id]);
}




function crearUsuario($usuario, $passwordHash, $admin = 0, $email = null) {
    global $pdo;

    // Verificar si ya existe el usuario o el email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE name = ? OR email = ?");
    $stmt->execute([$usuario, $email]);

    if ($stmt->fetch()) {
        return false; // ya existe usuario o email
    }

    
    $stmt = $pdo->prepare("INSERT INTO users (name, password, admin, email) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$usuario, $passwordHash, $admin, $email]);
}

function existeEmail($email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch() ? true : false;
}

function guardarTokenRecuperacion($email, $token, $expires) {
    global $pdo;
    // Primero borramos tokens viejos de ese mail
    $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

    // Insertamos el nuevo
    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    return $stmt->execute([$email, $token, $expires]);
}

function obtenerResetPorToken($token) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function actualizarPasswordPorEmail($email, $newHash) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    return $stmt->execute([$newHash, $email]);
}
