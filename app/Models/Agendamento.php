<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';

    protected $fillable = [
        'data_agendamento',
        'horario_agendamento',
        'id_servico',
        'id_cliente',
    ];

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'id_servico');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
