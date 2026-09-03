<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de serviços do salão.
     * Ela será usada para armazenar os serviços disponibilizados pelo estabelecimento.
     */
    public function up(): void
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_servico', 100);
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Remove a tabela caso a migration seja revertida.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
