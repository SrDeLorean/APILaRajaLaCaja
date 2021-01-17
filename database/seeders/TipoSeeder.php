<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo::create([
            'nombre' => 'Caja Light',
            'precio' => 29990
        ]);
        Tipo::create([
            'nombre' => 'Caja Medium',
            'precio' => 39990
        ]);
        Tipo::create([
            'nombre' => 'Caja Premium',
            'precio' => 59990
        ]);
        Tipo::create([
            'nombre' => 'Edición Especial',
            'precio' => 12990
        ]);
    }
}
