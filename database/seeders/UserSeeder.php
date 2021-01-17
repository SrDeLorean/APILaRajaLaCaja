<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre' => 'Sebastian Ibarra',
            'email' => 'xebaelvemgador@gmail.com',
            'password' => bcrypt('Sterek64'),
        ]);

        User::create([
            'nombre' => 'Javier Ibarra',
            'email' => 'jibarra@proyectomapache.cl',
            'password' => bcrypt('Sterek64'),
        ]);
    }
}
