-- Autora Cindy Marcela Jimenez Saldarriaga
-- Base de datos: `tecnolab`
-- Versión de PHP: 8.2.12
-- Tiempo de generación: 21-08-2025 a las 21:55:09


CREATE DATABASE tecnolab;
USE tecnolab;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    identificacion VARCHAR(20) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100) UNIQUE NOT NULL,
    foto VARCHAR(255)
);
