@extends('base')

@section('titulo', 'Listagem de Serviços')

@section('conteudo')
<div class="container mt-4">
    <h1 class="mb-4">Lista de Serviços</h1>

    {{-- Mensagem de sucesso do cadastro/edição. --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row g-2 mb-3">
        <div class="col-md-8">
            <form action="{{ route('servico.search') }}" method="POST" class="input-group">
                @csrf
                <input type="text" name="valor" class="form-control" placeholder="Buscar por nome do serviço" value="{{ old('valor') }}">
                <button type="submit" class="btn btn-secondary">Buscar</button>
            </form>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ url('servico/create') }}" class="btn btn-primary">Novo Serviço</a>
        </div>
    </div>

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
            @forelse ($dados as $servico)
            <tr>
                <td>{{ $servico->id }}</td>
                <td>{{ $servico->nome_servico }}</td>
                <td>{{ $servico->descricao }}</td>
                <td>R$ {{ number_format($servico->preco, 2, ',', '.') }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ url('servico/' . $servico->id . '/edit') }}" class="btn btn-warning btn-sm">Editar</a>

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
            <tr>
                <td colspan="5" class="text-center">Nenhum serviço cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@stop