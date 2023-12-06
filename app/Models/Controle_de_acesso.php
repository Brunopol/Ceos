<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Controle_de_acesso extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function solicitacao(): BelongsTo
    {
        return $this->belongsTo(Solicitacoe::class);
    }

    protected $fillable = [
        'nome',
        'rgCpf',
        'transportadora',
        'placa',
        'horaEntrada',
        'horaSaida',
        'dataSaida',
        'setorResponsavel',
        'pessoaResponsavel',
        'deletado'
    ];
}
