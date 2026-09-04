<?php

namespace App\Http\Controllers;

use App\Models\Servico;
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

    public function create()
    {
        return view('servicos.form');
    }

    public function store(Request $request)
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

        $data = $request->all();
        Servico::create($data);

        return redirect('servico');
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

        $data = $request->all();
        Servico::updateOrCreate(
            ['id' => $id],
            $data
        );

        return redirect('servico');
    }

    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();

        return redirect('servico');
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
