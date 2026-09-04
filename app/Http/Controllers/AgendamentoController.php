<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Servico;
use App\Models\Cliente;
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

    public function store(Request $request)
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

        $data = $request->all();
        Agendamento::create($data);

        return redirect('agendamento');
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

        $data = $request->all();
        Agendamento::updateOrCreate(
            ['id' => $id],
            $data
        );

        return redirect('agendamento');
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->delete();

        return redirect('agendamento');
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
