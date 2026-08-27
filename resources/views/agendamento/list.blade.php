@extends('base')

@section('conteudo')
    <div class="container mt-4">
        <h1>Listagem de Agendamentos</h1>
        
        <!-- Botão para criar novo agendamento -->
        <a href="{{ url('agendamento/create') }}" class="btn btn-primary mb-3">Criar Novo Agendamento</a>

        <!-- Formulário de busca -->
        <form action="{{ url('agendamento/search') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="nome_cliente" class="form-control" placeholder="Buscar por Nome do Cliente">
                <input type="date" name="data_agendamento" class="form-control">
                <button type="submit" class="btn btn-secondary">Buscar</button>
                <a href="{{ url('agendamento') }}" class="btn btn-outline-secondary">Limpar</a>
            </div>
        </form>

        <!-- Tabela de agendamentos -->
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Telefone</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Serviço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados as $agendamento)
                    <tr>
                        <td>{{ optional($agendamento->cliente)->nome ?? 'N/A' }}</td>
                        <td>{{ optional($agendamento->cliente)->telefone ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($agendamento->data_agendamento)->format('d/m/Y') }}</td>
                        <td>{{ $agendamento->horario_agendamento }}</td>
                        <td>
                            {{ optional($agendamento->servico)->nome_servico ?? 'N/A' }} 
                            @if($agendamento->servico)
                                <small class="text-muted">(R$ {{ number_format($agendamento->servico->preco, 2, ',', '.') }})</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('agendamento/' . $agendamento->id . '/edit') }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ url('agendamento/' . $agendamento->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum agendamento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop