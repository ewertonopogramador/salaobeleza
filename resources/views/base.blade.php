<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sistema de Salão')</title>

    {{-- Carrega o Bootstrap usado no projeto para manter a aparência padronizada. --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Sala de Beleza</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('cliente') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('servico') }}">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('agendamento') }}">Agendamentos</a>
                    </li>
                </ul>
                @auth
                <span class="navbar-text me-3">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
                </form>
                @else
                <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Entrar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
        {{-- Este yield recebe o conteúdo específico de cada página do sistema. --}}
        @yield('conteudo')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>