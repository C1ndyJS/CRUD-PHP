<?php
$host = "localhost";
$user = "root"; // cambia si tienes otra config
$pass = "toor";
$dbname = "tecnolab";

$conexion = new mysqli($host, $user, $pass, $dbname);
$conexion->set_charset("utf8mb4"); // Configurar el conjunto de caracteres

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
