<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Encaixe extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movimentos(): HasMany
    {
        return $this->hasMany(Encaixe_movimento::class);
    }

    public function tecidos()
    {
        $tecidosArray = $this->movimentos->pluck('tecido')->toArray();

        $result = [];
        foreach ($tecidosArray as $key => $value) {
            if (!in_array($value, $result) && $value != null && $value !=  " ")
                $result[$key] = $value;
        }

        return $result;
    }

    protected $fillable = [
        'referencia',
        'user_id'
    ];
}
