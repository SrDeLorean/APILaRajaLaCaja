<?php

namespace Database\Seeders;
use App\Models\Mascota;

use Illuminate\Database\Seeder;

class MascotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mascota::create([
            'nombre' => 'Gatos'
        ]);
        Mascota::create([
            'nombre' => 'Perros'
        ]);
        Mascota::create([
            'nombre' => 'Otros'
        ]);
        Mascota::create([
            'nombre' => 'No'
        ]);
    }
}
