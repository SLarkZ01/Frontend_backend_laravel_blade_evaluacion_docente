<?php
namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\InsercionTablasDatosController;
use Exception;

class ExcelImportController extends Controller
{
    public function importar(Request $request)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|mimes:xlsx,xls,csv',
                'tipo_datos' => 'required|in:evaluaciones,programas,estudiantes'
            ]);

            // Obtener el archivo
            $file = $request->file('archivo');
            $tipo = $request->input('tipo_datos');
            $hoja1 = $this->procesarExcel($file);
            $hoja2 = $this->procesarExcel($file,'COMENTARIOS');
            $hoja3 = $this->procesarExcel($file,'TOTAL PROMEDIOS VS PROMCALIFICA');
            $hoja4 = $this->procesarExcel($file,'ESTUD NO EVALUARON CURSOS');
            $hoja5 = $this->procesarExcel($file,'DOCENTES NO EVALUARON CURSOS');
            $hoja6 = $this->procesarExcel($file,'DOCENTES NO AUTOEVAL GENERAL');
            // Procesar el archivo según su tipo
            // if ($file->getClientOriginalExtension() == 'csv') {
            //     $datos = $this->procesarCSV($file);
            // } else {
            //     // Para archivos Excel, usamos una biblioteca nativa de PHP
            //     $datos = $this->procesarExcel($file);
            // }
            $controller = new InsercionTablasDatosController();
             $controller->InsertarDocentes($hoja1);
             $controller->InsertarProgramas($hoja1);
             $controller->InsertarCursos($hoja3);
             $controller->InsertarPeriodosAcademicos($hoja5);
             $controller->InsertarEvaluaciones($hoja1);
             $controller->InsertarDocentesNoAutoEvaluados($hoja6);
             $controller->InsertarEstudiantesNoEvaluaronCurso($hoja4);
             $controller->InsertarComentarios($hoja2);
             $controller->InsertarPromedios($hoja3);
             

            
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['mensaje' => 'Importación completada correctamente'], 200);
            }
            
            return redirect()->back()->with('success', 'Importación completada correctamente');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Error al importar: ' . $e->getMessage()], 500);
            }
            
            return redirect()->back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }
    
    /**
     * Procesa un archivo CSV
     */
    private function procesarCSV($file)
    {
        $datos = [];
        $handle = fopen($file->getRealPath(), 'r');
        
        if ($handle !== false) {
            // Leer línea por línea
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $datos[] = $data;
            }
            fclose($handle);
        }
        
        return $datos;
    }
    
    /**
     * Procesa un archivo Excel usando funciones nativas
     */
  private function procesarExcel($file, $nombreHoja = 'TOTAL PROMEDIOS')
{
    $spreadsheet = IOFactory::load($file->getRealPath());

    // Obtener la hoja por nombre
    $hoja = $spreadsheet->getSheetByName($nombreHoja);

    if (!$hoja) {
        throw new \Exception("La hoja '$nombreHoja' no fue encontrada en el archivo.");
    }

    // Detectar la última fila y columna con datos reales
    $ultimaFila = $hoja->getHighestDataRow();
    $ultimaColumna = $hoja->getHighestDataColumn();

    // Determinar el inicio del rango
    $inicio = $nombreHoja === 'TOTAL PROMEDIOS' ? 'A6' : 'A2';

    // Armar el rango dinámico
    $rango = "{$inicio}:{$ultimaColumna}{$ultimaFila}";

    // Leer los datos del rango
    $datos = $hoja->rangeToArray($rango, null, true, false, false);

    return $datos;
}

  
    
 

    
}
