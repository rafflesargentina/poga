<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\User;

use Caffeinated\Shinobi\Models\{ Permission, Role };
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'Nominar Administrador', 'slug' => 'nominar_administrador'], // 1
            ['name' => 'Ver distribución de epensas', 'slug' => 'ver_distribucion_expensas'], // 
            ['name' => 'Crear Visita', 'slug' => 'crear_visita'], // 3
            ['name' => 'Crear Propietario', 'slug' => 'crear_propietario'], // 4
            ['name' => 'Ver Inmuebles disponibles para administrador', 'slug' => 'ver_inmuebles_disponibles_administrar'], // 5
            ['name' => 'Ver Finanzas de Inmueble', 'slug' => 'ver_finanzas_inmueble'], // 6
            ['name' => 'Ver Mis Inmuebles', 'slug' => 'ver_mis_inmuebles'], // 7
            ['name' => 'Crear Reserva', 'slug' => 'crear_reserva'], // 8
            ['name' => 'Crear Inquilino', 'slug' => 'crear_inquilino'], // 9
            ['name' => 'Crear Mantenimiento', 'slug' => 'crear_mantenimiento'], // 10
            ['name' => 'Ver Inmuebles con nominación', 'slug' => 'ver_inmuebles_con_nominacion'], // 11
            ['name' => 'Concluir Soliciud', 'slug' => 'concluir_solicitud'], // 12
            ['name' => 'Ver Mantenimientos', 'slug' => 'ver_mantenmientos'], // 13
            ['name' => 'Responder Solicitud', 'slug' => 'responder_solicitud'], // 14
            ['name' => 'Ver Nominaciones', 'slug' => 'ver_nominaciones'], // 15
            ['name' => 'Gestionar Proveedores', 'slug' => 'gestionar_proveedores'], // 16
            ['name' => 'Crear Unidad', 'slug' => 'crear_unidad'], // 17
            ['name' => 'Ver Todos los Inmuebles', 'slug' => 'ver_todos_inmuebles'], // 18
            ['name' => 'Ver Pagos', 'slug' => 'ver_pagos'], // 19
            ['name' => 'Crear Conserje', 'slug' => 'crear_conserje'], // 20
            ['name' => 'Crear Inmueble', 'slug' => 'crear_inmueble'], // 21
            ['name' => 'Crear Pago', 'slug' => 'crear_pago'], // 22
            ['name' => 'Crear Renta', 'slug' => 'crear_renta'], // 23
            ['name' => 'Crear Administrador', 'slug' => 'crear_administrador'], // 24
            ['name' => 'Establecer fecha respuesta solicitud', 'slug' => 'establecer_fecha_respuesta_solicitud'], // 25
            ['name' => 'Crear Solicitud', 'slug' => 'crear_solicitud'], // 26
            ['name' => 'Distribuir Expensas', 'slug' => 'distribuir_expensas'], // 27
            ['name' => 'Anular Pagos', 'slug' => 'anular_pagos'], // 28
            ['name' => 'Pasar Pagos a pendientes', 'slug' => 'pasar_pagos_a_pendientes'], // 29
            ['name' => 'Ver Rentas', 'slug' => 'ver_rentas'], // 30
            ['name' => 'Crear Nominación', 'slug' => 'crear_nominacion'], // 31
            ['name' => 'Rechazar Solicitud', 'slug' => 'rechazar_solicitud'], // 32
            ['name' => 'Ver Mis Sericios', 'slug' => 'ver_mis_servicios'], // 33
            ['name' => 'Ver Mi Agenda de Mantenimientos', 'slug' => 'ver_mi_agenda_mantenimientos'], // 34
            ['name' => 'Ver Mi Agenda de Solicitudes', 'slug' => 'ver_mi_agenda_solicitudes'] // 35
        ];

        foreach ($permissions as $permission) Permission::create($permission);

        $role = Role::where('slug', 'administrador')->first();
        $role->permissions()->attach([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30]);

        //$role = Role::where('slug', 'conserje')->first();
        //$role->permissions()->attach([13,11,7,3,8]);

        //$role = Role::where('slug', 'inquilino')->first();
        //$role->permissions()->attach([11,30,26,8,7,19,3,9]);

        //$role = Role::where('slug', 'propietario')->first();
        //$role->permissions()->attach([6,7,17,1,19,15,30,21,31,18,11]);

        //$role = Role::where('slug', 'proveedor')->first();
        //$role->permissions()->attach([32,33,34,25,35]);
    }
}
