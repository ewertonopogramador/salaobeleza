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
            <label class="form-label">Usuário</label>
            {{-- SELECT do relacionamento 1:1: o usuário vê o NOME, mas o valor enviado ao
                 servidor é o ID (value="{{ $id }}"), que vai para a coluna user_id --}}
            <select name="user_id" class="form-select">
                {{-- Opção vazia: o usuário é opcional no banco (coluna nullable) --}}
                <option value="">-- Nenhum --</option>
                {{-- $usuarios vem do controller no formato [id => nome] --}}
                @foreach ($usuarios as $id => $nome)
                {{-- selected marca a opção correta: old() mantém a escolha se a validação
                     falhar; senão usa o user_id já salvo (na edição) --}}
                <option value="{{ $id }}" {{ old('user_id', $dado->user_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $nome }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Botões para submissão do formulário ou retorno à lista --}}
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ url('profissional') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</form>
@stop