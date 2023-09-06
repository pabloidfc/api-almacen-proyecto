<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $estados = [
            "Creado",
            "En viaje",
            "Desarmado"
        ];

        return [
            "peso"       => $this -> faker -> randomFloat(),
            "estado"     => $this -> faker -> randomElement($estados),
            "created_at" => $this -> faker -> date("Y-m-d", "now"),
            "updated_at" => $this -> faker -> date("Y-m-d", "now")
        ];
    }
}
