<?php

namespace Database\Seeders;

use App\Models\Agendamento;
use Illuminate\Database\Seeder;

class AgendamentoSeeder extends Seeder
{
    public function run(): void
    {
        Agendamento::factory(15)->create();
    }
}
