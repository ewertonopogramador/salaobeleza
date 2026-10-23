<?php

namespace App\Charts;

use App\Models\Servico;
use ArielMejiaDev\LarapexCharts\LarapexChart;

// GRÁFICO 1: quantidade de agendamentos por serviço.
class AgendamentoServicoChart
{
    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        // withCount('agendamentos') cria o campo agendamentos_count com o total
        // de agendamentos de cada serviço, usando o hasMany do Model Servico.
        $servicos = Servico::withCount('agendamentos')->get();

        $qtdAgendamentos = [];
        $nomeServicos = [];

        foreach ($servicos as $item) {
            $nomeServicos[] = $item->nome_servico;
            $qtdAgendamentos[] = $item->agendamentos_count;
        }

        return (new LarapexChart)->pieChart()
            ->setTitle('Agendamentos por serviço')
            ->setSubtitle('Total de agendamentos de cada serviço')
            ->addPieces($qtdAgendamentos)
            ->setLabels($nomeServicos);
    }
}
