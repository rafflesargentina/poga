<?php

namespace Raffles\Modules\Poga\Database\Seeds;

use Raffles\Modules\Poga\Models\{ Persona, User };

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
        $persona = Persona::create(['nombre' => 'Mario', 'apellido' => 'Patronelli', 'mail' => 'mario@raffles.com.ar']);
        $u = User::create(['email' => 'patronelli87@gmail.com', 'password' => 'abcd1234', 'id_persona' => $persona->id]);
        $u->roles()->attach([1,2,3,4,5]);

        $persona = Persona::create(['nombre' => 'Josue', 'apellido' => 'Aveiro', 'mail' => 'josue.aveiro@mavaite.com']);
        $u = User::create(['email' => 'josue.aveiro@mavaite.com', 'password' => 'abcd1234', 'id_persona' => $persona->id]);
        $u->roles()->attach([1,2,3,4,5]);
    }
}
