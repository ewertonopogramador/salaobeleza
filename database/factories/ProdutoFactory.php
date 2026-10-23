<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    // Define como cada produto "falso" é gerado pelo Faker (usado pelo ProdutoSeeder).
    public function definition(): array
    {
        return [
            'nome'    => $this->faker->unique()->words(2, true),
            'preco'   => $this->faker->randomFloat(2, 5, 200),
            'estoque' => $this->faker->numberBetween(0, 100),
            'imagem'  => null,
        ];
    }
}
