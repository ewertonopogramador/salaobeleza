<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    use HasFactory;
    protected $table = 'profissionais';
    protected $fillable = ['nome', 'especialidade', 'telefone', 'imagem', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
