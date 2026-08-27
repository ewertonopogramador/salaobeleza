<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServicoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_servico' => $this->faker->randomElement([
                'Corte de Cabelo', 
                'Barba Completa', 
                'Coloração', 
                'Manicure', 
                'Pedicure', 
                'Hidratação'
            ]),
            'descricao' => $this->faker->sentence(6),
            'preco'     => $this->faker->randomFloat(2, 20, 150),
        ];
    }
}