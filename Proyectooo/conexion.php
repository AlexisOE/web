<?php
// Datos para XAMPP por defecto (cambia solo si los modificaste)
$servidor = "localhost";
$usuario = "root";       // Usuario por defecto en XAMPP
$contrasena = "";        // Contraseña por defecto (vacía en XAMPP)
$base_datos = "registros"; // Nombre de tu base de datos

// Conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>