<?php

namespace App\Charts;

use App\Models\Produto;
use ArielMejiaDev\LarapexCharts\LarapexChart;

// GRÁFICO 2 (barras): estoque disponível de cada produto.
class EstoqueProdutoChart
{
    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $produtos = Produto::orderBy('nome')->get();

        // pluck() extrai uma única coluna da coleção; all() converte em array simples.
        $nomes = $produtos->pluck('nome')->all();
        $estoques = $produtos->pluck('estoque')->all();

        return (new LarapexChart)->barChart()
            ->setTitle('Estoque de produtos')
            ->setSubtitle('Quantidade disponível de cada produto')
            ->addBar('Estoque', $estoques)
            ->setXAxis($nomes);
    }
}
