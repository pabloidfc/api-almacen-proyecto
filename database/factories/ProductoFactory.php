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
        $estados = [
            "En espera",
            "Almacenado",
            "Loteado",
            "Desloteado",
            "En viaje",
            "Entregado"
        ];

        return [
            "peso"              => $this -> faker -> randomFloat(),
            "estado"            => $this -> faker -> randomElement($estados),
            "fecha_entrega"     => $this -> faker -> date("Y-m-d", "now"),
            "direccion_entrega" => $this -> faker -> address(),
            "created_at"        => $this -> faker -> date("Y-m-d", "now"),
            "updated_at"        => $this -> faker -> date("Y-m-d", "now")
        ];
    }
}
