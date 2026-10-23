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
            // inRandomOrder()->first() sorteia um cliente/serviço que JÁ EXISTE.
            // (Antes usava Cliente::factory(), que criava um cliente novo a cada agendamento
            // e fazia as tabelas crescerem sem parar.) Por isso o AgendamentoSeeder precisa
            // rodar depois do ClienteSeeder e do ServicoSeeder.
            'id_cliente'          => Cliente::inRandomOrder()->value('id'),
            'id_servico'          => Servico::inRandomOrder()->value('id'),
            'data_agendamento'    => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'horario_agendamento' => $this->faker->time('H:i'),
        ];
    }
}
