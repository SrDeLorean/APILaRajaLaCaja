<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brindi;

class BrindiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brindi::create([
            'nombre' => 'Vino'
        ]);
        Brindi::create([
            'nombre' => 'Espumante'
        ]);
        Brindi::create([
            'nombre' => 'Sangria'
        ]);
        Brindi::create([
            'nombre' => 'Cerveza'
        ]);
        Brindi::create([
            'nombre' => 'No'
        ]);
    }
}
