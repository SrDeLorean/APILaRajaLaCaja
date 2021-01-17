<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Preferencia;


class PreferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Preferencia::create([
            'nombre' => 'Chocolates'
        ]);
        Preferencia::create([
            'nombre' => 'Paletas o Dulces'
        ]);
        Preferencia::create([
            'nombre' => 'Salados'
        ]);
        Preferencia::create([
            'nombre' => 'Otro'
        ]);
    }
}
