<?php
$host = 'localhost'; // Cambia esto si tu servidor PostgreSQL está en otro host
$dbname = 'productos_db'; 
$user = 'tu_usuario'; 
$password = 'tu_contraseña';

// Establecer conexión a la base de datos PostgreSQL
try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>