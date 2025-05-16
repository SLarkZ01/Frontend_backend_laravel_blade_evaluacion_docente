<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Realiza la consulta SQL
$resultado = $conexion->query("SELECT * FROM empleados");

// Verificar si la consulta tuvo éxito
if ($resultado) {
    // Obtiene las filas en un arreglo asociativo
    $filas = $resultado->fetch_all(MYSQLI_ASSOC);

    // Mostrar el contenido de las filas para depuración
    echo "<pre>";           // Etiqueta <pre> para mejorar la legibilidad
    print_r($filas);        // Imprimir el arreglo de filas
    echo "</pre>";          // Cerrar la etiqueta <pre>

    // Detener la ejecución para ver los resultados (opcional)
    exit;
} else {
    echo "Error en la consulta: " . $conexion->error;
}
?>
