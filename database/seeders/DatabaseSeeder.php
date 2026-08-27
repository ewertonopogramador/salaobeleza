<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Agendamento;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cria 10 clientes fictícios
        Cliente::factory(10)->create();

        // Cria 5 serviços fictícios
        Servico::factory(5)->create();

        // Cria 15 agendamentos usando os clientes e serviços criados
        Agendamento::factory(15)->create();
    }
}
