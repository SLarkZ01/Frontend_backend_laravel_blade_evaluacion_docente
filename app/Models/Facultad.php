<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;
    
    protected $table = 'Facultad';
    protected $primaryKey = 'id_facultad';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'id_coordinacion'
    ];
    
    /**
     * Get the coordinacion that owns the facultad.
     */
    public function coordinacion()
    {
        return $this->belongsTo(Coordinacion::class, 'id_coordinacion', 'id_coordinacion');
    }
    
    /**
     * Get the programas for the facultad.
     */
    public function programas()
    {
        return $this->hasMany(Programa::class, 'id_facultad', 'id_facultad');
    }
}