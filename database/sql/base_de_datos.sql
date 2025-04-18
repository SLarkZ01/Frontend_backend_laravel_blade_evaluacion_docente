CREATE DATABASE evaluacion_docentes;
USE evaluacion_docentes;
CREATE TABLE Rol (
    id_rol INT PRIMARY KEY ,
    nombre VARCHAR(50) ,
    descripcion TEXT
);
CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY,
    id_rol INT,
    activo BOOLEAN,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('docente', 'coordinador', 'administrador') NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES Rol(id_rol)
);
CREATE TABLE Coordinacion (
    id_coordinacion INT PRIMARY KEY,
    nombre VARCHAR(50)
);

CREATE TABLE Facultad (
    id_facultad INT PRIMARY KEY ,
    id_coordinacion INT,
    nombre VARCHAR(50),
    FOREIGN KEY (id_coordinacion) REFERENCES Coordinacion(id_coordinacion)
);

CREATE TABLE Docente (
    id_docente INT PRIMARY KEY,
    id_usuario INT,
    cod_docente INT,
    nombre varchar(50),
    correo varchar(100),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

CREATE TABLE Programas (
    id_programa INT PRIMARY KEY,
    id_docente INT,
    nombre VARCHAR(255) ,
    id_facultad INT,
    FOREIGN KEY (id_facultad) REFERENCES Facultad(id_facultad),
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente)
);

CREATE TABLE Estudiantes (
    id_estudiante INT PRIMARY KEY ,
    nombre VARCHAR(50),
    correo VARCHAR(50),
    semestre INT,
    id_programa INT,
    FOREIGN KEY (id_programa) REFERENCES Programas(id_programa)
);

CREATE TABLE Cursos (
    id_curso INT PRIMARY KEY ,
    codigo VARCHAR(50) UNIQUE ,
    nombre VARCHAR(50) ,
    id_programa INT,
    id_docente INT,
    FOREIGN KEY (id_programa) REFERENCES Programas(id_programa),
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente)
);

CREATE TABLE Periodos_Academicos (
    id_periodo INT PRIMARY KEY,
    nombre VARCHAR(50) ,
    fecha_inicio DATE ,
    fecha_fin DATE 
);

CREATE TABLE Evaluaciones (
    id_evaluacion INT PRIMARY KEY ,
    id_docente INT,
    id_curso INT,
    id_periodo INT,
    autoevaluacion DECIMAL(3,2),
    evaluacion_decano DECIMAL(3,2),
    evaluacion_estudiantes DECIMAL(3,2),
    promedio_total DECIMAL(3,2),
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso),
    FOREIGN KEY (id_periodo) REFERENCES Periodos_Academicos(id_periodo)
);
CREATE TABLE Docentes_No_Evaluados (
    id_docente_No_Evaluado INT PRIMARY KEY,
    id_evaluacion INT,
    id_facultad INT,
    id_coordinacion INT,
    id_programa INT,
    id_curso INT,
    FOREIGN KEY (id_evaluacion) REFERENCES Evaluaciones(id_evaluacion),
    FOREIGN KEY (id_facultad) REFERENCES Facultad(id_facultad),
    FOREIGN KEY (id_coordinacion) REFERENCES Coordinacion(id_coordinacion),
    FOREIGN KEY (id_programa) REFERENCES Programas(id_programa),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)
);

CREATE TABLE Estudiantes_No_Evaluaron (
    id_estudiante INT PRIMARY KEY ,
    id_programa INT,
    id_facultad INT,
    id_curso INT,
    FOREIGN KEY (id_estudiante) REFERENCES Estudiantes(id_estudiante),
    FOREIGN KEY (id_programa) REFERENCES Programas(id_programa),
    FOREIGN KEY (id_facultad) REFERENCES Facultad(id_facultad),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)
);

