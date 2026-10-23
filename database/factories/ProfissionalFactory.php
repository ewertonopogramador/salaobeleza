<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfissionalFactory extends Factory
{
    // Define como cada profissional "falso" é gerado pelo Faker (usado pelo ProfissionalSeeder).
    // user_id fica nulo: a coluna é unique, então o vínculo com usuário é feito pelo formulário.
    public function definition(): array
    {
        return [
            'nome'          => $this->faker->name(),
            'especialidade' => $this->faker->randomElement(['Cabeleireiro', 'Manicure', 'Esteticista', 'Barbeiro', 'Maquiador']),
            'telefone'      => $this->faker->numerify('(##) 9####-####'),
            'imagem'        => null,
            'user_id'       => null,
        ];
    }
}
