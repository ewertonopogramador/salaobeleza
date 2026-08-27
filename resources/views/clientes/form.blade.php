{{-- Herda a estrutura do layout base (HTML principal, CSS, JS) --}}
@extends('base')

{{-- Define o título da aba do navegador --}}
@section('titulo', 'Formulário Cliente')

{{-- Define o conteúdo que será injetado na tag @yield('conteudo') do layout base --}}
@section('conteudo')
    {{-- Título dinâmico: se existir um ID, altera o texto para 'Editar', se não, 'Novo' --}}
    <h3 class="mb-4">{{ !empty($dado->id) ? 'Editar Cliente' : 'Novo Cliente' }}</h3>

    {{-- Bloco para exibição de erros de validação retornados pelo Controller --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário com suporte a envio de arquivos (enctype="multipart/form-data") --}}
    {{-- Direciona para a rota 'store' (POST) se for cadastro novo ou 'update' (PUT) se for edição --}}
    <form action="{{ !empty($dado->id) ? url("cliente/$dado->id") : url('cliente') }}" method="POST" enctype="multipart/form-data">
        
        {{-- Token de segurança obrigatório do Laravel contra ataques CSRF --}}
        @csrf

        {{-- Em edições, instrui o Laravel a interpretar o envio do formulário como método PUT --}}
        @if (!empty($dado->id))
            @method('PUT')
        @endif

        <div class="row">
            {{-- Campo para entrada do Nome do Cliente --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Nome</label>
                {{-- old('nome') recupera o valor digitado se der erro de validação; $dado->nome traz o dado na edição --}}
                <input type="text" name="nome" class="form-control" 
                    value="{{ old('nome', $dado->nome ?? '') }}" required>
            </div>

            {{-- Campo para entrada do CPF do Cliente --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" 
                    value="{{ old('cpf', $dado->cpf ?? '') }}" required>
            </div>

            {{-- Campo para entrada do Telefone do Cliente --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-control" 
                    value="{{ old('telefone', $dado->telefone ?? '') }}" required>
            </div>

            {{-- Bloco para carregamento e exibição da Foto do Cliente --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Foto do Cliente</label>
                <div class="mb-2">
                    {{-- Bloco PHP para definir uma imagem padrão (fallback) caso o cliente não tenha foto cadastrada --}}
                    @php
                        $nome_imagem = !empty($dado->imagem) ? $dado->imagem : 'sem_imagem.jpg';
                    @endphp
                    {{-- Exibe a miniatura da foto salva na pasta /storage --}}
                    <img src="/storage/{{ $nome_imagem }}" width="100px" height="100px" class="img-thumbnail" alt="Foto Cliente">
                </div>
                {{-- Input do tipo file para selecionar o arquivo de imagem no computador --}}
                <input type="file" name="imagem" class="form-control">
            </div>

            {{-- Botões para submissão do formulário ou retorno à lista --}}
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ url('cliente') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </form>
@stop