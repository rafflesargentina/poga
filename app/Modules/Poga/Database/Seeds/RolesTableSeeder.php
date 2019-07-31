<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Caffeinated\Shinobi\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Administrador', 'slug' => 'administrador'],
            ['name' => 'Conserje', 'slug' => 'conserje'],
            ['name' => 'Inquilino', 'slug' => 'inquilino'],
            ['name' => 'Propietario', 'slug' => 'propietario'],
            ['name' => 'Proveedor', 'slug' => 'proveedor']
        ];

        foreach ($roles as $role) { Role::create($role);
        }
    }
}
