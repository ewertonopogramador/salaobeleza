<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfissionalController extends Controller
{
    private function regras()
    {
        return [
            'nome'          => 'required|max:130|min:3',
            'especialidade' => 'required|string|max:130|min:3',
            'telefone'      => 'required|string|max:20',
            'user_id'       => 'required|integer|min:0',
            'imagem'        => 'nullable|image|mimes:png,jpeg,jpg',
        ];
    }

    private function mensagens()
    {
        return [
            'nome.required'          => 'O campo nome é obrigatório.',
            'nome.max'               => 'O máximo de caracteres para o nome é 130.',
            'nome.min'               => 'O mínimo de caracteres para o nome é 3.',
            'especialidade.required' => 'O campo especialidade é obrigatório.',
            'especialidade.max'      => 'O máximo de caracteres para a especialidade é 130.',
            'especialidade.min'      => 'O mínimo de caracteres para a especialidade é 3.',
            'telefone.required'      => 'O campo telefone é obrigatório.',
            'telefone.max'           => 'O máximo de caracteres para o telefone é 20.',
            'user_id.required'       => 'O campo usuário é obrigatório.',
            'user_id.integer'        => 'O usuário deve ser um valor inteiro.',
            'user_id.min'            => 'O usuário não pode ser negativo.',
            'imagem.image'           => 'Deve ser enviado um arquivo de imagem válido.',
            'imagem.mimes'           => 'A imagem deve ser da extensão PNG, JPEG ou JPG.',
        ];
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
        $dados = Profissional::all();

        return view('profissional.list', [
            'dados' => $dados,
        ]);
    }

    public function create()
    {
        return view('profissional.form');
    }

    public function store(Request $request)
    {
        $request->validate($this->regras(), $this->mensagens());

        $data = $this->salvarImagem($request, $request->all());

        Profissional::create($data);

        return redirect('profissional');
    }

    public function edit($id)
    {
        $dado = Profissional::findOrFail($id);

        return view('profissional.form', [
            'dado' => $dado,
        ]);
    }

    public function update(Request $request, $id)
    {
        $profissional = Profissional::findOrFail($id);

        $request->validate($this->regras(), $this->mensagens());

        $data = $this->salvarImagem($request, $request->all());

        // Remove a foto antiga quando uma nova é enviada
        if ($request->hasFile('imagem') && $profissional->imagem
            && Storage::disk('public')->exists($profissional->imagem)) {
            Storage::disk('public')->delete($profissional->imagem);
        }

        $profissional->update($data);

        return redirect('profissional');
    }

    public function destroy($id)
    {
        $profissional = Profissional::findOrFail($id);

        if ($profissional->imagem && Storage::disk('public')->exists($profissional->imagem)) {
            Storage::disk('public')->delete($profissional->imagem);
        }

        $profissional->delete();

        return redirect('profissional');
    }

    public function search(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:nome,especialidade,telefone',
        ]);

        if (!empty($request->valor)) {
            $dados = Profissional::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Profissional::all();
        }

        return view('profissional.list', ['dados' => $dados]);
    }
}
