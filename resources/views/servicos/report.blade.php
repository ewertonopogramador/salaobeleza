<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    {{-- CSS inline: o dompdf não carrega bem folhas de estilo externas (CDN) --}}
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h3 { margin-bottom: 4px; }
        h4 { margin: 18px 0 4px; }
        .info { color: #666; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>

<body>
    <h3>{{ $titulo }}</h3>
    <div class="info">Gerado em {{ now()->format('d/m/Y H:i') }}</div>

    {{-- Relatório do relacionamento 1:N: cada serviço mostra os seus agendamentos.
         $item->agendamentos usa o hasMany definido no Model Servico. --}}
    @foreach ($dados as $item)
        <h4>
            Serviço: {{ $item->nome_servico }}
            (R$ {{ number_format($item->preco, 2, ',', '.') }})
        </h4>

        @if ($item->agendamentos->isEmpty())
            <p>Nenhum agendamento para este serviço.</p>
        @else
            <p>Total de agendamentos: {{ $item->agendamentos->count() }}</p>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Horário</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item->agendamentos as $agendamento)
                        <tr>
                            <td>{{ $agendamento->id }}</td>
                            <td>{{ optional($agendamento->cliente)->nome ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->data_agendamento)->format('d/m/Y') }}</td>
                            <td>{{ $agendamento->horario_agendamento }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>

</html>
