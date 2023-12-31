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
        // \App\Models\User::factory(10)->create();
        \App\Models\Producto::factory(1)->create([
            "id" => 1
        ]);

        \App\Models\Lote::factory(1)->create([
            "id" => 1
        ]);

        \App\Models\Almacen::factory(1)->create([
            "id" => 1
        ]);
    }
}
