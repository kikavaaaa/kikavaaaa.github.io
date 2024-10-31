<?php
$host = 'localhost';
$dbname = 'login_system';
$db_user = 'root'; // Cambia esto a tu usuario de MySQL
$db_pass = ''; // Cambia esto a tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
