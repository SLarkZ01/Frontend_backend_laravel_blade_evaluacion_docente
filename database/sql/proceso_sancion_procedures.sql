-- Procedimiento para obtener todos los procesos de sanción
DELIMITER //
CREATE PROCEDURE ObtenerProcesosSancion()
BEGIN
    SELECT * FROM proceso_sancion ORDER BY fecha_emision DESC;
END //
DELIMITER ;

-- Procedimiento para obtener un proceso de sanción por ID
DELIMITER //
CREATE PROCEDURE ObtenerProcesoSancionPorId(IN p_id_sancion INT)
BEGIN
    SELECT * FROM proceso_sancion WHERE id_sancion = p_id_sancion;
END //
DELIMITER ;

-- Procedimiento para buscar procesos de sanción por nombre de docente
DELIMITER //
CREATE PROCEDURE BuscarProcesoSancionPorDocente(IN p_nombre VARCHAR(255))
BEGIN
    SELECT * FROM proceso_sancion 
    WHERE nombre_docente LIKE CONCAT('%', p_nombre, '%') 
    OR apellido_docente LIKE CONCAT('%', p_nombre, '%')
    ORDER BY fecha_emision DESC;
END //
DELIMITER ;

-- Procedimiento para filtrar procesos de sanción por tipo
DELIMITER //
CREATE PROCEDURE FiltrarProcesoSancionPorTipo(IN p_tipo_sancion VARCHAR(255))
BEGIN
    SELECT * FROM proceso_sancion 
    WHERE tipo_sancion = p_tipo_sancion
    ORDER BY fecha_emision DESC;
END //
DELIMITER ;

-- Procedimiento para filtrar procesos de sanción por rango de calificación
DELIMITER //
CREATE PROCEDURE FiltrarProcesoSancionPorCalificacion(IN p_calificacion_min DECIMAL(3,2), IN p_calificacion_max DECIMAL(3,2))
BEGIN
    SELECT * FROM proceso_sancion 
    WHERE calificacion_final BETWEEN p_calificacion_min AND p_calificacion_max
    ORDER BY calificacion_final ASC;
END //
DELIMITER ;

-- Procedimiento para crear un nuevo proceso de sanción
DELIMITER //
CREATE PROCEDURE CrearProcesoSancion(
    IN p_numero_resolucion VARCHAR(255),
    IN p_fecha_emision DATE,
    IN p_nombre_docente VARCHAR(255),
    IN p_apellido_docente VARCHAR(255),
    IN p_identificacion_docente VARCHAR(255),
    IN p_asignatura VARCHAR(255),
    IN p_calificacion_final DECIMAL(3,2),
    IN p_tipo_sancion VARCHAR(255),
    IN p_antecedentes TEXT,
    IN p_fundamentos TEXT,
    IN p_resolucion TEXT,
    IN p_firma_path VARCHAR(255)
)
BEGIN
    INSERT INTO proceso_sancion (
        numero_resolucion,
        fecha_emision,
        nombre_docente,
        apellido_docente,
        identificacion_docente,
        asignatura,
        calificacion_final,
        tipo_sancion,
        antecedentes,
        fundamentos,
        resolucion,
        firma_path,
        enviado,
        created_at,
        updated_at
    ) VALUES (
        p_numero_resolucion,
        p_fecha_emision,
        p_nombre_docente,
        p_apellido_docente,
        p_identificacion_docente,
        p_asignatura,
        p_calificacion_final,
        p_tipo_sancion,
        p_antecedentes,
        p_fundamentos,
        p_resolucion,
        p_firma_path,
        FALSE,
        NOW(),
        NOW()
    );
    
    SELECT LAST_INSERT_ID() AS id_sancion;
END //
DELIMITER ;

-- Procedimiento para actualizar un proceso de sanción
DELIMITER //
CREATE PROCEDURE ActualizarProcesoSancion(
    IN p_id_sancion INT,
    IN p_numero_resolucion VARCHAR(255),
    IN p_fecha_emision DATE,
    IN p_nombre_docente VARCHAR(255),
    IN p_apellido_docente VARCHAR(255),
    IN p_identificacion_docente VARCHAR(255),
    IN p_asignatura VARCHAR(255),
    IN p_calificacion_final DECIMAL(3,2),
    IN p_tipo_sancion VARCHAR(255),
    IN p_antecedentes TEXT,
    IN p_fundamentos TEXT,
    IN p_resolucion TEXT,
    IN p_firma_path VARCHAR(255)
)
BEGIN
    UPDATE proceso_sancion SET
        numero_resolucion = p_numero_resolucion,
        fecha_emision = p_fecha_emision,
        nombre_docente = p_nombre_docente,
        apellido_docente = p_apellido_docente,
        identificacion_docente = p_identificacion_docente,
        asignatura = p_asignatura,
        calificacion_final = p_calificacion_final,
        tipo_sancion = p_tipo_sancion,
        antecedentes = p_antecedentes,
        fundamentos = p_fundamentos,
        resolucion = p_resolucion,
        firma_path = CASE WHEN p_firma_path IS NOT NULL THEN p_firma_path ELSE firma_path END,
        updated_at = NOW()
    WHERE id_sancion = p_id_sancion;
    
    SELECT ROW_COUNT() AS rows_updated;
END //
DELIMITER ;

-- Procedimiento para eliminar un proceso de sanción
DELIMITER //
CREATE PROCEDURE EliminarProcesoSancion(IN p_id_sancion INT)
BEGIN
    DELETE FROM proceso_sancion WHERE id_sancion = p_id_sancion;
    SELECT ROW_COUNT() AS rows_deleted;
END //
DELIMITER ;

-- Procedimiento para marcar un proceso de sanción como enviado
DELIMITER //
CREATE PROCEDURE MarcarProcesoSancionComoEnviado(IN p_id_sancion INT)
BEGIN
    UPDATE proceso_sancion SET
        enviado = TRUE,
        updated_at = NOW()
    WHERE id_sancion = p_id_sancion;
    
    SELECT ROW_COUNT() AS rows_updated;
END //
DELIMITER ;

-- Procedimiento para obtener docentes con calificaciones bajas (candidatos a sanción)
DELIMITER //
CREATE PROCEDURE ObtenerDocentesCalificacionesBajas(IN p_calificacion_maxima DECIMAL(3,2))
BEGIN
    SELECT 
        d.id_docente,
        d.nombre AS nombre_docente,
        d.apellido AS apellido_docente,
        d.identificacion,
        c.nombre AS asignatura,
        AVG(e.calificacion_final) AS promedio_calificacion
    FROM 
        docentes d
    JOIN 
        cursos c ON d.id_docente = c.id_docente
    JOIN 
        evaluaciones e ON c.id_curso = e.id_curso
    GROUP BY 
        d.id_docente, c.id_curso
    HAVING 
        promedio_calificacion <= p_calificacion_maxima
    ORDER BY 
        promedio_calificacion ASC;
END //
DELIMITER ;