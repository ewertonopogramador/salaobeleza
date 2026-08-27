<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory; // Permite gerar dados de teste com Seeders/Factories

    // Nome da tabela no banco de dados
    protected $table = 'servicos';

    // Campos do formulário autorizados para persistência em massa
    protected $fillable = [
        'nome_servico',
        'descricao',
        'preco',
    ];

    // Converte automaticamente o preço para o tipo numérico adequado
    protected $casts = [
        'preco' => 'float',
    ];

    /**
     * Relacionamento: 1 Serviço pode estar em vários Agendamentos (1:N)
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_servico');
    }
}