<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Seeder;

class ServicoSeeder extends Seeder
{
    public function run(): void
    {
        // Lista fixa de serviços do salão (sem nomes repetidos, bom para a apresentação).
        $servicos = [
            ['nome_servico' => 'Corte de Cabelo', 'descricao' => 'Corte feminino ou masculino',        'preco' => 60.00],
            ['nome_servico' => 'Barba Completa',  'descricao' => 'Barba com toalha quente e acabamento', 'preco' => 40.00],
            ['nome_servico' => 'Coloração',       'descricao' => 'Coloração completa dos fios',          'preco' => 120.00],
            ['nome_servico' => 'Manicure',        'descricao' => 'Cuidado e esmaltação das unhas',       'preco' => 35.00],
            ['nome_servico' => 'Pedicure',        'descricao' => 'Cuidado e esmaltação dos pés',         'preco' => 40.00],
            ['nome_servico' => 'Hidratação',      'descricao' => 'Hidratação profunda dos cabelos',      'preco' => 80.00],
        ];

        foreach ($servicos as $servico) {
            // updateOrCreate procura pelo nome: se existir, atualiza; se não, cria.
            // É isso que impede duplicar o serviço quando o seeder roda de novo.
            Servico::updateOrCreate(
                ['nome_servico' => $servico['nome_servico']],
                $servico
            );
        }
    }
}
