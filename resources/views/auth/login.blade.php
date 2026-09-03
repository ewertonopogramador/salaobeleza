@extends('base')

@section('titulo', 'Entrar')

@section('conteudo')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h1 class="h3 mb-4">Entrar no sistema</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1">
                <label for="remember" class="form-check-label">Lembrar de mim</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</div>
@endsection