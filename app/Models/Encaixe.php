<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Encaixe extends Model
{
    use HasFactory;

    public function movimentos(): HasMany
    {
        return $this->hasMany(Encaixe_movimento::class);
    }

    public function tecidos()
    {
        $tecidosArray = $this->movimentos->pluck('tecido')->toArray();
        $tecidosSemRepeticao = array_unique($tecidosArray);

        return $tecidosSemRepeticao;
    }



    protected $fillable = [
        'referencia',
    ];
}
