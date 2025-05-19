<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;
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
        $id_programa = $id_programa[0]->id_programa ?? null;
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
public function convertirFecha($fecha)
{
    // Si es un número (fecha serial de Excel)
    if (is_numeric($fecha)) {
        // Excel base: 1899-12-30 (según PhpSpreadsheet)
        $fechaPhp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha);
        return $fechaPhp->format('Y-m-d');
    }

    // Si es texto tipo MM/DD/YYYY
    $partes = explode('/', $fecha);
    if (count($partes) !== 3) {
        return null;
    }

    $mes = str_pad(intval($partes[0]), 2, '0', STR_PAD_LEFT);
    $dia = str_pad(intval($partes[1]), 2, '0', STR_PAD_LEFT);
    $anio = intval($partes[2]);

    return "$anio-$mes-$dia";
}

  public function InsertarPeriodosAcademicos(array $datos): void
  {
    foreach ($datos as $fila) {

        $fecha_inicio = $fila[8]; // fecha de inicio
        $fecha_fin = $fila[9]; // fecha de fin
        //$fecha_inicio = '2023-03-16'; // fecha de inicio
        //$fecha_fin = '2023-03-26'; // fecha de fin
         $iniDef =$this->convertirFecha($fecha_inicio);
         $finDef =$this->convertirFecha($fecha_fin);

        DB::insert('INSERT INTO periodos_academicos (fecha_inicio,fecha_fin,nombre) VALUES (?,?,?)', [
            $iniDef,
           $finDef,
           $iniDef
        ]);
      
    }
  }

