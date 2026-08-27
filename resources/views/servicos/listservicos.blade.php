{{-- Herda a estrutura do layout base do projeto --}}
@extends('base')

{{-- Define o título da aba do navegador --}}
@section('titulo', 'Listagem de Serviços')

{{-- Bloco principal de conteúdo --}}
@section('conteudo')
    <div class="container mt-4">
        <h1 class="mb-4">Lista de Serviços</h1>

        {{-- Exibe mensagem temporária de sucesso vinda da Session (ex: "Serviço cadastrado com sucesso!") --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botão para direcionar ao formulário de cadastro de novo serviço --}}
        <a href="{{ url('servico/create') }}" class="btn btn-primary mb-3">Novo Serviço</a>

        {{-- Tabela de listagem de serviços cadastrados --}}
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome do Serviço</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                {{-- Percorre a lista de serviços retornada pelo Controller --}}
                @forelse ($dados as $servico)
                    <tr>
                        <td>{{ $servico->id }}</td>
                        <td>{{ $servico->nome_servico }}</td>
                        <td>{{ $servico->descricao }}</td>
                        {{-- Formata a exibição do valor numérico para Moeda Real (R$) --}}
                        <td>R$ {{ number_format($servico->preco, 2, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                {{-- Link para a rota de edição do registro --}}
                                <a href="{{ url('servico/' . $servico->id . '/edit') }}" class="btn btn-warning btn-sm">Editar</a>
                                
                                {{-- Formulário para envio da instrução DELETE ao controller --}}
                                <form action="{{ url('servico/' . $servico->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- Mensagem padrão exibida se a tabela do banco estiver vazia --}}
                    <tr>
                        <td colspan="5" class="text-center">Nenhum serviço cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop