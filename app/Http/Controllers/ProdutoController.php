<?php

namespace App\Http\Controllers;

use App\Charts\EstoqueProdutoChart;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index()
    {
        $dados = Produto::all();

        return view('produtos.list', [
            'dados' => $dados,
        ]);
    }

    public function create()
    {
        return view('produtos.form');
    }

    // Validação única, usada tanto no store() quanto no update() (evita código repetido).
    public function validateForm(Request $request)
    {
        $request->validate(
            [
                'nome'     => 'required|max:130|min:3',
                'preco'    => 'required|numeric|min:0',
                'estoque'  => 'required|integer|min:0',
                'imagem'   => 'nullable|image|mimes:png,jpeg,jpg',
            ],
            [
                'nome.required'     => 'O campo nome é obrigatório.',
                'nome.max'          => 'O máximo de caracteres para o nome é 130.',
                'nome.min'          => 'O mínimo de caracteres para o nome é 3.',
                'preco.required'    => 'O campo preço é obrigatório.',
                'preco.numeric'     => 'O preço deve ser um valor numérico.',
                'preco.min'         => 'O preço não pode ser negativo.',
                'estoque.required'  => 'O campo estoque é obrigatório.',
                'estoque.integer'   => 'O estoque deve ser um valor inteiro.',
                'estoque.min'       => 'O estoque não pode ser negativo.',
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
            $diretorio = 'imagem/produto/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        Produto::create($data);

        return redirect('produto')->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Produto::findOrFail($id);

        return view('produtos.form', [
            'dado' => $dado,
        ]);
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $this->validateForm($request);

        $data = $request->all();

        $imagem = $request->file('imagem');
        if ($imagem) {
            // Troca de foto: apaga a antiga do disco para não deixar arquivo órfão.
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $nome_arquivo = date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/produto/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        $produto->update($data);

        return redirect('produto')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            Storage::disk('public')->delete($produto->imagem);
        }

        $produto->delete();

        return redirect('produto')->with('success', 'Registro removido com sucesso!');
    }

    // GRÁFICO 2 (barras): a classe EstoqueProdutoChart monta o gráfico e a view só o exibe.
    public function chart(EstoqueProdutoChart $chart)
    {
        return view('produtos.chart', ['chart' => $chart->build()]);
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Produto::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Produto::all();
        }

        return view('produtos.list', ['dados' => $dados]);
    }
}
