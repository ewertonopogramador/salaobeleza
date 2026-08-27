<?php

namespace App\Http\Controllers;

// Importação dos modelos e recursos necessários
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    /**
     * Exibe a listagem de clientes cadastrados.
     */
    public function index()
    {
        // Busca todos os registros da tabela 'clientes'
        $dados = Cliente::all();

        // Retorna a view 'cliente.list' passando a lista de clientes
        return view('cliente.list', [
            'dados' => $dados
        ]);
    }

    /**
     * Exibe o formulário de cadastro de novo cliente.
     */
    public function create()
    {
        // Retorna a view 'cliente.form' para exibição do formulário
        return view('cliente.form');
    }

    /**
     * Salva um novo cliente no banco de dados e processa o upload de foto.
     */
    public function store(Request $request)
    {
        // Validação dos dados enviados pelo formulário
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

        // Tratamento para upload de arquivo/imagem de foto de perfil do cliente
        $imagem = $request->file('imagem');
        if ($imagem) {
            // Gera um nome único baseado na data/hora
            $nome_arquivo = date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/cliente/';

            // Salva a imagem no disco 'public'
            $imagem->storeAs($diretorio, $nome_arquivo, 'public');

            // Armazena o caminho relativo no array de dados para salvar no BD
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        // Cria o registro no banco via Eloquent
        Cliente::create($data);

        // Redireciona de volta para a tela de listagem de clientes
        return redirect('cliente');
    }

    /**
     * Exibe o formulário preenchido para edição de um cliente.
     */
    public function edit($id)
    {
        // Busca o cliente pelo ID (retorna erro caso não localize)
        $dado = Cliente::findOrFail($id);

        // Retorna a mesma view 'cliente.form' com os dados carregados
        return view('cliente.form', [
            'dado' => $dado,
        ]);
    }

    /**
     * Atualiza os dados de um cliente existente no banco de dados.
     */
    public function update(Request $request, $id)
    {
        // Aplica as mesmas validações do cadastro
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

        // Se uma nova foto for enviada na edição, atualiza a imagem no storage
        $imagem = $request->file('imagem');
        if ($imagem) {
            $nome_arquivo = date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = 'imagem/cliente/';

            $imagem->storeAs($diretorio, $nome_arquivo, 'public');
            $data['imagem'] = $diretorio . $nome_arquivo;
        }

        // Atualiza os dados no banco usando o ID fornecido
        Cliente::updateOrCreate(
            ['id' => $id],
            $data
        );

        return redirect('cliente');
    }

    /**
     * Remove o cliente do banco e apaga sua imagem física no servidor.
     */
    public function destroy($id)
    {
        // Localiza o cliente no banco de dados
        $cliente = Cliente::findOrFail($id);

        // Se existir um caminho de imagem e o arquivo físico estiver armazenado, remove do disco
        if ($cliente->imagem && Storage::disk('public')->exists($cliente->imagem)) {
            Storage::disk('public')->delete($cliente->imagem);
        }

        // Deleta o registro da tabela
        $cliente->delete();

        return redirect('cliente');
    }

    /**
     * Realiza a busca/filtragem de clientes na tabela de listagem.
     */
    public function search(Request $request)
    {
        // Se houver um valor preenchido no campo de busca
        if (!empty($request->valor)) {
            $dados = Cliente::where(
                $request->tipo, // ex: 'nome', 'cpf' ou 'telefone'
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            // Caso a busca venha vazia, retorna todos os registros
            $dados = Cliente::all();
        }

        // Retorna a view de listagem com os dados filtrados
        return view('cliente.list', ['dados' => $dados]);
    }
}