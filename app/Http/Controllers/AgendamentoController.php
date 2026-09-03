<?php

namespace App\Http\Controllers;

// Importação das Models necessárias para o controller
use App\Models\Agendamento;
use App\Models\Servico;
use App\Models\Cliente; 
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    /**
     * Exibe a listagem de agendamentos no sistema.
     */
    public function index()
    {
        // Busca os agendamentos carregando os relacionamentos com 'servico' e 'cliente' (Eager Loading)
        $dados = Agendamento::with(['servico', 'cliente'])->get();

        // Retorna a view 'agendamento.list' passando os dados recuperados
        return view('agendamento.list', [
            'dados' => $dados
        ]);
    }

    /**
     * Exibe o formulário de criação de um novo agendamento.
     */
    public function create()
    {
        // Busca todos os serviços e clientes para popular os campos <select> do formulário
        $servicos = Servico::all();
        $clientes = Cliente::all();

        // Retorna a view 'agendamento.form' enviando os registros das tabelas relacionadas
        return view('agendamento.form', [
            'servicos' => $servicos,
            'clientes' => $clientes
        ]);
    }

    /**
     * Salva um novo agendamento no banco de dados após validação.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos do formulário
        $request->validate(
            [
                'data_agendamento'    => 'required|date',
                'horario_agendamento' => 'required',
                'id_servico'          => 'required|exists:servicos,id',
                'id_cliente'          => 'required|exists:clientes,id', // Valida se o cliente existe no BD
            ],
            [
                // Mensagens customizadas de erro de validação
                'data_agendamento.required'    => 'A data do agendamento é obrigatória.',
                'data_agendamento.date'        => 'Informe uma data válida.',
                'horario_agendamento.required' => 'O horário do agendamento é obrigatório.',
                'id_servico.required'          => 'O serviço é obrigatório.',
                'id_servico.exists'            => 'O serviço selecionado é inválido.',
                'id_cliente.required'          => 'O cliente é obrigatório.',
                'id_cliente.exists'            => 'O cliente selecionado é inválido.',
            ]
        );

        // Pega todos os dados do formulário e insere no banco via Eloquent
        $data = $request->all();
        Agendamento::create($data);

        // Redireciona o usuário para a rota de listagem de agendamentos
        return redirect('agendamento');
    }

    /**
     * Exibe o formulário de edição preenchido com os dados do agendamento escolhido.
     */
    public function edit($id)
    {
        // Busca o agendamento pelo ID fornecido
        $dado = Agendamento::findOrFail($id);

        // Busca todos os serviços e clientes para preencher as opções do formulário
        $servicos = Servico::all();
        $clientes = Cliente::all();

        // Retorna a view do formulário compartilhada enviando o registro atual e as listas de apoio
        return view('agendamento.form', [
            'dado'      => $dado,
            'servicos'  => $servicos,
            'clientes'  => $clientes,
        ]);
    }

    /**
     * Atualiza os dados de um agendamento já existente no banco de dados.
     */
    public function update(Request $request, $id)
    {
        // Executa as mesmas regras de validação do cadastro
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

        // Atualiza ou cria a instância baseada no ID informado
        $data = $request->all();
        Agendamento::updateOrCreate(
            ['id' => $id],
            $data
        );

        // Redireciona de volta para a listagem
        return redirect('agendamento');
    }

    /**
     * Remove um agendamento do banco de dados.
     */
    public function destroy($id)
    {
        // Busca o registro pelo ID (retorna erro 404 se não encontrar)
        $agendamento = Agendamento::findOrFail($id);
        
        // Deleta o registro encontrado
        $agendamento->delete();

        // Redireciona para a listagem
        return redirect('agendamento');
    }

    /**
     * Realiza buscas e filtragens na tabela de agendamentos.
     */
    public function search(Request $request)
    {
        // Inicia a query incluindo os relacionamentos para exibição na View
        $query = Agendamento::with(['servico', 'cliente']);

        // Filtro por data do agendamento
        if ($request->filled('data_agendamento')) {
            $query->whereDate('data_agendamento', $request->data_agendamento);
        }

        // Filtro por nome do cliente através do relacionamento (tabela 'clientes')
        if ($request->filled('nome_cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->nome_cliente . '%');
            });
        }

        // Executa a busca e recupera os resultados
        $dados = $query->get();

        // Retorna a view de listagem exibindo os registros filtrados
        return view('agendamento.list', ['dados' => $dados]);
    }
}