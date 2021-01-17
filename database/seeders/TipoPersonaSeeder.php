<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoPersona;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPersona::create([
            'nombre' => 'Mujer'
        ]);
        TipoPersona::create([
            'nombre' => 'Hombre'
        ]);
        TipoPersona::create([
            'nombre' => 'Niño'
        ]);
        TipoPersona::create([
            'nombre' => 'Niña'
        ]);
        TipoPersona::create([
            'nombre' => 'Otro'
        ]);
    }
}
