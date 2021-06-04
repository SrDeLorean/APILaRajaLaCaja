<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(BrindiSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(PasatiempoSeeder::class);
        $this->call(PreferenciaSeeder::class);
        $this->call(TipoCajaSeeder::class);
        $this->call(MascotaSeeder::class);
        $this->call(TipoPersonaSeeder::class);
        $this->call(MotivoSeeder::class);
        $this->call(ProductoSeeder::class);
    }
}