CREATE TABLE Comentarios (
    id_comentario INT PRIMARY KEY,
    tipo VARCHAR(50),
    id_docente INT,
    id_programa INT,
    id_coordinacion INT,
    comentario1 TEXT,
    comentario2 TEXT,
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente),
    FOREIGN KEY (id_programa) REFERENCES Programas(id_programa),
    FOREIGN KEY (id_coordinacion) REFERENCES Coordinacion(id_coordinacion)
);

CREATE TABLE Promedio_Evaluacion_Docente_Por_Curso (
    id_promedio INT PRIMARY KEY ,
    id_curso INT,
    id_docente INT,
    promedio_ev_docente DECIMAL(3,2),
    promedio_notas_curso DECIMAL(3,2),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso),
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente)
);





CREATE TABLE Permisos (
    id_permiso INT PRIMARY KEY,
    id_usuario INT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    modulo_permiso VARCHAR(50),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

CREATE TABLE Acta_Compromiso (
    id_acta INT PRIMARY KEY,
    id_docente INT,
    id_facultad INT,
    id_promedio INT,
    retroalimentacion TEXT,
    fecha_generacion DATE,
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente),
    FOREIGN KEY (id_facultad) REFERENCES Facultad(id_facultad),
    FOREIGN KEY (id_promedio) REFERENCES Promedio_Evaluacion_Docente_Por_Curso(id_promedio)
);

CREATE TABLE Plan_De_Mejora (
    id_plan_mejora INT PRIMARY KEY,
    id_facultad INT,
    id_curso INT,
    id_docente INT,
    id_promedio INT,
    progreso INT,
    estado ENUM('Activo','Cerrado','Pendiente'),
    retroalimentacion TEXT,
    FOREIGN KEY (id_facultad) REFERENCES Facultad(id_facultad),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso),
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente),
    FOREIGN KEY (id_promedio) REFERENCES Promedio_Evaluacion_Docente_Por_Curso(id_promedio)
);

CREATE TABLE Notas_Plan_Mejora (
    id_notas_plan_mejora INT PRIMARY KEY,
    id_plan_mejora INT,
    nota TEXT,
    fecha DATE,
    FOREIGN KEY (id_plan_mejora) REFERENCES Plan_De_Mejora(id_plan_mejora)
);

CREATE TABLE Alertas_Bajo_Desempeno (
    id_alerta INT PRIMARY KEY,
    id_facultad INT,
    id_promedio INT,
    id_docente INT,
    id_curso INT,
    FOREIGN KEY (id_facultad) REFERENCES Facultad(id_facultad),
    FOREIGN KEY (id_promedio) REFERENCES Promedio_Evaluacion_Docente_Por_Curso(id_promedio),
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)
);

CREATE TABLE Proceso_Sancion (
    id_proceso INT PRIMARY KEY,
    id_docente INT,
    id_facultad INT,
    id_promedio INT,
    sancion ENUM('Leve','Grave','Retiro_definitivo'),
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente),
    FOREIGN KEY (id_facultad) REFERENCES Facultad(id_facultad),
    FOREIGN KEY (id_promedio) REFERENCES Promedio_Evaluacion_Docente_Por_Curso(id_promedio)
);
INSERT INTO Rol (id_rol,nombre,descripcion)VALUES 
(1, 'Docente', 'Usuario con rol de docente'),
(2, 'Coordinador', 'Usuario coordinador de programa'),
(3, 'Administrador', 'Administrador del sistema');
INSERT INTO Usuarios(id_usuario,id_rol,activo,nombre,correo,contrasena,tipo_usuario) VALUES 
(1, 1, TRUE, 'Juan Pérez', 'juan@correo.com', 'clave123', 'docente'),
(2, 2, TRUE, 'Ana Gómez', 'ana@correo.com', 'clave456', 'coordinador'),
(3, 3, FALSE, 'Carlos Ruiz', 'carlos@correo.com', 'clave789', 'administrador'),
(4, 2, TRUE, 'Laura Díaz', 'laura@correo.com', 'clave321', 'docente'),
(5, 1, TRUE, 'Pedro Torres', 'pedro@correo.com', 'clave654', 'coordinador');

