<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    
    protected $table = 'Estudiantes';
    protected $primaryKey = 'id_estudiante';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'correo',
        'semestre',
        'id_programa'
    ];
    
    /**
     * Get the programa that owns the estudiante.
     */
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa', 'id_programa');
    }
}