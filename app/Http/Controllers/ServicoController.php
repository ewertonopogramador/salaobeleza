<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index()
    {
        $dados = Servico::all();

        return view('servicos.list', [
            'dados' => $dados,
        ]);
    }

    // RELATÓRIO 2 (PDF): serviços e, dentro de cada um, seus agendamentos (1:N).
    public function report()
    {
        // with('agendamentos.cliente') carrega os agendamentos de cada serviço
        // e, dentro deles, o cliente — tudo em poucas consultas.
        $servicos = Servico::with('agendamentos.cliente')->orderBy('nome_servico')->get();

        $data = [
            'titulo' => 'Relatório de Serviços e Agendamentos',
            'dados'  => $servicos,
        ];

        $pdf = Pdf::loadView('servicos.report', $data);

        // download() força o download do arquivo (stream() abriria no navegador).
        return $pdf->download('relatorio_servicos_agendamentos.pdf');
    }

    public function create()
    {
        return view('servicos.form');
    }

    // Validação única, usada tanto no store() quanto no update() (evita código repetido).
    public function validateForm(Request $request)
    {
        $request->validate(
            [
                'nome_servico' => 'required|max:100|min:3',
                'descricao'    => 'nullable|max:255',
                'preco'        => 'required|numeric|min:0',
            ],
            [
                'nome_servico.required' => 'O nome do serviço é obrigatório.',
                'nome_servico.max'      => 'O nome do serviço pode ter no máximo 100 caracteres.',
                'nome_servico.min'      => 'O nome do serviço deve ter no mínimo 3 caracteres.',
                'descricao.max'         => 'A descrição pode ter no máximo 255 caracteres.',
                'preco.required'        => 'O preço do serviço é obrigatório.',
                'preco.numeric'         => 'O preço deve ser um valor numérico válido.',
                'preco.min'             => 'O preço não pode ser um valor negativo.',
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Servico::create($request->all());

        return redirect('servico')->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Servico::findOrFail($id);

        return view('servicos.form', [
            'dado' => $dado,
        ]);
    }

    public function update(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);

        $this->validateForm($request);

        $servico->update($request->all());

        return redirect('servico')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);

        // Não permite remover serviço que já tem agendamentos (evita apagar dados em cascata).
        if ($servico->agendamentos()->count() > 0) {
            return redirect('servico')->with(
                'error',
                "Não é possível remover o serviço {$servico->nome_servico}, pois existem agendamentos associados a ele!"
            );
        }

        $servico->delete();

        return redirect('servico')->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Servico::where('nome_servico', 'like', '%' . $request->valor . '%')->get();
        } else {
            $dados = Servico::all();
        }

        return view('servicos.list', ['dados' => $dados]);
    }
}
