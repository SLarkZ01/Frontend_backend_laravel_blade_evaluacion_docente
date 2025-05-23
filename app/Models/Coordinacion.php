<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinacion extends Model
{
    use HasFactory;
    
    protected $table = 'Coordinacion';
    protected $primaryKey = 'id_coordinacion';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre'
    ];
    
    /**
     * Get the facultades for the coordinacion.
     */
    public function facultades()
    {
        return $this->hasMany(Facultad::class, 'id_coordinacion', 'id_coordinacion');
    }
}