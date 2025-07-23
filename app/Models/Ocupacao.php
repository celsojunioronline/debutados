<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deputado;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ocupacao extends Model {

    protected $table = 'ocupacoes';

    protected $fillable = [
        'titulo',
        'entidade',
        'ano_inicio',
        'ano_fim',
        'deputado_id',
    ];

    public function deputado(): BelongsTo {

        return $this->belongsTo(Deputado::class);
    }
}
