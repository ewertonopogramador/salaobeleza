<?php

namespace App\Http\Controllers;

use App\Charts\AgendamentoServicoChart;
use App\Models\Agendamento;
use App\Models\Servico;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index()
    {
        $dados = Agendamento::with(['servico', 'cliente'])->get();

        return view('agendamento.list', [
            'dados' => $dados,
        ]);
    }

    public function create()
    {
        $servicos = Servico::all();
        $clientes = Cliente::all();

        return view('agendamento.form', [
            'servicos' => $servicos,
            'clientes' => $clientes,
        ]);
    }

    // Validação única, usada tanto no store() quanto no update() (evita código repetido).
    public function validateForm(Request $request)
    {
        $request->validate(
            [
                'data_agendamento'    => 'required|date',
                'horario_agendamento' => 'required',
                'id_servico'          => 'required|exists:servicos,id',
                'id_cliente'          => 'required|exists:clientes,id',
            ],
            [
                'data_agendamento.required'    => 'A data do agendamento é obrigatória.',
                'data_agendamento.date'        => 'Informe uma data válida.',
                'horario_agendamento.required' => 'O horário do agendamento é obrigatório.',
                'id_servico.required'          => 'O serviço é obrigatório.',
                'id_servico.exists'            => 'O serviço selecionado é inválido.',
                'id_cliente.required'          => 'O cliente é obrigatório.',
                'id_cliente.exists'            => 'O cliente selecionado é inválido.',
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Agendamento::create($request->all());

        return redirect('agendamento')->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Agendamento::findOrFail($id);
        $servicos = Servico::all();
        $clientes = Cliente::all();

        return view('agendamento.form', [
            'dado'     => $dado,
            'servicos' => $servicos,
            'clientes' => $clientes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);

        $this->validateForm($request);

        $agendamento->update($request->all());

        return redirect('agendamento')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->delete();

        return redirect('agendamento')->with('success', 'Registro removido com sucesso!');
    }

    // RELATÓRIO 1 (PDF): lista de todos os agendamentos com cliente e serviço.
    public function report()
    {
        // with() carrega cliente e serviço junto, evitando uma consulta por linha.
        $agendamentos = Agendamento::with(['servico', 'cliente'])
            ->orderBy('data_agendamento')
            ->orderBy('horario_agendamento')
            ->get();

        $data = [
            'titulo' => 'Relatório de Agendamentos',
            'dados'  => $agendamentos,
        ];

        // loadView() transforma a view Blade em PDF; o 2º parâmetro são as variáveis da view.
        $pdf = Pdf::loadView('agendamento.report', $data);

        // download() força o download do arquivo (stream() abriria no navegador).
        return $pdf->download('relatorio_agendamentos.pdf');
    }

    // GRÁFICO 1 (pizza): a classe AgendamentoServicoChart monta o gráfico e a view só o exibe.
    // O Laravel injeta a classe automaticamente pelo parâmetro (injeção de dependência).
    public function chart(AgendamentoServicoChart $chart)
    {
        return view('agendamento.chart', ['chart' => $chart->build()]);
    }

    public function search(Request $request)
    {
        $query = Agendamento::with(['servico', 'cliente']);

        if ($request->filled('data_agendamento')) {
            $query->whereDate('data_agendamento', $request->data_agendamento);
        }

        if ($request->filled('nome_cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->nome_cliente . '%');
            });
        }

        $dados = $query->get();

        return view('agendamento.list', ['dados' => $dados]);
    }
}
