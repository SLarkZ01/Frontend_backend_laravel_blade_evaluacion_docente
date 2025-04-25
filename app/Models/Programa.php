<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;
    
    protected $table = 'Programas';
    protected $primaryKey = 'id_programa';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'id_facultad',
        'id_docente'
    ];
    
    /**
     * Get the facultad that owns the programa.
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad', 'id_facultad');
    }
    
    /**
     * Get the docente that owns the programa.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }
    
    /**
     * Get the estudiantes for the programa.
     */
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_programa', 'id_programa');
    }
    
    /**
     * Get the cursos for the programa.
     */
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_programa', 'id_programa');
    }
}