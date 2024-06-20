
START TRANSACTION;

SET time_zone = "+00:00";

CREATE DATABASE urucode;
USE urucode;

CREATE TABLE usuarios (
    code INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(120) UNIQUE,
    username VARCHAR(30),
    password VARCHAR(30),
    created_at DATETIME,
    updated_at DATETIME
);

COMMIT;