DELIMITER $$

-- Procedimiento para obtener las actas de compromiso con información de docentes y promedios
CREATE PROCEDURE GetActasCompromiso()
BEGIN
    SELECT 
        a.*,
        d.nombre AS nombre_docente,
        p.promedio_ev_docente AS calificacion
    FROM 
        acta_compromiso a
        JOIN docente d ON a.id_docente = d.id_docente
        JOIN promedio_evaluacion_docente_por_curso p ON a.id_promedio = p.id_promedio;
END$$

-- Procedimiento para obtener un acta de compromiso específica por ID
CREATE PROCEDURE GetActaCompromisoById(IN acta_id INT)
BEGIN
    SELECT 
        a.*,
        d.nombre AS nombre_docente,
        p.promedio_ev_docente AS calificacion
    FROM 
        acta_compromiso a
        JOIN docente d ON a.id_docente = d.id_docente
        JOIN promedio_evaluacion_docente_por_curso p ON a.id_promedio = p.id_promedio
    WHERE 
        a.id_acta = acta_id;
END$$

-- Procedimiento para crear una nueva acta de compromiso
CREATE PROCEDURE CreateActaCompromiso(
    IN p_id_docente INT,
    IN p_id_facultad INT,
    IN p_id_promedio INT,
    IN p_retroalimentacion TEXT,
    IN p_fecha_generacion DATE
)
BEGIN
    INSERT INTO acta_compromiso (
        id_docente,
        id_facultad,
        id_promedio,
        retroalimentacion,
        fecha_generacion
    ) VALUES (
        p_id_docente,
        p_id_facultad,
        p_id_promedio,
        p_retroalimentacion,
        p_fecha_generacion
    );
    
    -- Retornar el ID del acta recién creada
    SELECT LAST_INSERT_ID() AS id_acta;
END$$

-- Procedimiento para actualizar un acta de compromiso existente
CREATE PROCEDURE UpdateActaCompromiso(
    IN p_id_acta INT,
    IN p_retroalimentacion TEXT,
    IN p_fecha_generacion DATE
)
BEGIN
    UPDATE acta_compromiso
    SET 
        retroalimentacion = p_retroalimentacion,
        fecha_generacion = p_fecha_generacion
    WHERE 
        id_acta = p_id_acta;
    
    -- Retornar el número de filas afectadas
    SELECT ROW_COUNT() AS rows_updated;
END$$

-- Procedimiento para eliminar un acta de compromiso
CREATE PROCEDURE DeleteActaCompromiso(IN p_id_acta INT)
BEGIN
    DELETE FROM acta_compromiso
    WHERE id_acta = p_id_acta;
    
    -- Retornar el número de filas afectadas
    SELECT ROW_COUNT() AS rows_deleted;
END$$

DELIMITER ;