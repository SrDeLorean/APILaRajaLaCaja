<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'nombre' => 'Armado',
            'cantidad' => '0',
            'precioCompra' => '0',
            'precioVenta' => '2500',
            'foto' => null
        ]);
        Producto::create([
            'nombre' => 'Armado SPORT',
            'cantidad' => '0',
            'precioCompra' => '0',
            'precioVenta' => '1000',
            'foto' => null
        ]);
        Producto::create([
            'nombre' => 'Caja de carton con FUA',
            'cantidad' => '0',
            'precioCompra' => '0',
            'precioVenta' => '928',
            'foto' => null
        ]);
        Producto::create([
            'nombre' => 'Caja de carton sin FUA',
            'cantidad' => '0',
            'precioCompra' => '0',
            'precioVenta' => '780',
            'foto' => null
        ]);
        Producto::create([
            'nombre' => 'Tarjeta',
            'cantidad' => '0',
            'precioCompra' => '0',
            'precioVenta' => '200',
            'foto' => null
        ]);
        Producto::create([
            'nombre' => 'Sticker',
            'cantidad' => '0',
            'precioCompra' => '0',
            'precioVenta' => '80',
            'foto' => null
        ]);
    }
}
