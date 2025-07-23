<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Despesa;
use App\Models\Ocupacao;
use App\Models\Profissao;

class Deputado extends Model
{
    protected $primarykey = 'id';
    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'uri',
        'nome',
        'sigla_partido',
        'sigla_uf',
        'id_legislatura',
        'url_foto',
        'email',
        'nome_civil',
        'data_nascimento',
        'municipio_nascimento',
        'uf_nascimento',
    ];


    public function gastos(): HasMany {
        return $this->hasMany(Despesa::class);
    }

    public function ocupacoes(): HasMany
    {
        return $this->hasMany(Ocupacao::class);
    }

    public function profissoes(): HasMany
    {
        return $this->hasMany(Profissao::class);
    }
}
