-- Script de configuración de la base de datos
-- Ejecutar este script en MySQL para crear la base de datos y las tablas

CREATE DATABASE IF NOT EXISTS auditoria_web CHARACTER SET utf8 COLLATE utf8_general_ci;
USE auditoria_web;

-- Tabla Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Tabla Blog
CREATE TABLE IF NOT EXISTS blog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    datetime DATETIME NOT NULL
);

-- Insertar datos de prueba en la tabla Users
INSERT INTO users (email, name, password) VALUES
('admin@example.com', 'Administrador', 'admin123'),
('usuario1@example.com', 'Juan Pérez', 'password123'),
('usuario2@example.com', 'María García', 'mypassword');

-- Insertar datos de prueba en la tabla Blog
INSERT INTO blog (title, body, datetime) VALUES
(
    'Introducción a la Seguridad Web',
    'La seguridad web es un aspecto fundamental en el desarrollo de aplicaciones modernas. En este artículo exploraremos los conceptos básicos de la seguridad web, incluyendo las vulnerabilidades más comunes como SQL Injection, XSS y CSRF. Es importante entender estos conceptos para poder desarrollar aplicaciones más seguras y robustas.',
    '2025-05-20 10:30:00'
),
(
    'Buenas Prácticas en Desarrollo PHP',
    'PHP es uno de los lenguajes más utilizados para el desarrollo web. Sin embargo, es importante seguir buenas prácticas para evitar vulnerabilidades de seguridad. En este artículo veremos cómo validar datos de entrada, usar prepared statements, y implementar un sistema de autenticación seguro. También discutiremos la importancia de mantener el código actualizado y usar frameworks seguros.',
    '2025-05-22 14:15:00'
),
(
    'Auditoría de Seguridad en Aplicaciones Web',
    'La auditoría de seguridad es un proceso crucial para identificar vulnerabilidades en aplicaciones web. Este proceso incluye tanto pruebas automatizadas como manuales. Herramientas como SQLMap, Burp Suite y OWASP ZAP son fundamentales en este proceso. En este artículo aprenderemos a usar estas herramientas de manera efectiva para encontrar y explotar vulnerabilidades de forma ética.',
    '2025-05-25 09:45:00'
);
