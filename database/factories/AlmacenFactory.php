<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlmacenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tipos = [
            "Propio",
            "De terceros"
        ];

        return [
            "nombre"     => $this -> faker -> firstName(),
            "tipo"       => $this -> faker -> randomElement($tipos),
            "created_at" => $this -> faker -> date("Y-m-d", "now"),
            "updated_at" => $this -> faker -> date("Y-m-d", "now")
        ];
    }
}
