<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\User;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = User::create(['email' => 'patronelli87@gmail.com', 'password' => 'abcd1234']);
        $u->idPersona()->create(['nombre' => 'Mario', 'apellido' => 'Patronelli', 'mail' => 'mario@raffles.com.ar']);
        $u->roles()->attach([1,2,3,4,5]);

        $u = User::create(['email' => 'josue.aveiro@mavaite.com', 'password' => 'abcd1234']);
        $u->idPersona()->create(['nombre' => 'Josue', 'apellido' => 'Aveiro', 'mail' => 'josue.aveiro@mavaite.com']);
        $u->roles()->attach([1,2,3,4,5]);
    }
}
