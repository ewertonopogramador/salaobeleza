<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder idempotente: se já existem clientes, não cria de novo.
        // Assim "php artisan migrate --seed" pode ser rodado várias vezes sem duplicar dados.
        if (Cliente::count() > 0) {
            return;
        }

        Cliente::factory(10)->create();
    }
}
