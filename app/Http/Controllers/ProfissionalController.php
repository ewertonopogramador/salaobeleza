<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfissionalController extends Controller
{
    // Validação única, usada no store() e no update() (mesmo padrão dos outros controllers).
    // $id é o profissional que está sendo editado (null quando é um cadastro novo).
    public function validateForm(Request $request, $id = null)
    {
        $request->validate([
            'nome'          => 'required|max:130|min:3',
            'especialidade' => 'required|string|max:130|min:3',
            'telefone'      => 'required|string|max:20',
            // RELACIONAMENTO 1:1 (User <-> Profissional):
            //  - nullable: o usuário é opcional (a coluna do banco aceita null)
            //  - exists:users,id: o usuário escolhido precisa existir na tabela users
            //    (evita o erro 500 de chave estrangeira)
            //  - unique:profissionais,user_id,$id: um usuário só pode estar ligado a
            //    UM profissional (é isso que torna a relação 1:1). O $id no final faz
            //    o Laravel ignorar o próprio registro na edição, senão ele
            //    "colidiria" consigo mesmo.
            'user_id'       => 'nullable|integer|exists:users,id|unique:profissionais,user_id,' . $id,
            'imagem'        => 'nullable|image|mimes:png,jpeg,jpg',
        ], [
            'nome.required'          => 'O campo nome é obrigatório.',
            'nome.max'               => 'O máximo de caracteres para o nome é 130.',
            'nome.min'               => 'O mínimo de caracteres para o nome é 3.',
            'especialidade.required' => 'O campo especialidade é obrigatório.',
            'especialidade.max'      => 'O máximo de caracteres para a especialidade é 130.',
            'especialidade.min'      => 'O mínimo de caracteres para a especialidade é 3.',
            'telefone.required'      => 'O campo telefone é obrigatório.',
            'telefone.max'           => 'O máximo de caracteres para o telefone é 20.',
            'user_id.integer'        => 'O usuário deve ser um valor inteiro.',
            'user_id.exists'         => 'O usuário selecionado não existe.',
            'user_id.unique'         => 'Este usuário já está vinculado a outro profissional.',
            'imagem.image'           => 'Deve ser enviado um arquivo de imagem válido.',
            'imagem.mimes'           => 'A imagem deve ser da extensão PNG, JPEG ou JPG.',
        ]);
    }

    private function salvarImagem(Request $request, array $data)
    {
        $imagem = $request->file('imagem');
        if ($imagem) {
            $nome_arquivo = date('YmdHis') . '_' . Str::random(6) . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/profissional/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        return $data;
    }

    public function index()
    {
        // with('user') faz o "eager loading": busca os usuários de todos os
        // profissionais em uma única consulta extra, em vez de uma consulta por
        // linha da tabela (problema conhecido como N+1). Assim a listagem
        // consegue mostrar o NOME do usuário em vez do ID.
        $dados = Profissional::with('user')->get();

        return view('profissional.list', [
            'dados' => $dados,
        ]);
    }

    public function create()
    {
        // Envia a lista de usuários para a view montar o <select>.
        // pluck('name', 'id') devolve [id => nome], ex.: [1 => 'Maria', 2 => 'João'].
        $usuarios = User::orderBy('name')->pluck('name', 'id');

        return view('profissional.form', [
            'usuarios' => $usuarios,
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        $data = $this->salvarImagem($request, $request->all());

        Profissional::create($data);

        return redirect('profissional')->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Profissional::findOrFail($id);

        // Mesma lista de usuários do create(), para o <select> da edição.
        $usuarios = User::orderBy('name')->pluck('name', 'id');

        return view('profissional.form', [
            'dado'     => $dado,
            'usuarios' => $usuarios,
        ]);
    }

    public function update(Request $request, $id)
    {
        $profissional = Profissional::findOrFail($id);

        // Passamos o $id para a regra unique ignorar o próprio profissional.
        $this->validateForm($request, $id);

        $data = $this->salvarImagem($request, $request->all());

        // Remove a foto antiga quando uma nova é enviada
        if ($request->hasFile('imagem') && $profissional->imagem
            && Storage::disk('public')->exists($profissional->imagem)) {
            Storage::disk('public')->delete($profissional->imagem);
        }

        $profissional->update($data);

        return redirect('profissional')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $profissional = Profissional::findOrFail($id);

        if ($profissional->imagem && Storage::disk('public')->exists($profissional->imagem)) {
            Storage::disk('public')->delete($profissional->imagem);
        }

        $profissional->delete();

        return redirect('profissional')->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:nome,especialidade,telefone',
        ]);

        if (!empty($request->valor)) {
            $dados = Profissional::with('user')->where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Profissional::with('user')->get();
        }

        return view('profissional.list', ['dados' => $dados]);
    }
}
