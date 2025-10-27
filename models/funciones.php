<?php
require_once __DIR__ . "/conexion.php";

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
function obtenerProductos($pdo) {
    $stmt = $pdo->query("SELECT id, name, description, price, stock, id_countries FROM products ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function agregarProducto($pdo, $name, $description, $price, $stock, $id_countries = null) {
    $sql = "INSERT INTO products (name, description, price, stock, id_countries) 
            VALUES (:name, :description, :price, :stock, :id_countries)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        ":name" => $name,
        ":description" => $description,
        ":price" => $price,
        ":stock" => $stock,
        ":id_countries" => $id_countries
    ])) {
        return $pdo->lastInsertId(); // <--- DEVUELVE EL ID DEL NUEVO PRODUCTO
    }
    return false;
}

function eliminarProducto($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}

function obtenerProductoPorId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function actualizarProducto($pdo, $id, $name, $description, $price, $stock, $id_countries = null) {
    $sql = "UPDATE products 
            SET name = :name, description = :description, price = :price, stock = :stock, id_countries = :id_countries 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ":name" => $name,
        ":description" => $description,
        ":price" => $price,
        ":stock" => $stock,
        ":id_countries" => $id_countries,
        ":id" => $id
    ]);
}


function guardarImagenProducto($pdo, $productId, $path) {
    $stmt = $pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
    $stmt->execute([$productId, $path]);
}

function obtenerImagenesProducto($pdo, $productId) {
    $stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
function obtenerProductosPaginados($pdo, $limite, $offset) {
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT :limite OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function contarProductos($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    return $stmt->fetchColumn();
}
