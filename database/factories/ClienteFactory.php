<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome'     => $this->faker->name(),
            'cpf'      => $this->faker->unique()->numerify('###.###.###-##'),
            'telefone' => $this->faker->numerify('(##) 9####-####'),
            'endereco' => $this->faker->streetAddress(),
            'email'    => $this->faker->unique()->safeEmail(),
            'imagem'   => null,
        ];
    }
}
