<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_rol';

    /**
     * Indica si los timestamps del modelo deben ser utilizados.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_rol',
        'descripcion'
    ];

    /**
     * Obtener los usuarios que tienen este rol.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol', 'id_rol');
    }
}