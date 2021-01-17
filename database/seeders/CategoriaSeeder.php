<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'Rockets'
        ]);
        Categoria::create([
            'nombre' => 'Carrete@'
        ]);
        Categoria::create([
            'nombre' => 'Trabajolic@'
        ]);
        Categoria::create([
            'nombre' => 'Romantic@'
        ]);
        Categoria::create([
            'nombre' => 'Pretencios@'
        ]);
        Categoria::create([
            'nombre' => 'Organizad@'
        ]);
        Categoria::create([
            'nombre' => 'Sexy'
        ]);
        Categoria::create([
            'nombre' => 'Otro'
        ]);
    }
}
