@extends('base')

@section('titulo', 'Gráfico de Estoque de Produtos')

@section('conteudo')
    <div class="container mt-4">
        <h3 class="mb-4">Gráfico de Estoque de Produtos</h3>

        <div class="card shadow-sm p-3">
            {{-- container() cria a área (div) onde o gráfico é desenhado --}}
            {!! $chart->container() !!}
        </div>

        <a href="{{ url('produto') }}" class="btn btn-secondary mt-3">Voltar</a>
    </div>

    {{-- cdn() carrega a biblioteca ApexCharts; script() gera o JavaScript que desenha o gráfico
         com os dados vindos do controller. A ordem importa: biblioteca primeiro, depois o script. --}}
    <script src="{{ $chart->cdn() }}"></script>
    {!! $chart->script() !!}
@stop
