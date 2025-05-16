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

            // Procesar el archivo según su tipo
            if ($file->getClientOriginalExtension() == 'csv') {
                $datos = $this->procesarCSV($file);
            } else {
                // Para archivos Excel, usamos una biblioteca nativa de PHP
                $datos = $this->procesarExcel($file);
            }
            (new InsercionTablasDatosController())->InsertarDocentes($datos);


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



    private function InsertarDocentes(array $datos): void
{
    // Eliminar la cabecera (primera fila)
    //unset($datos[6]);
       $id=6;

    foreach ($datos as $fila) {
        // Ajustar índices a la estructura del Excel
        $nombre = $fila[2] ?? '';        // Columna C: Nombre del docente
        $codigo = trim($fila[7] ?? '');   // Columna E: Código del docente
        $id_usuario= DB::select('CALL ObtenerIdUsuarioPorNombre(?)', [$nombre]);
        $id_usuario = $resultado[0]->id_usuario ?? null;
        // Insertar docente en la base de datos
        DB::insert('INSERT INTO docente (id_docente,id_usuario,cod_docente) VALUES (?,?,?)', [
             $id,
             $id_usuario,
             $codigo
        ]);
        $id++;
    }

}
public function InsertarComentarios(array $datos): void
{
     foreach ($datos as $fila) {
            $id_comentario = $fila[0]; // id_comentario
            $tipo= $fila[1]; // tipo
            $id_docente = DB::select(' ObtenerComentariosPorDocente ?', [$id_docente]); // id_docente
            $id_programa= $fila[3]; // id_programa
            $id_coordinacion= $fila[4];// id_coordinacion
            $comentario1 = $fila[5]; // comentario1
            $comentario2= $fila[6]; // comentario2
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


}
