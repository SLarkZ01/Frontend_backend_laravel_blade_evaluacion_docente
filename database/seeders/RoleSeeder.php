<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles básicos del sistema
        $roles = [
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso completo al sistema'
            ],
            [
                'nombre' => 'Docente',
                'descripcion' => 'Acceso a funciones de docente'
            ],
            [
                'nombre' => 'Estudiante',
                'descripcion' => 'Acceso a funciones de estudiante'
            ],
            [
                'nombre' => 'Decano',
                'descripcion' => 'Acceso a funciones de decano'
            ],
            [
                'nombre' => 'Coordinador',
                'descripcion' => 'Acceso a funciones de coordinador'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}