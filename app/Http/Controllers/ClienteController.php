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

    // Validação única, usada tanto no store() quanto no update() (evita código repetido).
    public function validateForm(Request $request)
    {
        $request->validate(
            [
                'nome'     => 'required|max:130|min:3',
                'cpf'      => 'required|max:14',
                'telefone' => 'required|max:20',
                'endereco' => 'required|max:255',
                'email'    => 'required|email|max:150',
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
                'endereco.required' => 'O endereço é obrigatório.',
                'endereco.max'      => 'O máximo de caracteres para o endereço é 255.',
                'email.required'    => 'O e-mail é obrigatório.',
                'email.email'       => 'Informe um e-mail válido.',
                'email.max'         => 'O máximo de caracteres para o e-mail é 150.',
                'imagem.image'      => 'Deve ser enviado um arquivo de imagem válido.',
                'imagem.mimes'      => 'A imagem deve ser da extensão PNG, JPEG ou JPG.',
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        $data = $request->all();

        $imagem = $request->file('imagem');
        if ($imagem) {
            $nome_arquivo = date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/cliente/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Cliente::create($data);

        return redirect('cliente')->with('success', 'Registro salvo com sucesso!');
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
        $cliente = Cliente::findOrFail($id);

        $this->validateForm($request);

        $data = $request->all();

        $imagem = $request->file('imagem');
        if ($imagem) {
            // Troca de foto: apaga a antiga do disco para não deixar arquivo órfão.
            if ($cliente->imagem && Storage::disk('public')->exists($cliente->imagem)) {
                Storage::disk('public')->delete($cliente->imagem);
            }

            $nome_arquivo = date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/cliente/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        $cliente->update($data);

        return redirect('cliente')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Não permite remover cliente que já tem agendamentos (evita apagar dados em cascata).
        if ($cliente->agendamentos()->count() > 0) {
            return redirect('cliente')->with(
                'error',
                "Não é possível remover o cliente {$cliente->nome}, pois existem agendamentos associados a ele!"
            );
        }

        if ($cliente->imagem && Storage::disk('public')->exists($cliente->imagem)) {
            Storage::disk('public')->delete($cliente->imagem);
        }

        $cliente->delete();

        return redirect('cliente')->with('success', 'Registro removido com sucesso!');
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