INSERT INTO Coordinacion (id_coordinacion, nombre) VALUES
(1, 'Ingeniería'),
(2, 'Derecho'),
(3, 'Administración'),
(4, 'Contaduría'),
(5, 'deporte');
INSERT INTO Facultad (id_facultad, id_coordinacion, nombre) VALUES
(1, 1, 'Facultad de Ingeniería'),
(2, 2, 'Facultad de Derecho'),
(3, 3, 'Facultad de Administración'),
(4, 4, 'Facultad de Contaduría'),
(5, 5, 'Facultad de Deporte');
INSERT INTO Docente (id_docente, cod_docente) VALUES
(1, 1001), (2, 1002), (3, 1003), (4, 1004), (5, 1005);
INSERT INTO Programas (id_programa, id_docente, nombre, id_facultad) VALUES
(1, 1, 'Ingeniería de Software', 1),
(2, 2, 'Derecho', 2),
(3, 3, 'Administración de Empresas', 3),
(4, 4, 'Contaduría Pública', 4),
(5, 5, 'Acondicionamiento fisico ', 5);
INSERT INTO Estudiantes (id_estudiante,nombre, correo, semestre, id_programa) VALUES
(1,'Ana Gómez', 'ana1@correo.com', 1, 1),
(2,'Luis Díaz', 'luis2@correo.com', 2, 2),
(3,'María Ruiz', 'maria3@correo.com', 3, 3),
(4,'Carlos Pérez', 'carlos4@correo.com', 4, 4),
(5,'Laura Torres', 'laura5@correo.com', 5, 5);
INSERT INTO Cursos (id_curso,codigo, nombre, id_programa, id_docente) VALUES
(1,'CS101', 'Programación I', 1, 1),
(2,'IN201', 'Derecho penal', 2, 2),
(3,'AD301', 'Gestión Financiera', 3, 3),
(4,'CO401', 'Auditoría', 4, 4),
(5,'PS501', 'Acondicionamiento I', 5, 5);
INSERT INTO Periodos_Academicos (id_periodo, nombre, fecha_inicio, fecha_fin) VALUES
(1, '2023-1', '2023-01-10', '2023-06-10'),
(2, '2023-2', '2023-07-10', '2023-12-10'),
(3, '2024-1', '2024-01-10', '2024-06-10'),
(4, '2024-2', '2024-07-10', '2024-12-10'),
(5, '2025-1', '2025-01-10', '2025-06-10');
select * from Evaluaciones;
INSERT INTO Evaluaciones (id_evaluacion,id_docente,id_curso,id_periodo,autoevaluacion,evaluacion_decano,evaluacion_estudiantes,promedio_total)values(
1,1,1,1,3.2,3.3,2.1,2.8),
(2,2,2,2,2.0,3.0,3.2,3.4),
(3,3,3,3,5.0,3.7,2.9,3.8),
(4,4,4,4,4.0,4.0,4.0,4.0),
(5,5,5,5,5.0,5.0,5.0,5.0);
INSERT INTO Docentes_No_Evaluados (id_docente_No_Evaluado, id_evaluacion, id_facultad, id_coordinacion, id_programa, id_curso
) VALUES
(1, 1, 1, 1, 1, 1),
(2, 2, 2, 2, 2, 2),
(3, 3, 3, 3, 3, 3),
(4, 4, 4, 4, 4, 4),
(5, 5, 5, 5, 5, 5);
INSERT INTO Estudiantes_No_Evaluaron (id_estudiante,id_programa ,id_facultad ,id_curso)VALUES 
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3),
(4, 4, 4, 4),
(5, 5, 5, 5);
INSERT INTO Comentarios(id_comentario,tipo,id_docente,id_programa,id_coordinacion,comentario1,comentario2   ) VALUES 
(1, 'Observación general', 1, 1, 1, 'Buen desempeño', 'Debe mejorar en puntualidad'),
(2, 'Sugerencia', 2, 2, 2, 'Interesante clase', 'Más práctica sería útil'),
(3, 'Crítica', 3, 3, 3, 'Falta preparación', 'No responde preguntas'),
(4, 'Reconocimiento', 4, 4, 4, 'Excelente docente', 'Clases muy claras'),
(5, 'Queja', 5, 5, 5, 'Muy estricto', 'No da segundas oportunidades');
INSERT INTO Promedio_Evaluacion_Docente_Por_Curso(id_promedio,id_curso,id_docente,promedio_ev_docente,promedio_notas_curso ) VALUES 
(1, 1, 1, 4.5, 3.8),
(2, 2, 2, 3.9, 3.2),
(3, 3, 3, 2.7, 2.9),
(4, 4, 4, 4.8, 4.6),
(5, 5, 5, 2.5, 2.0);


