<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chave extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomePessoa',
        'nomeChave',
        'novaHoraEntrada',
        'novaHoraSaida',
        'dataSaida'
    ];
}
