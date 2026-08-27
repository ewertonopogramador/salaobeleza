{{-- Herda a estrutura do layout base (HTML principal, CSS, JS) --}}
@extends('base')

{{-- Define o título da aba do navegador --}}
@section('titulo', 'Listagem de Clientes')

{{-- Define o conteúdo que será inserido na página --}}
@section('conteudo')

    <h3 class="mb-4">Listagem de Clientes</h3>

    {{-- Bloco de Busca e Ação --}}
    <div class="row mb-4">
        {{-- Formulário de pesquisa que envia por POST para a rota de busca de cliente --}}
        <form action="{{ route('cliente.search') }}" method="post">
            {{-- Token de segurança obrigatório do Laravel --}}
            @csrf
            <div class="row">
                {{-- Select para escolher por qual coluna do banco deseja pesquisar --}}
                <div class="col-3">
                    <select name="tipo" class="form-select">
                        <option value="nome">Nome</option>
                        <option value="cpf">CPF</option>
                        <option value="telefone">Telefone</option>
                    </select>
                </div>

                {{-- Campo de texto para digitar o termo buscado --}}
                <div class="col-5">
                    <input type="text" name="valor" class="form-control" placeholder="Digite o termo da busca...">
                </div>

                {{-- Botões para disparar a busca e para cadastrar um novo cliente --}}
                <div class="col-4">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    {{-- Direciona para a rota de criação de novo cliente --}}
                    <a class="btn btn-success" href="{{ url('cliente/create') }}">Novo Cliente</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabela para exibição dos dados dos Clientes --}}
    <div class="row">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Telefone</th>
                    <th scope="col" text-center>Ações</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop para percorrer a coleção de clientes enviada pelo Controller --}}
                @forelse ($dados as $item)
                    {{-- Bloco PHP para definir uma foto padrão caso o registro não tenha imagem salva --}}
                    @php
                        $nome_imagem = !empty($item->imagem) ? $item->imagem : 'sem_imagem.jpg';
                    @endphp
                    <tr>
                        <td scope="row">{{ $item->id }}</td>
                        
                        {{-- Exibe a foto do cliente --}}
                        <td>
                            <img src="/storage/{{ $nome_imagem }}" width="60px" height="60px" class="rounded-circle img-thumbnail" alt="imagem">
                        </td>
                        
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->cpf }}</td>
                        <td>{{ $item->telefone }}</td>
                        
                        {{-- Coluna unificada para as Ações (Editar e Deletar) --}}
                        <td>
                            <div class="d-flex gap-2">
                                {{-- Link para a tela de edição --}}
                                <a href="{{ route('cliente.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>

                                {{-- Formulário para remoção do registro via verbo DELETE --}}
                                <form action="{{ route('cliente.destroy', $item->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja remover este cliente?')">
                                        Deletar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- Exibido caso não haja nenhum cliente cadastrado ou encontrado na busca --}}
                    <tr>
                        <td colspan="6" class="text-center">Nenhum cliente encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop