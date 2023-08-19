<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Encaixe_movimento_consumo extends Model
{
    use HasFactory;

    public function encaixe_movimento(): BelongsTo
    {
        return $this->belongsTo(Encaixe_movimento::class);
    }

    protected $fillable = [
        'nome',
        'valor',
    ];
}
