-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2025 a las 20:47:50
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarActaCompromiso` (IN `in_id_acta` INT, IN `in_retroalimentacion` TEXT, IN `in_fecha_generacion` DATE)   BEGIN
    UPDATE Acta_Compromiso
    SET retroalimentacion = in_retroalimentacion,
        fecha_generacion = in_fecha_generacion
    WHERE id_acta = in_id_acta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarAsignacionCursoDocentePeriodo` (IN `in_id_asignacion` INT, IN `in_id_curso` INT, IN `in_id_docente` INT, IN `in_id_periodo` INT)   BEGIN
    UPDATE Curso_Docente_Periodo
    SET id_curso = in_id_curso,
        id_docente = in_id_docente,
        id_periodo = in_id_periodo
    WHERE id_asignacion = in_id_asignacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarCurso` (IN `in_id_curso` INT, IN `in_codigo` VARCHAR(50), IN `in_nombre` VARCHAR(255), IN `in_id_programa` INT)   BEGIN
    UPDATE Cursos
    SET codigo = in_codigo,
        nombre = in_nombre,
        id_programa = in_id_programa
    WHERE id_curso = in_id_curso;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarDocente` (IN `in_id_docente` INT, IN `in_id_usuario` INT, IN `in_cod_docente` VARCHAR(50), IN `in_nombre` VARCHAR(255), IN `in_correo` VARCHAR(255))   BEGIN
    UPDATE Docente
    SET id_usuario = in_id_usuario,
        cod_docente = in_cod_docente,
        nombre = in_nombre,
        correo = in_correo
    WHERE id_docente = in_id_docente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarEstudiante` (IN `in_id_estudiante` INT, IN `in_nombre` VARCHAR(255), IN `in_correo` VARCHAR(255), IN `in_semestre` INT, IN `in_id_programa` INT)   BEGIN
    UPDATE Estudiantes
    SET nombre = in_nombre,
        correo = in_correo,
        semestre = in_semestre,
        id_programa = in_id_programa
    WHERE id_estudiante = in_id_estudiante;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarFacultad` (IN `in_id_facultad` INT, IN `in_nombre` VARCHAR(100), IN `in_id_coordinacion` INT)   BEGIN
    UPDATE Facultad
    SET nombre = in_nombre,
        id_coordinacion = in_id_coordinacion
    WHERE id_facultad = in_id_facultad;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarNotasEvaluacion` (IN `in_id_evaluacion` INT, IN `in_autoevaluacion` DECIMAL(3,2), IN `in_evaluacion_decano` DECIMAL(3,2), IN `in_evaluacion_estudiantes` DECIMAL(3,2))   BEGIN
    UPDATE Evaluaciones
    SET autoevaluacion = in_autoevaluacion,
        evaluacion_decano = in_evaluacion_decano,
        evaluacion_estudiantes = in_evaluacion_estudiantes,
        fecha_evaluacion = CURRENT_TIMESTAMP
    WHERE id_evaluacion = in_id_evaluacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPeriodoAcademico` (IN `in_id_periodo` INT, IN `in_nombre` VARCHAR(50), IN `in_fecha_inicio` DATE, IN `in_fecha_fin` DATE, IN `in_activo` BOOLEAN)   BEGIN
    UPDATE Periodos_Academicos
    SET nombre = in_nombre,
        fecha_inicio = in_fecha_inicio,
        fecha_fin = in_fecha_fin,
        activo = in_activo
    WHERE id_periodo = in_id_periodo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPlanMejora` (IN `in_id_plan_mejora` INT, IN `in_objetivo` TEXT, IN `in_progreso` INT, IN `in_estado` ENUM('Activo','Cerrado','Pendiente','Cancelado'), IN `in_fecha_inicio` DATE, IN `in_fecha_fin_prevista` DATE)   BEGIN
    UPDATE Plan_De_Mejora
    SET objetivo = in_objetivo,
        progreso = in_progreso,
        estado = in_estado,
        fecha_inicio = in_fecha_inicio,
        fecha_fin_prevista = in_fecha_fin_prevista
    WHERE id_plan_mejora = in_id_plan_mejora;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPrograma` (IN `in_id_programa` INT, IN `in_nombre` VARCHAR(255), IN `in_id_facultad` INT)   BEGIN
    UPDATE Programas
    SET nombre = in_nombre,
        id_facultad = in_id_facultad
    WHERE id_programa = in_id_programa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarUsuarioInfo` (IN `in_id_usuario` INT, IN `in_nombre` VARCHAR(255), IN `in_correo` VARCHAR(255), IN `in_id_rol` INT, IN `in_tipo_usuario` ENUM('docente','coordinador','administrador'), IN `in_activo` BOOLEAN)   BEGIN
    UPDATE Usuarios
    SET nombre = in_nombre,
        correo = in_correo,
        id_rol = in_id_rol,
        tipo_usuario = in_tipo_usuario,
        activo = in_activo,
        fecha_actualizacion = CURRENT_TIMESTAMP
    WHERE id_usuario = in_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarComentario` (IN `in_id_evaluacion` INT, IN `in_tipo` ENUM('Observación','Sugerencia','Crítica','Reconocimiento','Queja','General'), IN `in_comentario` TEXT, IN `in_origen` ENUM('Estudiante','Decano','Autoevaluacion','Coordinador'), OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Comentarios (id_evaluacion, tipo, comentario, origen)
    VALUES (in_id_evaluacion, in_tipo, in_comentario, in_origen);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AsignarCursoDocentePeriodo` (IN `in_id_curso` INT, IN `in_id_docente` INT, IN `in_id_periodo` INT, OUT `out_nueva_asignacion_id` INT)   BEGIN
    INSERT INTO Curso_Docente_Periodo (id_curso, id_docente, id_periodo)
    VALUES (in_id_curso, in_id_docente, in_id_periodo);
    SET out_nueva_asignacion_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarDocente` (IN `terminoBusqueda` VARCHAR(100))   BEGIN
    SELECT * 
    FROM Docente
    WHERE nombre LIKE CONCAT('%', terminoBusqueda, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarDocentePorCodigo` (IN `codigo_busqueda` VARCHAR(50))   BEGIN
    SELECT *
    FROM docentes
    WHERE cod_docente LIKE CONCAT('%', codigo_busqueda, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CambiarEstadoActivoUsuario` (IN `in_id_usuario` INT, IN `in_activo` BOOLEAN)   BEGIN
    UPDATE Usuarios
    SET activo = in_activo,
        fecha_actualizacion = CURRENT_TIMESTAMP
    WHERE id_usuario = in_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearActaCompromiso` (IN `in_id_evaluacion` INT, IN `in_retroalimentacion` TEXT, IN `in_fecha_generacion` DATE, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Acta_Compromiso (id_evaluacion, retroalimentacion, fecha_generacion)
    VALUES (in_id_evaluacion, in_retroalimentacion, in_fecha_generacion);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearCurso` (IN `in_codigo` VARCHAR(50), IN `in_nombre` VARCHAR(255), IN `in_id_programa` INT, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Cursos (codigo, nombre, id_programa)
    VALUES (in_codigo, in_nombre, in_id_programa);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearDocente` (OUT `in_id_usuario` INT, IN `in_cod_docente` VARCHAR(50), IN `in_nombre` VARCHAR(255), IN `in_correo` VARCHAR(255), OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Docente (id_usuario, cod_docente, nombre, correo)
    VALUES (in_id_usuario, in_cod_docente, in_nombre, in_correo);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearEstudiante` (IN `in_nombre` VARCHAR(255), IN `in_correo` VARCHAR(255), IN `in_semestre` INT, IN `in_id_programa` INT, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Estudiantes (nombre, correo, semestre, id_programa)
    VALUES (in_nombre, in_correo, in_semestre, in_id_programa);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearFacultad` (IN `in_nombre` VARCHAR(100), IN `in_id_coordinacion` INT, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Facultad (nombre, id_coordinacion)
    VALUES (in_nombre, in_id_coordinacion);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearPeriodoAcademico` (IN `in_nombre` VARCHAR(50), IN `in_fecha_inicio` DATE, IN `in_fecha_fin` DATE, IN `in_activo` BOOLEAN, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Periodos_Academicos (nombre, fecha_inicio, fecha_fin, activo)
    VALUES (in_nombre, in_fecha_inicio, in_fecha_fin, in_activo);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearPlanMejora` (IN `in_id_acta` INT, IN `in_objetivo` TEXT, IN `in_fecha_inicio` DATE, IN `in_fecha_fin_prevista` DATE, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Plan_De_Mejora (id_acta, objetivo, estado, fecha_inicio, fecha_fin_prevista)
    VALUES (in_id_acta, in_objetivo, 'Pendiente', in_fecha_inicio, in_fecha_fin_prevista);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearPrograma` (IN `in_nombre` VARCHAR(255), IN `in_id_facultad` INT, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Programas (nombre, id_facultad)
    VALUES (in_nombre, in_id_facultad);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearUsuario` (IN `in_nombre` VARCHAR(255), IN `in_correo` VARCHAR(255), IN `in_contrasena_hash` VARCHAR(255), IN `in_id_rol` INT, IN `in_tipo_usuario` ENUM('docente','coordinador','administrador'), IN `in_activo` BOOLEAN, OUT `out_nuevo_id` INT)   BEGIN
    INSERT INTO Usuarios (nombre, correo, contrasena, id_rol, tipo_usuario, activo)
    VALUES (in_nombre, in_correo, in_contrasena_hash, in_id_rol, in_tipo_usuario, in_activo);
    SET out_nuevo_id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DesasignarCursoDocentePeriodo` (IN `in_id_asignacion` INT)   BEGIN
    DELETE FROM Curso_Docente_Periodo WHERE id_asignacion = in_id_asignacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarComentario` (IN `in_id_comentario` INT)   BEGIN
    DELETE FROM Comentarios WHERE id_comentario = in_id_comentario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarCurso` (IN `in_id_curso` INT)   BEGIN
    DELETE FROM Cursos WHERE id_curso = in_id_curso;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarDocente` (IN `in_id_docente` INT)   BEGIN
    DELETE FROM Docente WHERE id_docente = in_id_docente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarEstudiante` (IN `in_id_estudiante` INT)   BEGIN
    DELETE FROM Estudiantes WHERE id_estudiante = in_id_estudiante;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarFacultad` (IN `in_id_facultad` INT)   BEGIN
    DELETE FROM Facultad WHERE id_facultad = in_id_facultad;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarPeriodoAcademico` (IN `in_id_periodo` INT)   BEGIN
    DELETE FROM Periodos_Academicos WHERE id_periodo = in_id_periodo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarPrograma` (IN `in_id_programa` INT)   BEGIN
    DELETE FROM Programas WHERE id_programa = in_id_programa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuario` (IN `in_id_usuario` INT)   BEGIN
    DELETE FROM Usuarios WHERE id_usuario = in_id_usuario;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarComentario` (IN `p_id_comentario` INT, IN `p_tipo` VARCHAR(50), IN `p_id_docente` INT, IN `p_id_programa` INT, IN `p_id_coordinacion` INT, IN `p_comentario1` TEXT, IN `p_comentario2` TEXT)   BEGIN
    INSERT INTO comentarios (
        id_comentario, tipo, id_docente, id_programa, id_coordinacion, comentario1, comentario2
    ) VALUES (
        p_id_comentario, p_tipo, p_id_docente, p_id_programa, p_id_coordinacion, p_comentario1, p_comentario2
    );
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerComentariosPorDocente` (IN `p_id_docente` INT)   BEGIN
    SELECT
        id_comentario,
        tipo,
        id_programa,
        id_coordinacion,
        comentario1,
        comentario2
    FROM comentarios
    WHERE id_docente = p_id_docente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDocentesDestacados` ()   BEGIN
    SELECT 
        d.id_docente,
        u.nombre AS nombre_docente,
        f.nombre AS facultad,
        pr.nombre AS programa,
        c.nombre AS curso,
        e.promedio_total
    FROM Evaluaciones e
    INNER JOIN Docente d ON e.id_docente = d.id_docente
    INNER JOIN Usuarios u ON d.id_usuario = u.id_usuario
    INNER JOIN Cursos c ON e.id_curso = c.id_curso
    INNER JOIN Programas pr ON c.id_programa = pr.id_programa
    INNER JOIN Facultad f ON pr.id_facultad = f.id_facultad
    WHERE e.promedio_total >= 4.0
    ORDER BY e.promedio_total DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerIdCoordinacionPorNombre` (IN `nombre_coordinacion` VARCHAR(100))   BEGIN
    SELECT id_coordinacion
    FROM coordinacion
    WHERE nombre = nombre_coordinacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerIdCursoPorNombre` (IN `nombre_curso` VARCHAR(255))   BEGIN
    SELECT id_curso
    FROM Cursos
    WHERE nombre = nombre_curso
    LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerIdDocentePorNombre` (IN `nombre_usuario` VARCHAR(255))   BEGIN
    SELECT d.id_docente
    FROM Docente d
    INNER JOIN Usuarios u ON d.id_usuario = u.id_usuario
    WHERE u.nombre = nombre_usuario
    LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerIdFacultadPorNombre` (IN `nombre_facultad` VARCHAR(50))   BEGIN
    SELECT id_facultad
    FROM facultad
    WHERE nombre=nombre_facultad
    LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerIdProgramaPorNombre` (IN `nombre_programa` VARCHAR(100))   BEGIN
    SELECT id_programa
    FROM programas
    WHERE nombre = nombre_programa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerIdUsuarioPorNombre` (IN `nombre_usuario` VARCHAR(255))   BEGIN
    SELECT id_usuario 
    FROM Usuarios 
    WHERE nombre = nombre_usuario 
    LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerPromedioNotasPorFacultad` ()   BEGIN
    SELECT 
        f.id_facultad,
        f.nombre,
        ROUND(AVG(pedpc.promedio_total), 2) AS promedio_general
    FROM Facultad f
    JOIN Cursos c ON f.id_facultad = c.id_facultad
    JOIN Promedio_Evaluacion_Docente_Por_Curso pedpc ON c.id_curso = pedpc.id_curso
    GROUP BY f.id_facultad, f.nombre;
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cod_docente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `id_usuario`, `cod_docente`) VALUES
(36, 1, 12314),
(37, 2, 5678),
(38, 3, 98678),
(39, 4, 4564),
(40, 5, 456),
(41, 6, 123),
(42, 7, 453);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes_no_evaluaron`
--

CREATE TABLE `estudiantes_no_evaluaron` (
  `id_estudiante` int(11) NOT NULL,
  `id_facultad` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  `cod_estudiante` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `codigo_curso` varchar(50) DEFAULT NULL,
  `nombre_curso` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `notas_plan_mejora`
--

CREATE TABLE `notas_plan_mejora` (
  `id_notas_plan_mejora` int(11) NOT NULL,
  `id_plan_mejora` int(11) DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(56, 36, 'INGENIERIA ELECTRONICA', 3),
(57, 37, 'INGENIERIA SOFTWARE', NULL),
(58, 38, 'INGENIERIA AMBIENTAL', NULL),
(59, 39, 'DEPORTES ', NULL),
(60, 40, 'INGENIERIA ELECTRONICA', NULL),
(61, 41, 'DERECHO', NULL),
(62, 42, 'INGENIERIA ELECTRONICA', NULL);

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
(1, 'Decano', 'Decano de la universidad'),
(2, 'Docente', 'Docente de la universidad'),
(3, 'Administrador', 'Administrador de la universidad');

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
(1, 2, 1, 'Juan Pérez', 'juanperez@gmail.com', '123', 'docente'),
(2, 2, 1, 'Ana Gómez', 'anagomez@gmail.com', '1234', 'docente'),
(3, 2, 1, 'Carlos ruiz', 'carlosruiz@gmail.com', '123', 'docente'),
(4, 2, 1, 'Laura Díaz', 'lauradiaz@gmail.com', '1234', 'docente'),
(5, 2, 1, 'Pedro Torres', 'pedro@gmail.com', '1243', 'docente'),
(6, 2, 1, 'Alejo', 'alejo@gmail.com', '1233', 'docente'),
(7, 2, 1, 'Cristian', 'cristian@gmail.com\r\n', '1234', 'docente');

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
-- Indices de la tabla `estudiantes_no_evaluaron`
--
ALTER TABLE `estudiantes_no_evaluaron`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_facultad` (`id_facultad`);

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
-- Indices de la tabla `notas_plan_mejora`
--
ALTER TABLE `notas_plan_mejora`
  ADD PRIMARY KEY (`id_notas_plan_mejora`),
  ADD KEY `id_plan_mejora` (`id_plan_mejora`);

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
-- AUTO_INCREMENT de la tabla `acta_compromiso`
--
ALTER TABLE `acta_compromiso`
  MODIFY `id_acta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `alertas_bajo_desempeno`
--
ALTER TABLE `alertas_bajo_desempeno`
  MODIFY `id_alerta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coordinacion`
--
ALTER TABLE `coordinacion`
  MODIFY `id_coordinacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `docentes_no_evaluados`
--
ALTER TABLE `docentes_no_evaluados`
  MODIFY `id_docente_No_Evaluado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiantes_no_evaluaron`
--
ALTER TABLE `estudiantes_no_evaluaron`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id_evaluacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `id_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `notas_plan_mejora`
--
ALTER TABLE `notas_plan_mejora`
  MODIFY `id_notas_plan_mejora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodos_academicos`
--
ALTER TABLE `periodos_academicos`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plan_de_mejora`
--
ALTER TABLE `plan_de_mejora`
  MODIFY `id_plan_mejora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proceso_sancion`
--
ALTER TABLE `proceso_sancion`
  MODIFY `id_proceso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `promedio_evaluacion_docente_por_curso`
--
ALTER TABLE `promedio_evaluacion_docente_por_curso`
  MODIFY `id_promedio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Filtros para la tabla `estudiantes_no_evaluaron`
--
ALTER TABLE `estudiantes_no_evaluaron`
  ADD CONSTRAINT `estudiantes_no_evaluaron_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`),
  ADD CONSTRAINT `estudiantes_no_evaluaron_ibfk_2` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`);

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
