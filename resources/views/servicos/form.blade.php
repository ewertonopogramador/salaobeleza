@extends('base')

@section('titulo', 'Formulário Serviço')

@section('conteudo')
    {{-- Título dinâmico altera entre 'Editar' e 'Novo' dependendo da existência da variável --}}
    <h1 class="mb-4">{{ isset($dado) ? 'Editar Serviço' : 'Novo Serviço' }}</h1>

   
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($dado) ? url("servico/$dado->id") : url('servico') }}" method="POST">
        
        @csrf

        @if (isset($dado))
            @method('PUT')
        @endif

        {{-- Campo Nome do Serviço --}}
        <div class="form-group mb-3">
            <label for="nome_servico" class="form-label">Nome do Serviço</label>
            {{-- old() mantém o valor digitado se houver erro de validação; se não, carrega a variável --}}
            <input type="text" class="form-control" id="nome_servico" name="nome_servico" 
                value="{{ old('nome_servico', $dado->nome_servico ?? '') }}" required>
        </div>

        {{-- Campo Descrição do Serviço --}}
        <div class="form-group mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao', $dado->descricao ?? '') }}</textarea>
        </div>

        {{-- Campo Preço do Serviço --}}
        <div class="form-group mb-3">
            <label for="preco" class="form-label">Preço (R$)</label>
            <input type="number" class="form-control" id="preco" name="preco" 
                value="{{ old('preco', $dado->preco ?? '') }}" required step="0.01" min="0" placeholder="0.00">
        </div>

        {{-- Botões de submissão e cancelamento --}}
        <button type="submit" class="btn btn-primary">
            {{ isset($dado) ? 'Atualizar' : 'Criar' }}
        </button>
        <a href="{{ url('servico') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection