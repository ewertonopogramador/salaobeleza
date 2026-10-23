<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        // Lista fixa de produtos do salão (sem repetição, bom para a apresentação e para o gráfico).
        $produtos = [
            ['nome' => 'Shampoo Hidratante', 'preco' => 29.90, 'estoque' => 40],
            ['nome' => 'Condicionador',      'preco' => 27.90, 'estoque' => 35],
            ['nome' => 'Máscara Capilar',    'preco' => 49.90, 'estoque' => 20],
            ['nome' => 'Esmalte',            'preco' => 9.90,  'estoque' => 80],
            ['nome' => 'Óleo para Barba',    'preco' => 34.90, 'estoque' => 15],
            ['nome' => 'Secador de Cabelo',  'preco' => 189.90, 'estoque' => 5],
        ];

        foreach ($produtos as $produto) {
            // updateOrCreate pelo nome: evita duplicar quando o seeder roda de novo.
            Produto::updateOrCreate(['nome' => $produto['nome']], $produto);
        }
    }
}
