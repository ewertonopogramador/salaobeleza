
@extends('base')

@section('titulo', 'Listagem de Profissional')

@section('conteudo')

<h3 class="mb-4">Listagem de Profissional</h3>

{{-- Bloco de Busca e Ação --}}
<div class="row mb-4">
    {{-- Formulário de pesquisa que envia por POST para a rota de busca de profissional --}}
    <form action="{{ route('profissional.search') }}" method="post">
        {{-- Token de segurança obrigatório do Laravel --}}
        @csrf
        <div class="row">
            {{-- Select para escolher por qual coluna do banco deseja pesquisar --}}
            <div class="col-3">
                <select name="tipo" class="form-select">
                    <option value="nome">Nome</option>
                    <option value="especialidade">Especialidade</option>
                    <option value="telefone">Telefone</option>
                </select>
            </div>

            {{-- Campo de texto para digitar o termo buscado --}}
            <div class="col-5">
                <input type="text" name="valor" class="form-control" placeholder="Digite o termo da busca...">
            </div>

            {{-- Botões para disparar a busca e para cadastrar um novo profissional --}}
            <div class="col-4">
                <button type="submit" class="btn btn-primary">Buscar</button>
                {{-- Direciona para a rota de criação de novo profissional --}}
                <a class="btn btn-success" href="{{ url('profissional/create') }}">Novo Profissional</a>
            </div>
        </div>
    </form>
</div>

{{-- Tabela para exibição dos dados dos Profissionais --}}
<div class="row">
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Imagem</th>
                <th scope="col">Nome</th>
                <th scope="col">Especialidade</th>
                <th scope="col">Telefone</th>
                <th scope="col">Usuário</th>
                <th scope="col" class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop para percorrer a coleção de profissionals enviada pelo Controller --}}
            @forelse ($dados as $item)
            {{-- Bloco PHP para definir uma foto padrão caso o registro não tenha imagem salva --}}
            @php
            $imagem = !empty($item->imagem)
            ? asset('storage/' . $item->imagem)
            : asset('images/sem-imagem.svg');
            @endphp
            <tr>
                <td scope="row">{{ $item->id }}</td>

                {{-- Exibe a foto do profissional --}}
                <td>
                    <img src="{{ $imagem }}" width="60" height="60" class="rounded-circle img-thumbnail" alt="Foto de {{ $item->nome }}">
                </td>

                <td>{{ $item->nome }}</td>
                <td>{{ $item->especialidade }}</td>
                <td>{{ $item->telefone }}</td>

                {{-- $item->user usa o relacionamento belongsTo definido no Model Profissional.
                     Mostra o NOME do usuário; o "?->" evita erro quando user_id é nulo
                     e o "??" exibe um traço nesse caso --}}
                <td>{{ $item->user?->name ?? '-' }}</td>

                {{-- Coluna unificada para as Ações (Editar e Deletar) --}}
                <td>
                    <div class="d-flex gap-2">
                        {{-- Link para a tela de edição --}}
                        <a href="{{ route('profissional.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        {{-- Formulário para remoção do registro via verbo DELETE --}}
                        <form action="{{ route('profissional.destroy', $item->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja remover este profissional?')">
                                Deletar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            {{-- Exibido caso não haja nenhum profissional cadastrado ou encontrado na busca --}}
            <tr>
                <td colspan="7" class="text-center">Nenhum profissional encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@stop