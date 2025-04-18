-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-04-2025 a las 07:24:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `evaluacion_docentes`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarDocente` ()   BEGIN
    SELECT 
        d.id_docente,
        d.nombre,
        d.cod_docente,
        d.correo,
        e.promedio_total AS calificacion,
        c.nombre AS curso
    FROM Docente d
    LEFT JOIN Evaluaciones e ON d.id_docente = e.id_docente
    LEFT JOIN Cursos c ON c.id_curso = e.id_curso;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetEvaluacionesCompletas` ()   BEGIN
    -- Seleccionar todas las evaluaciones con el porcentaje de completado
    SELECT 
        e.id_evaluacion, 
        e.total_tareas, 
        e.tareas_completadas, 
        (e.tareas_completadas / e.total_tareas) * 100 AS porcentaje_completado
    FROM 
        evaluaciones e
    WHERE 
        e.tareas_completadas = e.total_tareas;  -- Solo evaluaciones completas
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetEvaluacionesPendientes` ()   BEGIN
    SELECT COUNT(*) AS evaluaciones_completas
    FROM evaluaciones E
    INNER JOIN periodos_academicos P ON E.id_periodo = P.id_periodo
    WHERE P.id_periodo = p_id_periodo
      AND E.autoevaluacion IS NOT NULL
      AND E.evaluacion_decano IS NOT NULL
      AND E.evaluacion_estudiantes IS NOT NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `notas_clasificadas` ()   BEGIN
    SELECT nombre, promedio_total,
        CASE 
            WHEN promedio_total  BETWEEN 4.5 AND 5.0 THEN 'Excelente'
            WHEN promedio_total  BETWEEN 4.0 AND 4.4 THEN 'Bueno'
            WHEN promedio_total  BETWEEN 3.5 AND 3.9 THEN 'Aceptable'
            WHEN promedio_total  BETWEEN 3.0 AND 3.4 THEN 'Regular'
            WHEN promedio_total < 3.0 THEN 'Deficiente'
            ELSE 'Sin clasificación'
        END
    FROM evaluaciones,cursos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDocentesDestacados` ()   BEGIN
    -- Seleccionamos los docentes más destacados, ordenados por el promedio de calificación
    SELECT 
        d.nombre AS docente,      -- Nombre del docente
        c.nombre AS curso,        -- Nombre del curso
        e.promedio_total AS calificacion   -- Promedio total
    FROM 
        Evaluaciones e
    INNER JOIN 
        Docente d ON d.id_docente = e.id_docente   -- Hacemos JOIN con la tabla Docente
    INNER JOIN 
        Cursos c ON c.id_curso = e.id_curso       -- Hacemos JOIN con la tabla Cursos
    WHERE 
        e.promedio_total > 4.0      -- Filtramos los docentes con promedio mayor a 4.0
    ORDER BY 
        e.promedio_total DESC       -- Ordenamos por el promedio de calificación en orden descendente
    LIMIT 5;   -- Limitar a los 5 primeros docentes destacados
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerPromedioPorFacultad` ()   BEGIN
    SELECT 
        f.nombre AS facultad,
        ROUND(AVG(p.promedio_ev_docente),2) AS promedio_calificacion
    FROM Promedio_Evaluacion_Docente_Por_Curso p
    INNER JOIN Cursos c ON p.id_curso = c.id_curso
    INNER JOIN Programas pr ON c.id_programa = pr.id_programa
    INNER JOIN Facultad f ON pr.id_facultad = f.id_facultad
    GROUP BY f.nombre
    ORDER BY promedio_calificacion DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `promedio_global` ()   BEGIN
    SELECT ROUND(AVG(promedio_total), 2) AS promedio_global
    FROM Evaluaciones;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `promedio_por_curso` ()   BEGIN
    SELECT 
        c.id_curso,
        ROUND(AVG(e.promedio_total), 2) AS promedio_curso
    FROM 
        cursos c  -- Asumí que tienes una tabla de "cursos", cámbiala si es otro nombre
    JOIN 
        evaluaciones e ON c.id_curso = e.id_curso
    GROUP BY 
        c.id_curso;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `totalNoEvaluados` ()   BEGIN
    SELECT COUNT(*) AS total_no_evaluados
    FROM Docentes_No_Evaluados;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `total_docentes` ()   BEGIN
    SELECT COUNT(*) AS total_docentes FROM Docente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `total_estudiantes_no_evaluaron` ()   BEGIN
    SELECT COUNT(*) As total_estudiantes_no_evaluaron
    FROM estudiantes_no_evaluaron;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acta_compromiso`