-- corregir --
INSERT INTO Permisos (id_permiso,id_usuario,nombre,descripcion,
    modulo_permiso)VALUES 
(1, 1, 'Ver Reportes', 'Permite ver reportes del sistema', 'Reportes'),
(2, 2, 'Editar Curso', 'Editar información de cursos', 'Cursos'),
(3, 3, 'Eliminar Usuario', 'Permite eliminar usuarios', 'Administración'),
(4, 4, 'Acceso Evaluaciones', 'Acceder a resultados de evaluación', 'Evaluaciones'),
(5, 5, 'Ver Alertas', 'Visualización de alertas por bajo desempeño', 'Alertas');

INSERT INTO Acta_Compromiso( id_acta,id_docente,id_facultad,id_promedio,retroalimentacion,fecha_generacion) VALUES 
(1, 1, 1, 1, 'Debe mejorar en metodologías activas.', '2025-03-01'),
(2, 2, 2, 2, 'Usar más herramientas digitales.', '2025-03-02'),
(3, 3, 3, 3, 'Participar en capacitaciones.', '2025-03-03'),
(4, 4, 4, 4, 'Incluir retroalimentación oportuna.', '2025-03-04'),
(5, 5, 5, 5, 'Mejorar gestión del tiempo.', '2025-03-05');
INSERT INTO Plan_De_Mejora(id_plan_mejora,id_facultad,id_curso ,id_docente,id_promedio,progreso,estado,retroalimentacion) VALUES 
(1, 1, 1, 1, 1, 50, 'Activo', 'En proceso de mejora continua.'),
(2, 2, 2, 2, 2, 30, 'Pendiente', 'Inicio de acciones postergado.'),
(3, 3, 3, 3, 3, 70, 'Activo', 'Mejoras implementadas parcialmente.'),
(4, 4, 4, 4, 4, 100, 'Cerrado', 'Todas las metas cumplidas.'),
(5, 5, 5, 5, 5, 20, 'Pendiente', 'Docente no ha iniciado acciones.');
INSERT INTO Notas_Plan_Mejora(id_notas_plan_mejora,id_plan_mejora,nota,fecha ) VALUES 
(1, 1, 'Asistió a taller de didáctica.', '2025-03-10'),
(2, 2, 'Implementó rúbricas en evaluación.', '2025-03-12'),
(3, 3, 'Solicitó mentoría pedagógica.', '2025-03-14'),
(4, 4, 'Aplicó feedback a estudiantes.', '2025-03-16'),
(5, 5, 'Está en proceso de planificación.', '2025-03-18');
INSERT INTO Alertas_Bajo_Desempeno(id_alerta,id_facultad,id_promedio,id_docente,id_curso) VALUES 
(1, 1, 1, 1, 1),
(2, 2, 2, 2, 2),
(3, 3, 3, 3, 3),
(4, 4, 4, 4, 4),
(5, 5, 5, 5, 5);
INSERT INTO Proceso_Sancion(id_proceso,id_docente,id_facultad,id_promedio, sancion) VALUES 
(1, 1, 1, 1, 'Leve'),
(2, 2, 2, 2, 'Grave'),
(3, 3, 3, 3, 'Leve'),
(4, 4, 4, 4, 'Grave'),
(5, 5, 5, 5, 'Retiro_definitivo');

select * from Estudiantes_No_Evaluaron;