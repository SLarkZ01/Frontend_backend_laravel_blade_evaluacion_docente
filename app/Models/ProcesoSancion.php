<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoSancion extends Model
{
    use HasFactory;
    
    protected $table = 'proceso_sancion';
    protected $primaryKey = 'id_sancion';
    public $timestamps = true;
    
    protected $fillable = [
        'numero_resolucion',
        'fecha_emision',
        'nombre_docente',
        'apellido_docente',
        'identificacion_docente',
        'asignatura',
        'calificacion_final',
        'tipo_sancion',
        'antecedentes',
        'fundamentos',
        'resolucion',
        'firma_path',
        'enviado'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_emision' => 'date',
        'calificacion_final' => 'decimal:2',
        'enviado' => 'boolean',
    ];
    
    /**
     * Get the docente associated with the sanction process.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'identificacion_docente', 'identificacion');
    }
}