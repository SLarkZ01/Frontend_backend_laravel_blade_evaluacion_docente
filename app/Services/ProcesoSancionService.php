<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class ProcesoSancionService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.url') . '/api/procesos-sancion';
    }

    /**
     * Get all procesos de sanción
     *
     * @return array
     */
    public function getAll()
    {
        try {
            $response = Http::get($this->baseUrl);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al obtener procesos de sanción', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Get proceso de sanción by ID
     *
     * @param int $id
     * @return array
     */
    public function getById($id)
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$id}");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Proceso de sanción no encontrado', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Create a new proceso de sanción
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        try {
            $response = Http::post($this->baseUrl, $data);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al crear proceso de sanción', 'error' => $response->json()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Update an existing proceso de sanción
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, array $data)
    {
        try {
            $response = Http::put("{$this->baseUrl}/{$id}", $data);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al actualizar proceso de sanción', 'error' => $response->json()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete a proceso de sanción
     *
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        try {
            $response = Http::delete("{$this->baseUrl}/{$id}");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al eliminar proceso de sanción', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Mark a proceso de sanción as sent
     *
     * @param int $id
     * @return array
     */
    public function markAsSent($id)
    {
        try {
            $response = Http::put("{$this->baseUrl}/{$id}/enviar", ['enviado' => true]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al marcar proceso como enviado', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Search procesos de sanción by docente name
     *
     * @param string $nombre
     * @return array
     */
    public function searchByDocente($nombre)
    {
        try {
            $response = Http::get("{$this->baseUrl}/buscar", [
                'nombre' => $nombre
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al buscar procesos de sanción', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Filter procesos de sanción by tipo
     *
     * @param string $tipo
     * @return array
     */
    public function filterByTipo($tipo)
    {
        try {
            $response = Http::get("{$this->baseUrl}/filtrar/tipo", [
                'tipo_sancion' => $tipo
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al filtrar procesos de sanción por tipo', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Filter procesos de sanción by calificación range
     *
     * @param float $min
     * @param float $max
     * @return array
     */
    public function filterByCalificacion($min, $max)
    {
        try {
            $response = Http::get("{$this->baseUrl}/filtrar/calificacion", [
                'calificacion_min' => $min,
                'calificacion_max' => $max
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'message' => 'Error al filtrar procesos de sanción por calificación', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }
}