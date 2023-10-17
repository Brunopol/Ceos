<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controle_de_acesso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'rgCpf',
        'transportadora',
        'placa',
        'horaEntrada',
        'horaSaida',
        'setorResponsavelPessoa'
    ];
}
