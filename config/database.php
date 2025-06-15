<?php
// Creado por Jonathan Carrero (jonathan.carrero@alumnos.ui1.es)
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'auditoria_web';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
