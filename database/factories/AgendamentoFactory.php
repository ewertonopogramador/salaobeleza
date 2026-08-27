<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendamentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_cliente'          => Cliente::factory(),
            'id_servico'          => Servico::factory(),
            'data_agendamento'    => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'horario_agendamento' => $this->faker->time('H:i'),
        ];
    }
}
