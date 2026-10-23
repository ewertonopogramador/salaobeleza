<?php

namespace Database\Seeders;

use App\Models\Profissional;
use Illuminate\Database\Seeder;

class ProfissionalSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder idempotente: não duplica profissionais se já existirem.
        if (Profissional::count() > 0) {
            return;
        }

        Profissional::factory(5)->create();
    }
}
