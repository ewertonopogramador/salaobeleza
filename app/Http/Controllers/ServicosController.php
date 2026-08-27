<?php

namespace App\Http\Controllers;

// Importação da Model de Serviço e das classes nativas do Laravel
use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    /**
     * Exibe a listagem de todos os serviços cadastrados no salão.
     */
    public function index()
    {
        // Recupera todos os registros da tabela 'servicos'
        $dados = Servico::all();

        // Retorna a view 'servico.list' enviando a variável $dados
        return view('servico.list', [
            'dados' => $dados
        ]);
    }

    /**
     * Exibe o formulário de cadastro para um novo serviço.
     */
    public function create()
    {
        // Retorna a view 'servico.form' compartilhada (para criação)
        return view('servico.form');
    }

    /**
     * Armazena um novo serviço no banco de dados após a validação.
     */
    public function store(Request $request)
    {
        // Validação dos dados digitados no formulário
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

        // Obtém todos os dados validados do formulário
        $data = $request->all();

        // Cria o novo serviço no banco de dados via Eloquent
        Servico::create($data);

        // Redireciona para a página de listagem de serviços
        return redirect('servico');
    }

    /**
     * Exibe o formulário de edição com os dados do serviço selecionado.
     */
    public function edit($id)
    {
        // Localiza o serviço pelo ID ou retorna um erro 404
        $dado = Servico::findOrFail($id);

        // Retorna a mesma view 'servico.form' enviando os dados para preenchimento
        return view('servico.form', [
            'dado' => $dado
        ]);
    }

    /**
     * Atualiza os dados de um serviço existente no banco de dados.
     */
    public function update(Request $request, $id)
    {
        // Aplica as regras e mensagens de validação
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

        // Atualiza ou cria a instância baseada no ID informado
        $data = $request->all();
        Servico::updateOrCreate(
            ['id' => $id],
            $data
        );

        // Redireciona de volta para a listagem
        return redirect('servico');
    }

    /**
     * Deleta um serviço do banco de dados.
     */
    public function destroy($id)
    {
        // Busca o serviço pelo ID fornecido
        $servico = Servico::findOrFail($id);

        // Executa a exclusão do registro
        $servico->delete();

        // Redireciona o usuário para a listagem
        return redirect('servico');
    }

    /**
     * Realiza a busca/filtro de serviços na listagem.
     */
    public function search(Request $request)
    {
        // Verifica se o campo de busca/valor foi preenchido
        if (!empty($request->valor)) {
            $dados = Servico::where('nome_servico', 'like', '%' . $request->valor . '%')->get();
        } else {
            // Se a busca for enviada vazia, retorna todos os serviços
            $dados = Servico::all();
        }

        // Retorna a view de listagem exibindo os resultados
        return view('servico.list', ['dados' => $dados]);
    }
}