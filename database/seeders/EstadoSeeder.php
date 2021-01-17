<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::create([
            'nombre' => 'Ok'
        ]);
        Estado::create([
            'nombre' => 'Recibida'
        ]);
        Estado::create([
            'nombre' => 'Enviada'
        ]);
        Estado::create([
            'nombre' => 'Pendiente'
        ]);
        Estado::create([
            'nombre' => 'Pagada'
        ]);
        Estado::create([
            'nombre' => 'Anulada'
        ]);
        Estado::create([
            'nombre' => 'Otro'
        ]);
    }
}
