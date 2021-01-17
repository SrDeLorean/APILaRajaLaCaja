<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasatiempo;

class PasatiempoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pasatiempo::create([
            'nombre' => 'Cocinar'
        ]);
        Pasatiempo::create([
            'nombre' => 'Parrilla'
        ]);
        Pasatiempo::create([
            'nombre' => 'Practicar Yoga'
        ]);
        Pasatiempo::create([
            'nombre' => 'Lectura'
        ]);
        Pasatiempo::create([
            'nombre' => 'Tejer o Bordar'
        ]);
        Pasatiempo::create([
            'nombre' => 'Maquillaje'
        ]);
        Pasatiempo::create([
            'nombre' => 'Otro'
        ]);
    }
}
