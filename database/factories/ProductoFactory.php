<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "id",
            "peso",
            "estado",
            "fecha_entrega",
            "almacen_destino",
            "created_at",
            "updated_at",
            "deleted_at"
        ];
    }
}
