
START TRANSACTION;

CREATE DATABASE IF NOT EXISTS urucode;

USE urucode;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    code INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(120) UNIQUE,
    image INT,
    username VARCHAR(30),
    password VARCHAR(30),
    created_at DATETIME,
    updated_at DATETIME
);

COMMIT;