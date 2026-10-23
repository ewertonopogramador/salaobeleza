<?php

namespace Database\Seeders;

use App\Models\Agendamento;
use Illuminate\Database\Seeder;

class AgendamentoSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder idempotente: não duplica agendamentos se já existirem.
        if (Agendamento::count() > 0) {
            return;
        }

        Agendamento::factory(15)->create();
    }
}
