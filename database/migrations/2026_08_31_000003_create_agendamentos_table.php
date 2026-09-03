<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de agendamentos do salão.
     * A relação é feita com clientes e serviços, conforme o domínio do projeto.
     */
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->date('data_agendamento');
            $table->time('horario_agendamento');
            $table->unsignedBigInteger('id_servico');
            $table->unsignedBigInteger('id_cliente');
            $table->timestamps();

            // Relacionamento com a tabela de serviços
            $table->foreign('id_servico')->references('id')->on('servicos')->onDelete('cascade');

            // Relacionamento com a tabela de clientes
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Remove a tabela de agendamentos se a migration for revertida.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