public function InsertarEvaluaciones(array $datos): void
   {
      foreach ($datos as $fila) {

        $docente = $fila[2]; // fecha de inicio
        $programa = $fila[1]; // fecha de fin
        $autoevaluacion = $fila[3];
        $evaluacion_decano=$fila[4];
        $evaluacion_estudiantes=$fila[5];
        $promedio_total=$fila[6];
 
        $id_programa = DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$programa]); // id_programa
         $id_programa = $id_programa[0]->id_programa ?? null;
        $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$docente]); // id_programa
         $id_docente = $id_docente[0]->id_docente ?? null;

        DB::insert('INSERT INTO Evaluaciones (id_docente,id_programa,autoevaluacion,evaluacion_decano,evaluacion_estudiantes,promedio_total) VALUES (?,?,?,?,?,?)', [
            $id_docente,
            $id_programa,
            $autoevaluacion,
            $evaluacion_decano,
            $evaluacion_estudiantes,
            $promedio_total
        ]);
     }
   }
   public function InsertarDocentesNoAutoEvaluados(array $datos): void
{
    foreach ($datos as $fila) 
    {
       
        $nombreFacultad = $fila[0]; // nombre de la facultad
        $nombreCoordinacion = $fila[1]; // nombre de la coordinacion
        $nombrePrograma = $fila[2]; // nombre del programa
        $nombreDocente = $fila[4]; // nombre del curso
        
        $id_coordinacion = DB::select('CALL ObtenerIdCoordinacionPorNombre(?)', [$nombreCoordinacion]); // id_coordinacion
        $id_coordinacion = $id_coordinacion[0]->id_coordinacion ?? null; // id_coordinacion

     
        $id_programa= DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$nombrePrograma]); // id_programa
        $id_programa = $id_programa[0]->id_programa ?? null; // id_programa


        $id_facultad = DB::select('CALL ObtenerIdFacultadPorNombre(?)', [$nombreFacultad]); // id_facultad
        $id_facultad = $id_facultad[0]->id_facultad ?? null; // id_facultad

        
        $id_docente= DB::select('CALL ObtenerIdDocentePorNombre(?)', [$nombreDocente]); // id_curso
        $id_docente = $id_docente[0]->id_docente ?? null; // id_curso
        
        DB::insert('INSERT INTO Docentes_No_AutoEvaluados (id_facultad,id_coordinacion,id_programa,id_docente) VALUES (?,?,?,?)', [
               
                $id_facultad,
                $id_coordinacion, 
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
            $facultad = $fila[0] ?? ''; 
            $programa = $fila[1] ?? ''; 
            $semestre = $fila[2] ?? '';     
            $cod_estudiante = $fila[3] ?? '';  
            $nombre = $fila[4] ?? '';  
            $email = $fila[5] ?? '';  
            $codigo_curso = $fila[6] ?? ''; 
            $nombre_curso = $fila[7] ?? ''; 
           

            $id_facultad = DB::select('CALL ObtenerIdFacultadPorNombre(?)', [$facultad]); 
            $id_facultad = $id_facultad[0]->id_facultad ?? null;

            $id_programa = DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$programa]); 
            $id_programa = $id_programa[0]->id_programa ?? null;

            

            // Insertar docente en la base de datos
            DB::insert('INSERT INTO Estudiantes_No_Evaluaron( id_facultad,id_programa,semestre,cod_estudiante,nombre,email,codigo_curso,nombre_curso) VALUES (?,?,?,?,?,?,?,?)', [
                $id_facultad,
                $id_programa,
                $semestre,
                $cod_estudiante,
                $nombre,
                $email,
                $codigo_curso,
                $nombre_curso
            ]);
        
        }
    }
   
    
    public function InsertarComentarios(array $datos): void

    {

        foreach ($datos as $fila) {
            $tipo= $fila[0]; // tipo
            $nombrePrograma = $fila[3]; // nombre del programa           
            $nombreUsuario = $fila[4]; // nombre del docente
            $nombreCoordinacion = $fila[2]; // nombre de la coordinacion
            $id_programa= DB::select('CALL ObtenerIdProgramaPorNombre(?)', [$nombrePrograma]);    
            $id_programa = $id_programa[0]->id_programa ?? null;; // id_programa    
            $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$nombreUsuario]);
            $id_docente = $id_docente[0]->id_docente ?? null; // id_docente
            $id_coordinacion= DB::select('CALL ObtenerIdCoordinacionPorNombre(?)', [$nombreCoordinacion]);
            $id_coordinacion= $id_coordinacion[0]->id_coordinacion ?? null;// id_coordinacion
            $comentario1 = $fila[5]; // comentario1
            $comentario2= $fila[6]; // comentario2

            DB::insert('INSERT INTO comentarios ( tipo, id_docente, id_programa, id_coordinacion, comentario1, comentario2) VALUES (?,?,?,?,?,?)', [
            $tipo, // tipo
            $id_docente, // id_docente
            $id_programa, // id_programa
            $id_coordinacion, // id_coordinacion
            $comentario1, // comentario1
            $comentario2, // comentario2
            ]);        
        }
    }

    public function InsertarPromedios(array $datos): void
    {
        foreach ($datos as $fila) {
          
            $nombreCurso = $fila[5]; // nombre del curso
            $id_curso = DB::select('CALL ObtenerIdCursoPorNombre(?)', [$nombreCurso]);
            $id_curso= $id_curso[0]->id_curso ?? null; // id_curso
            $nombreUsuario = $fila[3]; // nombre del docente
            $id_docente = DB::select('CALL ObtenerIdDocentePorNombre(?)', [$nombreUsuario]);
            $id_docente = $id_docente[0]->id_docente ?? null; // id_docente
            $promedio_ev_docente = $fila[6]; // promedio_ev_docente
            $promedio_notas_curso = $fila[7]; // promedio_notas_curso

            // Insertar promedio en la base de datos
            DB::insert('INSERT INTO promedio_evaluacion_docente_por_curso (id_curso,id_docente,promedio_ev_docente,promedio_notas_curso) VALUES (?,?,?,?)', [
               
                $id_curso, // id_curso
                $id_docente, // id_docente
                $promedio_ev_docente, // promedio_ev_docente
                $promedio_notas_curso // promedio_notas_curso
            ]);
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

  
 
}
    

