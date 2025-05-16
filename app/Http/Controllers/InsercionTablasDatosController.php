<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class InsercionTablasDatosController extends Controller
{
    public function InsertarDocentes(array $datos): void
    {
        // Eliminar la cabecera (primera fila)
        // unset($datos[6]);
      

        foreach ($datos as $fila) {
            // Ajustar índices a la estructura del Excel
            $nombre = $fila[2] ?? '';         // Columna C: Nombre del docente
            $codigo = trim($fila[7] ?? '');   // Columna E: Código del docente

            $id_usuario = DB::select('CALL ObtenerIdUsuarioPorNombre(?)', [$nombre]); 
            $id_usuario = $id_usuario[0]->id_usuario ?? null;

            // Insertar docente en la base de datos
            DB::insert('INSERT INTO docente (id_usuario, cod_docente) VALUES (?,?)', [
                $id_usuario,
                $codigo
            ]);
        }
    }
    public function InsertarProgramas(array $datos): void
{
    foreach ($datos as $fila) {
        // Ajustar índices a la estructura del Excel
        $nombreFacultad = 'Facultad de Derecho';
        $nombrePrograma = $fila[1] ?? '';
        $nombreDocente = $fila[2] ?? '';

        // Verificar si ya existe un programa con ese nombre
        $existe = DB::table('programas')->where('nombre', $nombreFacultad)->exists();
        if ($existe) {
            continue; // Saltar esta fila si el programa ya existe
        }

        // Obtener ID del docente
        $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$nombreDocente]);
        $id_docente = $id_docente[0]->id_docente ?? null;

        // Obtener ID de la facultad 
        $id_falcultad = DB::select('CALL ObtenerIdFacultadPorNombre(?)', [$nombreFacultad]);
        $id_falcultad = $id_falcultad[0]->id_falcultad ?? null;

        // Insertar programa en la base de datos
        DB::insert('INSERT INTO programas (id_docente,nombre,id_facultad) VALUES (?,?,?)', [
            $id_docente,
            $nombrePrograma,
            $id_falcultad
        ]);
    }
}
public function InsertarCursos(array $datos): void
{
    foreach ($datos as $fila) {

        $codigo = $fila[4]; // fecha de inicio
        $nombre = $fila[5]; // fecha de fin
        $programa = $fila[2];
        $docente=$fila[3];
        $id_programa= DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$programa]); // id_programa
         $id_programa = $id_facultad[0]->id_programa ?? null;
        $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$docente]); // id_programa
         $id_docente = $id_docente[0]->id_docente ?? null;

        DB::insert('INSERT INTO cursos (codigo, nombre, id_programa, id_docente) VALUES (?,?,?,?)', [
            $codigo,
            $nombre,
            $id_programa,
            $id_docente
        ]);
    }
}

    public function InsertarEstudiantesNoEvaluaronCurso(array $datos): void
    {
        // Eliminar la cabecera (primera fila)
        // unset($datos[6]);
       

        foreach ($datos as $fila) {
            // Ajustar índices a la estructura del Excel
            $semestre = $fila[2] ?? '';     
            $cod_estudiante = $fila[3] ?? '';  
            $nombre = $fila[4] ?? '';  
            $email = $fila[5] ?? '';  
            $codigo_curso = $fila[6] ?? ''; 
            $nombre_curso = $fila[7] ?? ''; 
           

            $id_facultad = DB::select('CALL ObtenerIdFacultadPorNombre(?)', [$nombre]); 
            $id_facultad = $resultado[0]->id_facultad ?? null;

            $id_programa = DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$nombre]); 
            $id_programa = $resultado[0]->id_programa ?? null;

            

            // Insertar docente en la base de datos
            DB::insert('INSERT INTO programas ( id_facultad,id_programa,semestre,cod_estudiante,nombre,email,codigo_curso,nombre_curso) VALUES (?,?,?,?,?,?,?,?)', [
                $id_facultad,
                $id_programa,
                $semestre,
                $cod_estudiante,
                $email,
                $codigo_curso,
                $nombre_curso
            ]);
        
        }
    }
   
    public function insertarEvaluaciones(array $datos): void
   {
      foreach ($datos as $fila) {

        $codigo = $fila[4]; // fecha de inicio
        $nombre = $fila[5]; // fecha de fin
        $facultad = $fila[2];
        $docente=$fila[3];
        $id_facultad = DB::select('CALL ObtenerIdFacultadPorNombre(?)', [$facultad]); // id_programa
        $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$facultad]); // id_programa

        DB::insert('INSERT INTO evaluaciones (id_docente,id_curso,id_periodo,autoevaluacion,evaluacion_decano,evaluacion_estudiantes
,promedio_total ) VALUES (?,?,?,?)', [
            $codigo,
            $nombre,
            $id_facultad,
            $id_docente
        ]);
     }
   }
    public function InsertarComentarios(array $datos): void

    {

        foreach ($datos as $fila) {
            $id_comentario = $fila[0]; // id_comentario
            $tipo= $fila[1]; // tipo
            $nombrePrograma = $fila[3]; // nombre del programa
            $id_programa= DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$nombrePrograma]);
            $id_programa = $resultado[0]->id_programa ?? null;; // id_programa
            $nombreUsuario = $fila[5]; // nombre del docente
            $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$nombreUsuario]);
            $id_docente = $resultado[0]->id_docente ?? null; // id_docente
            $nombreCoordinacion = $fila[4]; // nombre de la coordinacion
            $id_coordinacion= DB::select('CALL ObtenerIdCoordinacionPorNombre(?)', [$nombreCoordinacion]);
            $id_coordinacion= $resultado[0]->id_coordinacion ?? null;// id_coordinacion
            $comentario1 = $fila[6]; // comentario1
            $comentario2= $fila[7]; // comentario2
            DB::insert('INSERT INTO comentarios (id_comentario, tipo, id_docente, id_programa, id_coordinacion, comentario1, comentario2) VALUES (?, ?, ?, ?, ?, ?, ?)', [
            $id_comentario, // id_comentario
            $tipo, // tipo
            $id_docente, // id_docente
            $id_programa, // id_programa
            $id_coordinacion, // id_coordinacion
            $comentario1, // comentario1
            $comentario2, // comentario2
            ]);
            $id_comentario++;
        }
    }

    public function InsertarPromedios(array $datos): void
    {
        foreach ($datos as $fila) {
            $id_promedio = $fila[0]; // id_promedio
            $nombreCurso = $fila[5]; // nombre del curso
            $id_curso = DB::select('CALL ObtenerIdCursoPorNombre(?)', [$nombreCurso]);
            $id_curso= $resultado[0]->id_curso ?? null; // id_curso
            $nombreUsuario = $fila[3]; // nombre del docente
            $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$nombreUsuario]);
            $id_docente = $resultado[0]->id_docente ?? null; // id_docente
            $promedio_ev_docente = $fila[6]; // promedio_ev_docente
            $promedio_notas_curso = $fila[7]; // promedio_notas_curso

            // Insertar promedio en la base de datos
            DB::insert('INSERT INTO promedio_evaluacion_docente_por_curso (id_promedio, id_curso, id_docente, promedio_ev_docente, promedio_notas_curso) VALUES (?, ?, ?, ?, ?)', [
                $id_promedio, // id_promedio
                $id_curso, // id_curso
                $id_docente, // id_docente
                $promedio_ev_docente, // promedio_ev_docente
                $promedio_notas_curso // promedio_notas_curso

            ]);
            $id_promedio++;
        }
    }

    public function InsertarPermisos(array $datos): void
    {
        foreach ($datos as $fila) {
            DB::insert('INSERT INTO permisos (id_permiso, id_usuario, nombre, descripcion, modulo_permiso) VALUES (?, ?, ?, ?, ?)', [
                $fila[0], $fila[1], $fila[2], $fila[3], $fila[4]
            ]);
        }
    }

    public function InsertarActas(array $datos): void
    {
        foreach ($datos as $fila) {
            DB::insert('INSERT INTO acta_compromiso (id_acta, id_docente, id_facultad, id_promedio, retroalimentacion, fecha_generacion) VALUES (?, ?, ?, ?, ?, ?)', [
                $fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5]
            ]);
        }
    }

    public function InsertarPlanesMejora(array $datos): void
    {
        foreach ($datos as $fila) {
            DB::insert('INSERT INTO plan_de_mejora (id_plan_mejora, id_facultad, id_curso, id_docente, id_promedio, progreso, estado, retroalimentacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                $fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5], $fila[6], $fila[7]
            ]);
        }
    }

    public function InsertarNotasPlanMejora(array $datos): void
    {
        foreach ($datos as $fila) {
            DB::insert('INSERT INTO notas_plan_mejora (id_notas_plan_mejora, id_plan_mejora, nota, fecha) VALUES (?, ?, ?, ?)', [
                $fila[0], $fila[1], $fila[2], $fila[3]
            ]);
        }
    }
    public function InsertarAlertas(array $datos): void
{
    foreach ($datos as $fila) {
        DB::insert('INSERT INTO alertas_bajo_desempeno (id_alerta, id_facultad, id_promedio, id_docente, id_curso) VALUES (?, ?, ?, ?, ?)', [
            $fila[0], $fila[1], $fila[2], $fila[3], $fila[4]
        ]);
    }
}

