<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motivo;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Motivo::create([
            'nombre' => 'Cumpleaños'
        ]);
        Motivo::create([
            'nombre' => 'Bebé en camino'
        ]);
        Motivo::create([
            'nombre' => 'Bienvenid@ a la solteria'
        ]);
        Motivo::create([
            'nombre' => 'Día de la madre'
        ]);
        Motivo::create([
            'nombre' => 'Día del padre'
        ]);
        Motivo::create([
            'nombre' => 'Navidad'
        ]);
        Motivo::create([
            'nombre' => 'Otro'
        ]);
    }
}
