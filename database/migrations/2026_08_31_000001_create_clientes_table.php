<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela de clientes do salão.
     * Este arquivo foi adicionado para completar a estrutura que faltava no projeto.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 130);
            $table->string('cpf', 14)->unique();
            $table->string('telefone', 20);
            $table->string('imagem')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Desfaz a criação da tabela se a migration for revertida.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
