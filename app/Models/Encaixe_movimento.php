<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Encaixe_movimento extends Model
{
    use HasFactory;

    public function encaixe(): BelongsTo
    {
        return $this->belongsTo(Encaixe::class);
    }

    public function consumos(): HasMany
    {
        return $this->hasMany(Encaixe_movimento_consumo::class);
    }
}
