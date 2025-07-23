<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deputado;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profissao extends Model {

    protected $table = 'profissoes';

    protected $fillable = [
        'descricao',
        'deputado_id',
    ];

    public function deputado(): BelongsTo {

        return $this->belongsTo(Deputado::class);
    }
}
