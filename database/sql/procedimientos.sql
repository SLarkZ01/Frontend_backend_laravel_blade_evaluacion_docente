DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE GetEvaluacionesCompletas()
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE GetEvaluacionesPendientes()
BEGIN
    SELECT COUNT(*) AS evaluaciones_completas
    FROM evaluaciones E
    INNER JOIN periodos_academicos P ON E.id_periodo = P.id_periodo
    WHERE P.id_periodo = p_id_periodo
      AND E.autoevaluacion IS NOT NULL
      AND E.evaluacion_decano IS NOT NULL
      AND E.evaluacion_estudiantes IS NOT NULL;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE ObtenerDocentesDestacados()
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE ObtenerPromedioPorFacultad()
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE notas_clasificadas()
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE promedio_global()
BEGIN
    SELECT ROUND(AVG(promedio_total), 2) AS promedio_global
    FROM Evaluaciones;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE promedio_por_curso()
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE totalNoEvaluados()
BEGIN
    SELECT COUNT(*) AS total_no_evaluados
    FROM Docentes_No_Evaluados;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE total_docentes()
BEGIN
    SELECT COUNT(*) AS total_docentes FROM Docente;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=root@localhost PROCEDURE total_estudiantes_no_evaluaron()
BEGIN
    SELECT COUNT(*) As total_estudiantes_no_evaluaron
    FROM estudiantes_no_evaluaron;
END$$
DELIMITER ;