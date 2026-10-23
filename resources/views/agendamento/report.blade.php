<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    {{-- O dompdf não carrega bem CSS de CDN links externos então o estilo fica
         escrito aqui dentro da própria página --}}
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h3 { margin-bottom: 4px; }
        .info { color: #666; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #eee; }
        tr:nth-child(even) td { background: #f8f8f8; }
    </style>
</head>

<body>
    <h3>{{ $titulo }}</h3>
    {{-- now() devolve a data/hora atual; format() define o formato brasileiro --}}
    <div class="info">Gerado em {{ now()->format('d/m/Y H:i') }} — Total: {{ $dados->count() }} agendamento(s)</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Telefone</th>
                <th>Serviço</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            {{-- $dados vem do AgendamentoController::report() --}}
            @foreach ($dados as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    {{-- optional() evita erro caso o cliente/serviço tenha sido removido --}}
                    <td>{{ optional($item->cliente)->nome ?? '-' }}</td>
                    <td>{{ optional($item->cliente)->telefone ?? '-' }}</td>
                    <td>{{ optional($item->servico)->nome_servico ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->data_agendamento)->format('d/m/Y') }}</td>
                    <td>{{ $item->horario_agendamento }}</td>
                    <td>R$ {{ number_format(optional($item->servico)->preco ?? 0, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
