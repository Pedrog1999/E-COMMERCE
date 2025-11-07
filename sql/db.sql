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

