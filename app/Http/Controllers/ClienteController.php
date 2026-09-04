<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function index()
    {
        $dados = Cliente::all();

        return view('clientes.list', [
            'dados' => $dados,
        ]);
    }

    public function create()
    {
        return view('clientes.form');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nome'     => 'required|max:130|min:3',
                'cpf'      => 'required|max:14',
                'telefone' => 'required|max:20',
                'imagem'   => 'nullable|image|mimes:png,jpeg,jpg',
            ],
            [
                'nome.required'     => 'O campo nome é obrigatório.',
                'nome.max'          => 'O máximo de caracteres para o nome é 130.',
                'nome.min'          => 'O mínimo de caracteres para o nome é 3.',
                'cpf.required'      => 'O CPF é obrigatório.',
                'cpf.max'           => 'O máximo de caracteres para o CPF é 14.',
                'telefone.required' => 'O telefone é obrigatório.',
                'telefone.max'      => 'O máximo de caracteres para o telefone é 20.',
                'imagem.image'      => 'Deve ser enviado um arquivo de imagem válido.',
                'imagem.mimes'      => 'A imagem deve ser da extensão PNG, JPEG ou JPG.',
            ]
        );

        $data = $request->all();

        $imagem = $request->file('imagem');
        if ($imagem) {
            $nome_arquivo = date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/cliente/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Cliente::create($data);

        return redirect('cliente');
    }

    public function edit($id)
    {
        $dado = Cliente::findOrFail($id);

        return view('clientes.form', [
            'dado' => $dado,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nome'     => 'required|max:130|min:3',
                'cpf'      => 'required|max:14',
                'telefone' => 'required|max:20',
                'imagem'   => 'nullable|image|mimes:png,jpeg,jpg',
            ],
            [
                'nome.required'     => 'O campo nome é obrigatório.',
                'nome.max'          => 'O máximo de caracteres para o nome é 130.',
                'nome.min'          => 'O mínimo de caracteres para o nome é 3.',
                'cpf.required'      => 'O CPF é obrigatório.',
                'cpf.max'           => 'O máximo de caracteres para o CPF é 14.',
                'telefone.required' => 'O telefone é obrigatório.',
                'telefone.max'      => 'O máximo de caracteres para o telefone é 20.',
                'imagem.image'      => 'Deve ser enviado um arquivo de imagem válido.',
                'imagem.mimes'      => 'A imagem deve ser da extensão PNG, JPEG ou JPG.',
            ]
        );

        $data = $request->all();

        $imagem = $request->file('imagem');
        if ($imagem) {
            $nome_arquivo = date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/cliente/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Cliente::updateOrCreate(
            ['id' => $id],
            $data
        );

        return redirect('cliente');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        if ($cliente->imagem && Storage::disk('public')->exists($cliente->imagem)) {
            Storage::disk('public')->delete($cliente->imagem);
        }

        $cliente->delete();

        return redirect('cliente');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Cliente::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Cliente::all();
        }

        return view('clientes.list', ['dados' => $dados]);
    }
}
