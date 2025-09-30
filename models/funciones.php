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
?>