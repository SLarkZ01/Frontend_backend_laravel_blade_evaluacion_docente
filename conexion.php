<?php
// Parámetros de conexión
$host = "localhost";         // Normalmente "localhost" en entornos locales
$usuario = "root";           // Usuario de MySQL
$contrasena = "";            // Contraseña del usuario (puede ser vacío)
$base_datos = "evaluacion_docentes_def";   // Reemplaza "nombre_bd" con el nombre de tu base de datos

// Crear la conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.";
}
?>