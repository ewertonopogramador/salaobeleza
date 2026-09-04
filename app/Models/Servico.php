<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';

    protected $fillable = [
        'nome_servico',
        'descricao',
        'preco',
    ];

    protected $casts = [
        'preco' => 'float',
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_servico');
    }
}
