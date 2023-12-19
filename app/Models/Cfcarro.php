<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cfcarro extends Model
{
    use HasFactory;

    public function cf(): BelongsTo
    {
        return $this->belongsTo(Cf::class);
    }

    protected $fillable = [
        'numero_veiculo',
        'placa',
        'modelo',
        'renavan'
    ];
}
