<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoCaja;

class TipoCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCaja::create([
            'nombre' => 'Caja Light',
            'precio' => 29990
        ]);
        TipoCaja::create([
            'nombre' => 'Caja Medium',
            'precio' => 39990
        ]);
        TipoCaja::create([
            'nombre' => 'Caja Premium',
            'precio' => 59990
        ]);
        TipoCaja::create([
            'nombre' => 'Edición Especial',
            'precio' => 12990
        ]);
    }
}
