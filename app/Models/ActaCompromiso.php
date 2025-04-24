<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActaCompromiso extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'acta_compromiso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero_acta',
        'fecha_generacion',
        'nombre_docente',
        'apellido_docente',
        'identificacion_docente',
        'asignatura',
        'calificacion_final',
        'retroalimentacion',
        'firma_path',
        'enviado'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_generacion' => 'date',
        'calificacion_final' => 'decimal:2',
        'enviado' => 'boolean',
    ];
}