public function InsertarProcesosSancion(array $datos): void
{
    foreach ($datos as $fila) {
        
        DB::insert('INSERT INTO proceso_sancion (id_proceso, id_docente, id_facultad, id_promedio, sancion) VALUES (?, ?, ?, ?, ?)', [
            $fila[0], $fila[1], $fila[2], $fila[3], $fila[4]
        ]);
    }
}
public function insertarDocentesNoEvaluados(array $datos): void
{
    foreach ($datos as $fila) {
       
        $nombreFacultad = $fila[0]; // nombre de la facultad
        $id_facultad = DB::select('CALL ObtenerIdFacultadPorNombre(?)', [$nombreFacultad]); // id_facultad
        $id_facultad = $resultado[0]->id_facultad ?? null; // id_facultad
        $nombreCoordinacion = $fila[1]; // nombre de la coordinacion
        $id_coordinacion = DB::select('CALL ObtenerIdCoordinacionPorNombre(?)', [$nombreCoordinacion]); // id_coordinacion
        $id_coordinacion = $resultado[0]->id_coordinacion ?? null; // id_coordinacion
        $nombrePrograma = $fila[2]; // nombre del programa
        $id_programa= DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$nombrePrograma]); // id_programa
        $id_programa = $resultado[0]->id_programa ?? null; // id_programa
        $nombreCurso = $fila[7]; // nombre del curso
        $id_curso= DB::select('CALL ObtenerIdCursoPorNombre(?)', [$nombreCurso]); // id_curso
        $id_curso = $resultado[0]->id_curso ?? null; // id_curso
        
        DB::insert('INSERT INTO docentes_no_evaluados (id_evaluacion,id_facultad,id_coordinacion,id_programa,id_curso) VALUES (?, ?, ?, ?, ?,?)', [
               
                $id_facultad ,
                $id_facultad , 
                $id_coordinacion,
                $id_programa,
                $id_curso
            ]);
       
    }
                
    }
  public function insertarPeriodosAcademicos(array $datos): void
   {
    foreach ($datos as $fila) {

        $fecha_inicio = $fila[8]; // fecha de inicio
        $fecha_fin = $fila[9]; // fecha de fin

        DB::insert('INSERT INTO periodos_academicos (fecha_inicio, fecha_fin ) VALUES (?, ?)', [
            $fecha_inicio,
            $fecha_fin
        ]);
      
    }
  }
 
}
    

