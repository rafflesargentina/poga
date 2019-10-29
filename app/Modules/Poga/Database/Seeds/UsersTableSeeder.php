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
        $u = User::create(['email' => 'mario@raffles.com.ar', 'password' => 'abcd1234', 'id_persona' => $persona->id]);
        $u->roles()->attach([1,2,3,4,5]);

        $persona = Persona::create(['nombre' => 'Josue', 'apellido' => 'Aveiro', 'mail' => 'josue.aveiro@mavaite.com']);
        $u = User::create(['email' => 'josue.aveiro@mavaite.com', 'password' => 'abcd1234', 'id_persona' => $persona->id]);
	$u->roles()->attach([1,2,3,4,5]);

	$persona = Persona::create(['nombre' => 'Juan', 'apellido' => 'Píriz', 'mail' => 'juanpiriz90@gmail.com']);
	$u = User::create(['email' => 'juanpiriz90@gmail.com', 'password' => 'abcd1234', 'id_persona' => $persona->id]);

        $persona = Persona::create(['nombre' => 'Lorena', 'apellido' => 'Callejas', 'mail' => 'lorena-callejas@hotmail.com']);
        $u = User::create(['email' => 'lorena-callejas@hotmail.com', 'password' => 'abcd1234', 'id_persona' => $persona->id]);
    }
}
