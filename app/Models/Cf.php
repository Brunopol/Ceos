<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cf extends Model
{
    use HasFactory;

    public function carro(): HasOne
    {
        return $this->hasOne(Cfcarro::class);
    }

    public function condutor(): HasOne
    {
        return $this->hasOne(Cfcondutor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'destino',
        'data_saida',
        'hora_saida',
        'data_chegada',
        'hora_chegada',
        'dataSaida'
    ];
}
