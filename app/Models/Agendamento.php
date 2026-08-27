<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory; // Habilita a geração de dados com Seeders/Factories

    // Nome exato da tabela no banco de dados
    protected $table = 'agendamentos';

    // Campos do formulário autorizados para preenchimento em massa
    protected $fillable = [
        'data_agendamento',
        'horario_agendamento',
        'id_servico',
        'id_cliente',
    ];

    /**
     * Relacionamento: N agendamentos pertencem a 1 Serviço (1:N)
     */
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'id_servico');
    }

    /**
     * Relacionamento: N agendamentos pertencem a 1 Cliente (1:N)
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}