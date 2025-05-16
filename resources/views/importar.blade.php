<?php

// Incluye la librería PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Configura la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia a tu usuario de base de datos
$password = ""; // Cambia a tu contraseña de base de datos
$dbname = "evaluacion_docentes";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ruta al archivo Excel

$inputFileName = storage_path('app/public/datos.xlsx'); // si usas Laravel

try {
    // Carga el archivo Excel
    $spreadsheet = IOFactory::load($inputFileName);

    // Recorrer las hojas del archivo Excel
    foreach ($spreadsheet->getAllSheets() as $sheet) {
        // Obtener el nombre de la hoja
        $sheetName = $sheet->getTitle();
        echo "Procesando hoja: " . $sheetName . "\n";

        // Obtén las filas de la hoja (suponiendo que los datos comienzan en la fila 2 y la primera fila contiene los encabezados)
        $data = $sheet->toArray(null, true, true, true); // Parámetros que aseguran el índice correcto de filas y columnas

        // Aquí procesamos los datos de acuerdo al nombre de la hoja
        if ($sheetName == 'Docente') {
            procesarDocente($data, $conn);
        } elseif ($sheetName == 'Estudiantes') {
            procesarEstudiantes($data, $conn);
        } elseif ($sheetName == 'Cursos') {
            procesarCursos($data, $conn);
        }
        // Puedes agregar más condiciones según el nombre de las hojas
    }

} catch (Exception $e) {
    echo 'Error cargando el archivo: ',  $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn->close();

// Función para procesar la hoja Docente
function procesarDocente($data, $conn) {
    // Omitir la primera fila (encabezados)
    foreach ($data as $index => $row) {
        if ($index == 1) continue; // Ignorar encabezado

        $id_docente = $row[0] ?? null;  // Columna A (índice 0)
        $cod_docente = $row[1] ?? null; // Columna B (índice 1)
        $nombre = $row[2] ?? null;      // Columna C (índice 2)
        $correo = $row[3] ?? null;      // Columna D (índice 3)

        // Validación de los datos
        if ($id_docente && $cod_docente && $nombre && $correo) {
            // Preparar la consulta SQL para evitar inyecciones
            $stmt = $conn->prepare("INSERT INTO Docente (id_docente, cod_docente, nombre, correo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $id_docente, $cod_docente, $nombre, $correo);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Nuevo registro en Docente: $nombre\n";
            } else {
                echo "Error al insertar en Docente: " . $stmt->error . "\n";
            }
        } else {
            echo "Datos incompletos para docente: $nombre\n";
        }
    }
}

// Función para procesar la hoja Estudiantes
function procesarEstudiantes($data, $conn) {
    // Omitir la primera fila (encabezados)
    foreach ($data as $index => $row) {
        if ($index == 1) continue; // Ignorar encabezado

        $id_estudiante = $row[0] ?? null;  // Columna A (índice 0)
        $nombre_estudiante = $row[1] ?? null; // Columna B (índice 1)
        $correo_estudiante = $row[2] ?? null; // Columna C (índice 2)
        $id_curso = $row[3] ?? null;      // Columna D (índice 3)

        // Validación de los datos
        if ($id_estudiante && $nombre_estudiante && $correo_estudiante && $id_curso) {
            // Preparar la consulta SQL para evitar inyecciones
            $stmt = $conn->prepare("INSERT INTO Estudiantes (id_estudiante, nombre_estudiante, correo_estudiante, id_curso) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $id_estudiante, $nombre_estudiante, $correo_estudiante, $id_curso);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Nuevo registro en Estudiantes: $nombre_estudiante\n";
            } else {
                echo "Error al insertar en Estudiantes: " . $stmt->error . "\n";
            }
        } else {
            echo "Datos incompletos para estudiante: $nombre_estudiante\n";
        }
    }
}

// Función para procesar la hoja Cursos
function procesarCursos($data, $conn) {
    // Omitir la primera fila (encabezados)
    foreach ($data as $index => $row) {
        if ($index == 1) continue; // Ignorar encabezado

        $id_curso = $row[0] ?? null;  // Columna A (índice 0)
        $nombre_curso = $row[1] ?? null; // Columna B (índice 1)
        $codigo_curso = $row[2] ?? null; // Columna C (índice 2)

        // Validación de los datos
        if ($id_curso && $nombre_curso && $codigo_curso) {
            // Preparar la consulta SQL para evitar inyecciones
            $stmt = $conn->prepare("INSERT INTO Cursos (id_curso, nombre_curso, codigo_curso) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $id_curso, $nombre_curso, $codigo_curso);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Nuevo registro en Cursos: $nombre_curso\n";
            } else {
                echo "Error al insertar en Cursos: " . $stmt->error . "\n";
            }
        } else {
            echo "Datos incompletos para curso: $nombre_curso\n";
        }
    }
}
?>
