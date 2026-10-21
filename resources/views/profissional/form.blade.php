@extends('base')

@section('titulo', 'Formulário Profissional')

@section('conteudo')

<h3 class="mb-4">{{ !empty($dado->id) ? 'Editar Profissional' : 'Novo Profissional' }}</h3>


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ !empty($dado->id) ? url("profissional/$dado->id") : url('profissional') }}" method="POST" enctype="multipart/form-data">

    @csrf

    @if (!empty($dado->id))
    @method('PUT')
    @endif

    <div class="row">
        {{-- Campo para entrada do Nome do Profissional --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Nome</label>
            {{-- old('nome') recupera o valor digitado se der erro de validação; $dado->nome traz o dado na edição --}}
            <input type="text" name="nome" class="form-control"
                value="{{ old('nome', $dado->nome ?? '') }}" required>
        </div>

        {{-- Campo para entrada do Especialidade do Profissional --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Especialidade</label>
            <input type="text" name="especialidade" class="form-control"
                value="{{ old('especialidade', $dado->especialidade ?? '') }}" required>
        </div>

        {{-- Campo para entrada do Telefone do Profissional --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Telefone</label>
            <input type="tel" name="telefone" class="form-control" maxlength="20"
                value="{{ old('telefone', $dado->telefone ?? '') }}" required>
        </div>

        {{-- Bloco para carregamento e exibição da Foto do Profissional --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Foto do Profissional</label>
            <div class="mb-2">
                {{-- Bloco PHP para definir uma imagem padrão (fallback) caso o profissional não tenha foto cadastrada --}}
                @php
                $imagem = !empty($dado->imagem)
                ? asset('storage/' . $dado->imagem)
                : asset('images/sem-imagem.svg');
                @endphp
                {{-- Exibe a miniatura da foto salva na pasta /storage --}}
                <img src="{{ $imagem }}" width="100" height="100" class="img-thumbnail" alt="Foto do profissional">
            </div>
            {{-- Input do tipo file para selecionar o arquivo de imagem no computador --}}
            <input type="file" name="imagem" class="form-control">
        </div>

        {{-- Campo para entrada do ID do Usuário associado ao Profissional --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">ID do Usuário</label>
            <input type="number" name="user_id" class="form-control"
                value="{{ old('user_id', $dado->user_id ?? '') }}" required>
        </div>

        {{-- Botões para submissão do formulário ou retorno à lista --}}
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ url('profissional') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</form>
@stop