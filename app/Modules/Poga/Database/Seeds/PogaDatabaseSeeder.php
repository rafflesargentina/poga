<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Illuminate\Database\Seeder;

class PogaDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FormatosTableSeeder::class);
        $this->call(GruposCaracteristicaTableSeeder::class);
        $this->call(MedidasTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ServiciosTableSeeder::class);
        $this->call(TiposInmuebleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
