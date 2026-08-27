<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory; // Habilita o uso de Factories para popular o banco de dados

    // Define o nome da tabela no banco de dados
    protected $table = 'clientes';

    // Campos autorizados para cadastro/edição em massa via formulário
    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'imagem',
    ];

    /**
     * Relacionamento: 1 Cliente possui muitos Agendamentos (1:N)
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_cliente');
    }
}