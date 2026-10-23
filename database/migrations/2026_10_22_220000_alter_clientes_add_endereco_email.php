<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona os campos endereço e e-mail na tabela de clientes.
     * Usamos uma migration de "alter" (e não editamos a original) para que bancos
     * que já têm a tabela criada ganhem as colunas apenas rodando "php artisan migrate".
     * Os campos são nullable para não quebrar os clientes que já estão cadastrados.
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('endereco', 255)->nullable()->after('telefone');
            $table->string('email', 150)->nullable()->after('endereco');
        });
    }

    /**
     * Remove as colunas se a migration for revertida.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn(['endereco', 'email']);
        });
    }
};
