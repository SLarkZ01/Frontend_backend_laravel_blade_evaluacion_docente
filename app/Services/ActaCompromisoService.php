<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class ActaCompromisoService
{
    protected $baseUrl;

    public function __construct()
    {
        // Fix: Use the correct URL format without prepending app.url
        // The API is on the same host, so we just need the relative path
        $this->baseUrl = '/api/actas-compromiso';
    }

    /**
     * Get all actas de compromiso
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
            
            return ['success' => false, 'message' => 'Error al obtener actas de compromiso', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Get acta de compromiso by ID
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
            
            return ['success' => false, 'message' => 'Acta de compromiso no encontrada', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Create a new acta de compromiso
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
            
            return ['success' => false, 'message' => 'Error al crear acta de compromiso', 'error' => $response->json()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Update an existing acta de compromiso
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
            
            return ['success' => false, 'message' => 'Error al actualizar acta de compromiso', 'error' => $response->json()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete an acta de compromiso
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
            
            return ['success' => false, 'message' => 'Error al eliminar acta de compromiso', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }

    /**
     * Mark an acta de compromiso as sent
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
            
            return ['success' => false, 'message' => 'Error al marcar acta como enviada', 'error' => $response->body()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio', 'error' => $e->getMessage()];
        }
    }
}