--

CREATE TABLE `acta_compromiso` (
  `id_acta` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_facultad` int(11) DEFAULT NULL,
  `id_promedio` int(11) DEFAULT NULL,
  `retroalimentacion` text DEFAULT NULL,
  `fecha_generacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acta_compromiso`
--

INSERT INTO `acta_compromiso` (`id_acta`, `id_docente`, `id_facultad`, `id_promedio`, `retroalimentacion`, `fecha_generacion`) VALUES
(1, 1, 1, 1, 'Debe mejorar en metodologías activas.', '2025-03-01'),
(2, 2, 2, 2, 'Usar más herramientas digitales.', '2025-03-02'),
(3, 3, 3, 3, 'Participar en capacitaciones.', '2025-03-03'),
(4, 4, 4, 4, 'Incluir retroalimentación oportuna.', '2025-03-04'),
(5, 5, 5, 5, 'Mejorar gestión del tiempo.', '2025-03-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas_bajo_desempeno`
--

CREATE TABLE `alertas_bajo_desempeno` (
  `id_alerta` int(11) NOT NULL,
  `id_facultad` int(11) DEFAULT NULL,
  `id_promedio` int(11) DEFAULT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alertas_bajo_desempeno`
--

INSERT INTO `alertas_bajo_desempeno` (`id_alerta`, `id_facultad`, `id_promedio`, `id_docente`, `id_curso`) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 2, 2),
(3, 3, 3, 3, 3),
(4, 4, 4, 4, 4),
(5, 5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `id_coordinacion` int(11) DEFAULT NULL,
  `comentario1` text DEFAULT NULL,
  `comentario2` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `tipo`, `id_docente`, `id_programa`, `id_coordinacion`, `comentario1`, `comentario2`) VALUES
(1, 'Observación general', 1, 1, 1, 'Buen desempeño', 'Debe mejorar en puntualidad'),
(2, 'Sugerencia', 2, 2, 2, 'Interesante clase', 'Más práctica sería útil'),
(3, 'Crítica', 3, 3, 3, 'Falta preparación', 'No responde preguntas'),
(4, 'Reconocimiento', 4, 4, 4, 'Excelente docente', 'Clases muy claras'),
(5, 'Queja', 5, 5, 5, 'Muy estricto', 'No da segundas oportunidades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinacion`
--

CREATE TABLE `coordinacion` (
  `id_coordinacion` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coordinacion`
--

INSERT INTO `coordinacion` (`id_coordinacion`, `nombre`) VALUES
(1, 'Ingeniería'),
(2, 'Derecho'),
(3, 'Administración'),
(4, 'Contaduría'),
(5, 'deporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `id_docente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `codigo`, `nombre`, `id_programa`, `id_docente`) VALUES
(1, 'CS101', 'Programación I', 1, 1),
(2, 'IN201', 'Derecho penal', 2, 2),
(3, 'AD301', 'Gestión Financiera', 3, 3),
(4, 'CO401', 'Auditoría', 4, 4),
(5, 'PS501', 'Acondicionamiento I', 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cod_docente` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `id_usuario`, `cod_docente`, `nombre`, `correo`) VALUES
(1, NULL, 1001, 'ana caviedes', NULL),
(2, NULL, 1002, 'pedro gonzales', NULL),
(3, NULL, 1003, 'violeta ortiz', NULL),
(4, NULL, 1004, 'raul hernandez', NULL),
(5, NULL, 1005, 'camila fernandez', NULL),
(6, 2, 1015, 'alberto gonzales', 'alberto@uniautonoma.edu.co');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes_no_evaluados`
--

CREATE TABLE `docentes_no_evaluados` (
  `id_docente_No_Evaluado` int(11) NOT NULL,
  `id_evaluacion` int(11) DEFAULT NULL,
  `id_facultad` int(11) DEFAULT NULL,
  `id_coordinacion` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes_no_evaluados`
--

INSERT INTO `docentes_no_evaluados` (`id_docente_No_Evaluado`, `id_evaluacion`, `id_facultad`, `id_coordinacion`, `id_programa`, `id_curso`) VALUES
(1, 1, 1, 1, 1, 1),
(2, 2, 2, 2, 2, 2),
(3, 3, 3, 3, 3, 3),
(4, 4, 4, 4, 4, 4),
(5, 5, 5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `nombre`, `correo`, `semestre`, `id_programa`) VALUES
(1, 'Ana Gómez', 'ana1@correo.com', 1, 1),
(2, 'Luis Díaz', 'luis2@correo.com', 2, 2),
(3, 'María Ruiz', 'maria3@correo.com', 3, 3),
(4, 'Carlos Pérez', 'carlos4@correo.com', 4, 4),
(5, 'Laura Torres', 'laura5@correo.com', 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes_no_evaluaron`
--

CREATE TABLE `estudiantes_no_evaluaron` (
  `id_estudiante` int(11) NOT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `id_facultad` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes_no_evaluaron`
--

INSERT INTO `estudiantes_no_evaluaron` (`id_estudiante`, `id_programa`, `id_facultad`, `id_curso`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3),
(4, 4, 4, 4),
(5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `evaluaciones` (
  `id_evaluacion` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_periodo` int(11) DEFAULT NULL,
  `autoevaluacion` decimal(3,2) DEFAULT NULL,
  `evaluacion_decano` decimal(3,2) DEFAULT NULL,
  `evaluacion_estudiantes` decimal(3,2) DEFAULT NULL,
  `promedio_total` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`id_evaluacion`, `id_docente`, `id_curso`, `id_periodo`, `autoevaluacion`, `evaluacion_decano`, `evaluacion_estudiantes`, `promedio_total`) VALUES
(1, 1, 1, 1, 3.20, 3.30, 2.10, 2.80),
(2, 2, 2, 2, 2.00, 3.00, 3.20, 3.40),
(3, 3, 3, 3, 5.00, 3.70, 2.90, 4.20),
(4, 4, 4, 4, 4.00, 4.00, 4.00, 4.00),
(5, 5, 5, 5, 5.00, 5.00, 5.00, 5.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE `facultad` (
  `id_facultad` int(11) NOT NULL,
  `id_coordinacion` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`id_facultad`, `id_coordinacion`, `nombre`) VALUES
(1, 1, 'Facultad de Ingeniería'),
(2, 2, 'Facultad de Derecho'),
(3, 3, 'Facultad de Administración'),
(4, 4, 'Facultad de Contaduría'),
(5, 5, 'Facultad de Deporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_plan_mejora`
--

CREATE TABLE `notas_plan_mejora` (
  `id_notas_plan_mejora` int(11) NOT NULL,
  `id_plan_mejora` int(11) DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas_plan_mejora`
--

INSERT INTO `notas_plan_mejora` (`id_notas_plan_mejora`, `id_plan_mejora`, `nota`, `fecha`) VALUES
(1, 1, 'Asistió a taller de didáctica.', '2025-03-10'),
(2, 2, 'Implementó rúbricas en evaluación.', '2025-03-12'),
(3, 3, 'Solicitó mentoría pedagógica.', '2025-03-14'),
(4, 4, 'Aplicó feedback a estudiantes.', '2025-03-16'),
(5, 5, 'Está en proceso de planificación.', '2025-03-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos_academicos`
--

CREATE TABLE `periodos_academicos` (
  `id_periodo` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periodos_academicos`
--

INSERT INTO `periodos_academicos` (`id_periodo`, `nombre`, `fecha_inicio`, `fecha_fin`) VALUES
(1, '2023-1', '2023-01-10', '2023-06-10'),
(2, '2023-2', '2023-07-10', '2023-12-10'),
(3, '2024-1', '2024-01-10', '2024-06-10'),
(4, '2024-2', '2024-07-10', '2024-12-10'),
(5, '2025-1', '2025-01-10', '2025-06-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `modulo_permiso` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `id_usuario`, `nombre`, `descripcion`, `modulo_permiso`) VALUES
(1, 1, 'Ver Reportes', 'Permite ver reportes del sistema', 'Reportes'),
(2, 2, 'Editar Curso', 'Editar información de cursos', 'Cursos'),
(3, 3, 'Eliminar Usuario', 'Permite eliminar usuarios', 'Administración'),
(4, 4, 'Acceso Evaluaciones', 'Acceder a resultados de evaluación', 'Evaluaciones'),
(5, 5, 'Ver Alertas', 'Visualización de alertas por bajo desempeño', 'Alertas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_de_mejora`
--

CREATE TABLE `plan_de_mejora` (
  `id_plan_mejora` int(11) NOT NULL,
  `id_facultad` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_promedio` int(11) DEFAULT NULL,
  `progreso` int(11) DEFAULT NULL,
  `estado` enum('Activo','Cerrado','Pendiente') DEFAULT NULL,
  `retroalimentacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plan_de_mejora`
--

INSERT INTO `plan_de_mejora` (`id_plan_mejora`, `id_facultad`, `id_curso`, `id_docente`, `id_promedio`, `progreso`, `estado`, `retroalimentacion`) VALUES
(1, 1, 1, 1, 1, 50, 'Activo', 'En proceso de mejora continua.'),
(2, 2, 2, 2, 2, 30, 'Pendiente', 'Inicio de acciones postergado.'),
(3, 3, 3, 3, 3, 70, 'Activo', 'Mejoras implementadas parcialmente.'),
(4, 4, 4, 4, 4, 100, 'Cerrado', 'Todas las metas cumplidas.'),
(5, 5, 5, 5, 5, 20, 'Pendiente', 'Docente no ha iniciado acciones.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso_sancion`
--

CREATE TABLE `proceso_sancion` (
  `id_proceso` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_facultad` int(11) DEFAULT NULL,
  `id_promedio` int(11) DEFAULT NULL,
  `sancion` enum('Leve','Grave','Retiro_definitivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proceso_sancion`
--

INSERT INTO `proceso_sancion` (`id_proceso`, `id_docente`, `id_facultad`, `id_promedio`, `sancion`) VALUES
(1, 1, 1, 1, 'Leve'),
(2, 2, 2, 2, 'Grave'),
(3, 3, 3, 3, 'Leve'),
(4, 4, 4, 4, 'Grave'),
(5, 5, 5, 5, 'Retiro_definitivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id_programa` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `id_facultad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id_programa`, `id_docente`, `nombre`, `id_facultad`) VALUES
(1, 1, 'Ingeniería de Software', 1),
(2, 2, 'Derecho', 2),
(3, 3, 'Administración de Empresas', 3),
(4, 4, 'Contaduría Pública', 4),
(5, 5, 'Acondicionamiento fisico ', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promedio_evaluacion_docente_por_curso`
--

CREATE TABLE `promedio_evaluacion_docente_por_curso` (
  `id_promedio` int(11) NOT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `promedio_ev_docente` decimal(3,2) DEFAULT NULL,
  `promedio_notas_curso` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promedio_evaluacion_docente_por_curso`
--

INSERT INTO `promedio_evaluacion_docente_por_curso` (`id_promedio`, `id_curso`, `id_docente`, `promedio_ev_docente`, `promedio_notas_curso`) VALUES
(1, 1, 1, 4.50, 3.80),
(2, 2, 2, 3.90, 3.20),
(3, 3, 3, 2.70, 2.90),
(4, 4, 4, 4.80, 4.60),
(5, 5, 5, 2.50, 2.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`, `descripcion`) VALUES
(1, 'Docente', 'Usuario con rol de docente'),
(2, 'Coordinador', 'Usuario coordinador de programa'),
(3, 'Administrador', 'Administrador del sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo_usuario` enum('docente','coordinador','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `activo`, `nombre`, `correo`, `contrasena`, `tipo_usuario`) VALUES
(1, 1, 1, 'Juan Pérez', 'juan@correo.com', 'clave123', 'docente'),
(2, 2, 1, 'Ana Gómez', 'ana@correo.com', 'clave456', 'coordinador'),
(3, 3, 0, 'Carlos Ruiz', 'carlos@correo.com', 'clave789', 'administrador'),
(4, 2, 1, 'Laura Díaz', 'laura@correo.com', 'clave321', 'docente'),
(5, 1, 1, 'Pedro Torres', 'pedro@correo.com', 'clave654', 'coordinador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acta_compromiso`
--
ALTER TABLE `acta_compromiso`
  ADD PRIMARY KEY (`id_acta`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_facultad` (`id_facultad`),
  ADD KEY `id_promedio` (`id_promedio`);

--
-- Indices de la tabla `alertas_bajo_desempeno`
--
ALTER TABLE `alertas_bajo_desempeno`
  ADD PRIMARY KEY (`id_alerta`),
  ADD KEY `id_facultad` (`id_facultad`),
  ADD KEY `id_promedio` (`id_promedio`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_coordinacion` (`id_coordinacion`);

--
-- Indices de la tabla `coordinacion`
--
ALTER TABLE `coordinacion`
  ADD PRIMARY KEY (`id_coordinacion`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `docentes_no_evaluados`
--
ALTER TABLE `docentes_no_evaluados`
  ADD PRIMARY KEY (`id_docente_No_Evaluado`),
  ADD KEY `id_evaluacion` (`id_evaluacion`),
  ADD KEY `id_facultad` (`id_facultad`),
  ADD KEY `id_coordinacion` (`id_coordinacion`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `estudiantes_no_evaluaron`
--
ALTER TABLE `estudiantes_no_evaluaron`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_facultad` (`id_facultad`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD PRIMARY KEY (`id_evaluacion`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_periodo` (`id_periodo`);

--
-- Indices de la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD PRIMARY KEY (`id_facultad`),
  ADD KEY `id_coordinacion` (`id_coordinacion`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notas_plan_mejora`
--
ALTER TABLE `notas_plan_mejora`
  ADD PRIMARY KEY (`id_notas_plan_mejora`),
  ADD KEY `id_plan_mejora` (`id_plan_mejora`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `periodos_academicos`
--
ALTER TABLE `periodos_academicos`
  ADD PRIMARY KEY (`id_periodo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `plan_de_mejora`
--
ALTER TABLE `plan_de_mejora`
  ADD PRIMARY KEY (`id_plan_mejora`),
  ADD KEY `id_facultad` (`id_facultad`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_promedio` (`id_promedio`);

--
-- Indices de la tabla `proceso_sancion`
--
ALTER TABLE `proceso_sancion`
  ADD PRIMARY KEY (`id_proceso`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_facultad` (`id_facultad`),
  ADD KEY `id_promedio` (`id_promedio`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id_programa`),
  ADD KEY `id_facultad` (`id_facultad`),
  ADD KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `promedio_evaluacion_docente_por_curso`
--
ALTER TABLE `promedio_evaluacion_docente_por_curso`
  ADD PRIMARY KEY (`id_promedio`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acta_compromiso`
--
ALTER TABLE `acta_compromiso`
  ADD CONSTRAINT `acta_compromiso_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `acta_compromiso_ibfk_2` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`),
  ADD CONSTRAINT `acta_compromiso_ibfk_3` FOREIGN KEY (`id_promedio`) REFERENCES `promedio_evaluacion_docente_por_curso` (`id_promedio`);

--
-- Filtros para la tabla `alertas_bajo_desempeno`
--
ALTER TABLE `alertas_bajo_desempeno`
  ADD CONSTRAINT `alertas_bajo_desempeno_ibfk_1` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`),
  ADD CONSTRAINT `alertas_bajo_desempeno_ibfk_2` FOREIGN KEY (`id_promedio`) REFERENCES `promedio_evaluacion_docente_por_curso` (`id_promedio`),
  ADD CONSTRAINT `alertas_bajo_desempeno_ibfk_3` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `alertas_bajo_desempeno_ibfk_4` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `comentarios_ibfk_3` FOREIGN KEY (`id_coordinacion`) REFERENCES `coordinacion` (`id_coordinacion`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `cursos_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`);

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `docentes_no_evaluados`
--
ALTER TABLE `docentes_no_evaluados`
  ADD CONSTRAINT `docentes_no_evaluados_ibfk_1` FOREIGN KEY (`id_evaluacion`) REFERENCES `evaluaciones` (`id_evaluacion`),
  ADD CONSTRAINT `docentes_no_evaluados_ibfk_2` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`),
  ADD CONSTRAINT `docentes_no_evaluados_ibfk_3` FOREIGN KEY (`id_coordinacion`) REFERENCES `coordinacion` (`id_coordinacion`),
  ADD CONSTRAINT `docentes_no_evaluados_ibfk_4` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `docentes_no_evaluados_ibfk_5` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`);

--
-- Filtros para la tabla `estudiantes_no_evaluaron`
--
ALTER TABLE `estudiantes_no_evaluaron`
  ADD CONSTRAINT `estudiantes_no_evaluaron_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`),
  ADD CONSTRAINT `estudiantes_no_evaluaron_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `estudiantes_no_evaluaron_ibfk_3` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`),
  ADD CONSTRAINT `estudiantes_no_evaluaron_ibfk_4` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`);

--
-- Filtros para la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD CONSTRAINT `evaluaciones_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `evaluaciones_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `evaluaciones_ibfk_3` FOREIGN KEY (`id_periodo`) REFERENCES `periodos_academicos` (`id_periodo`);

--
-- Filtros para la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD CONSTRAINT `facultad_ibfk_1` FOREIGN KEY (`id_coordinacion`) REFERENCES `coordinacion` (`id_coordinacion`);

--
-- Filtros para la tabla `notas_plan_mejora`
--
ALTER TABLE `notas_plan_mejora`
  ADD CONSTRAINT `notas_plan_mejora_ibfk_1` FOREIGN KEY (`id_plan_mejora`) REFERENCES `plan_de_mejora` (`id_plan_mejora`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `plan_de_mejora`
--
ALTER TABLE `plan_de_mejora`
  ADD CONSTRAINT `plan_de_mejora_ibfk_1` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`),
  ADD CONSTRAINT `plan_de_mejora_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `plan_de_mejora_ibfk_3` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `plan_de_mejora_ibfk_4` FOREIGN KEY (`id_promedio`) REFERENCES `promedio_evaluacion_docente_por_curso` (`id_promedio`);

--
-- Filtros para la tabla `proceso_sancion`
--
ALTER TABLE `proceso_sancion`
  ADD CONSTRAINT `proceso_sancion_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `proceso_sancion_ibfk_2` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`),
  ADD CONSTRAINT `proceso_sancion_ibfk_3` FOREIGN KEY (`id_promedio`) REFERENCES `promedio_evaluacion_docente_por_curso` (`id_promedio`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `programas_ibfk_1` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`),
  ADD CONSTRAINT `programas_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`);

--
-- Filtros para la tabla `promedio_evaluacion_docente_por_curso`
--
ALTER TABLE `promedio_evaluacion_docente_por_curso`
  ADD CONSTRAINT `promedio_evaluacion_docente_por_curso_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `promedio_evaluacion_docente_por_curso_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
