@extends('base')

@section('conteudo')
    <h1 class="mb-4">{{ isset($dado) ? 'Editar Agendamento' : 'Novo Agendamento' }}</h1>

    {{-- Bloco para exibição dos erros de validação --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form que envia para store (POST) ou update (PUT) --}}
    <form action="{{ isset($dado) ? url("agendamento/$dado->id") : url('agendamento') }}" method="POST">
        @csrf
        @if (isset($dado))
            @method('PUT')
        @endif

        {{-- Seleção de Cliente --}}
        <div class="form-group mb-3">
            <label for="id_cliente" class="form-label">Cliente</label>
            <select class="form-control" name="id_cliente" id="id_cliente" required>
                <option value="">Selecione um Cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" 
                        {{ old('id_cliente', isset($dado) ? $dado->id_cliente : '') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }} - CPF: {{ $cliente->cpf }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Seleção de Serviço --}}
        <div class="form-group mb-3">
            <label for="id_servico" class="form-label">Serviço</label>
            <select class="form-control" name="id_servico" id="id_servico" required>
                <option value="">Selecione um Serviço</option>
                @foreach($servicos as $servico)
                    <option value="{{ $servico->id }}" 
                        {{ old('id_servico', isset($dado) ? $dado->id_servico : '') == $servico->id ? 'selected' : '' }}>
                        {{ $servico->nome_servico }} (R$ {{ number_format($servico->preco, 2, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Data do Agendamento --}}
        <div class="form-group mb-3">
            <label for="data_agendamento" class="form-label">Data do Agendamento</label>
            <input type="date" class="form-control" name="data_agendamento" id="data_agendamento" 
                value="{{ old('data_agendamento', isset($dado) ? $dado->data_agendamento : '') }}" required>
        </div>

        {{-- Horário do Agendamento --}}
        <div class="form-group mb-3">
            <label for="horario_agendamento" class="form-label">Horário do Agendamento</label>
            <input type="time" class="form-control" name="horario_agendamento" id="horario_agendamento" 
                value="{{ old('horario_agendamento', isset($dado) ? $dado->horario_agendamento : '') }}" required>
        </div>

        {{-- Botões de ação --}}
        <button type="submit" class="btn btn-primary">
            {{ isset($dado) ? 'Atualizar Agendamento' : 'Salvar Agendamento' }}
        </button>
        <a href="{{ url('agendamento') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection