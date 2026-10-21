@extends('base')

@section('titulo', 'Formulário Produto')

@section('conteudo')

<h3 class="mb-4">{{ !empty($dado->id) ? 'Editar Produto' : 'Novo Produto' }}</h3>


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ !empty($dado->id) ? url("produto/$dado->id") : url('produto') }}" method="POST" enctype="multipart/form-data">

    @csrf

    @if (!empty($dado->id))
    @method('PUT')
    @endif

    <div class="row">
        {{-- Campo para entrada do Nome do Produto --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Nome</label>
            {{-- old('nome') recupera o valor digitado se der erro de validação; $dado->nome traz o dado na edição --}}
            <input type="text" name="nome" class="form-control"
                value="{{ old('nome', $dado->nome ?? '') }}" required>
        </div>

        {{-- Campo para entrada do Preço do Produto --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Preço</label>
            <input type="number" name="preco" class="form-control"
                value="{{ old('preco', $dado->preco ?? '') }}" required>
        </div>

        {{-- Campo para entrada do Estoque do Produto --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Estoque</label>
            <input type="number" name="estoque" class="form-control" step="0.01"
                value="{{ old('estoque', $dado->estoque ?? '') }}" required>
        </div>

        {{-- Bloco para carregamento e exibição da Foto do Produto --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Foto do Produto</label>
            <div class="mb-2">
                {{-- Bloco PHP para definir uma imagem padrão (fallback) caso o produto não tenha foto cadastrada --}}
                @php
                $imagem = !empty($dado->imagem)
                ? asset('storage/' . $dado->imagem)
                : asset('images/sem-imagem.svg');
                @endphp
                {{-- Exibe a miniatura da foto salva na pasta /storage --}}
                <img src="{{ $imagem }}" width="100" height="100" class="img-thumbnail" alt="Foto do produto">
            </div>
            {{-- Input do tipo file para selecionar o arquivo de imagem no computador --}}
            <input type="file" name="imagem" class="form-control">
        </div>

        {{-- Botões para submissão do formulário ou retorno à lista --}}
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ url('produto') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</form>
@stop