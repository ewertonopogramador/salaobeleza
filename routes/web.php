<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProfissionalController;

/*
|--------------------------------------------------------------------------
| Rotas do sistema de salão
|--------------------------------------------------------------------------
|
| As rotas abaixo controlam o fluxo do cadastro de clientes, serviços e
| agendamentos. Elas seguem o padrão de CRUD do Laravel e também incluem
| busca personalizada para listagens.
|
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('cliente.index')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente.index');
    Route::get('/cliente/create', [ClienteController::class, 'create'])->name('cliente.create');
    Route::post('/cliente', [ClienteController::class, 'store'])->name('cliente.store');
    Route::get('/cliente/{id}/edit', [ClienteController::class, 'edit'])->name('cliente.edit');
    Route::put('/cliente/{id}', [ClienteController::class, 'update'])->name('cliente.update');
    Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
    Route::post('/cliente/search', [ClienteController::class, 'search'])->name('cliente.search');

    Route::get('/servico', [ServicoController::class, 'index'])->name('servico.index');
    // Relatório em PDF. Fica antes das rotas com {id} para o Laravel não confundir
    // "report" com um id.
    Route::get('/servico/report', [ServicoController::class, 'report'])->name('servico.report');
    Route::get('/servico/create', [ServicoController::class, 'create'])->name('servico.create');
    Route::post('/servico', [ServicoController::class, 'store'])->name('servico.store');
    Route::get('/servico/{id}/edit', [ServicoController::class, 'edit'])->name('servico.edit');
    Route::put('/servico/{id}', [ServicoController::class, 'update'])->name('servico.update');
    Route::delete('/servico/{id}', [ServicoController::class, 'destroy'])->name('servico.destroy');
    Route::post('/servico/search', [ServicoController::class, 'search'])->name('servico.search');

    Route::get('/agendamento', [AgendamentoController::class, 'index'])->name('agendamento.index');
    Route::get('/agendamento/chart', [AgendamentoController::class, 'chart'])->name('agendamento.chart');
    Route::get('/agendamento/report', [AgendamentoController::class, 'report'])->name('agendamento.report');
    Route::get('/agendamento/create', [AgendamentoController::class, 'create'])->name('agendamento.create');
    Route::post('/agendamento', [AgendamentoController::class, 'store'])->name('agendamento.store');
    Route::get('/agendamento/{id}/edit', [AgendamentoController::class, 'edit'])->name('agendamento.edit');
    Route::put('/agendamento/{id}', [AgendamentoController::class, 'update'])->name('agendamento.update');
    Route::delete('/agendamento/{id}', [AgendamentoController::class, 'destroy'])->name('agendamento.destroy');
    Route::get('/agendamento/search', [AgendamentoController::class, 'search'])->name('agendamento.search');

    // Gráfico de barras (antes das rotas com {id}).
    Route::get('/produto/chart', [ProdutoController::class, 'chart'])->name('produto.chart');
    Route::get('/produto', [ProdutoController::class, 'index'])->name('produto.index');
    Route::get('/produto/create', [ProdutoController::class, 'create'])->name('produto.create');
    Route::post('/produto', [ProdutoController::class, 'store'])->name('produto.store');
    Route::get('/produto/{id}/edit', [ProdutoController::class, 'edit'])->name('produto.edit');
    Route::put('/produto/{id}', [ProdutoController::class, 'update'])->name('produto.update');
    Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');
    Route::post('/produto/search', [ProdutoController::class, 'search'])->name('produto.search');

    Route::get('/profissional', [ProfissionalController::class, 'index'])->name('profissional.index');
    Route::get('/profissional/create', [ProfissionalController::class, 'create'])->name('profissional.create');
    Route::post('/profissional', [ProfissionalController::class, 'store'])->name('profissional.store');
    Route::get('/profissional/{id}/edit', [ProfissionalController::class, 'edit'])->name('profissional.edit');
    Route::put('/profissional/{id}', [ProfissionalController::class, 'update'])->name('profissional.update');
    Route::delete('/profissional/{id}', [ProfissionalController::class, 'destroy'])->name('profissional.destroy');
    Route::post('/profissional/search', [ProfissionalController::class, 'search'])->name('profissional.search');

});
