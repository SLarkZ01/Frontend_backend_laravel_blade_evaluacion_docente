<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    
    protected $fillable = [
        'id_rol',
        'nombre',
        'correo',
        'contrasena',
        'activo'
    ];
    
    /**
     * Get the role that owns the user.
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }
}
