CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;


CREATE TABLE users (
  id INT PRIMARY KEY,
  name VARCHAR(256),
  password VARCHAR(30),
  admin tinyint(1)
);

INSERT INTO users VALUES
(1, 'Pedro', 'qwe123qwe', 1);
(2, 'user', '123123123', 0);

CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(256),
  description TEXT,
  price DECIMAL(10,2),
  stock INT,
  image VARCHAR(256)
);

INSERT INTO products (name, description, price, stock, image) VALUES
('123', 'Descripción del producto 1', 19.99, 100, 'producto1.jpg'),
('Producto 2', 'Descripción del producto 2', 29.99, 50, 'producto2.jpg'),
('Producto 3', 'Descripción del producto 3', 9.99, 200, 'producto3.jpg');
