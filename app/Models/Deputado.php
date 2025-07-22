<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Despesa;

class Deputado extends Model
{
    protected $primarykey = 'id';
    public $incrementing = false;

    protected $keyType = 'int';

    protected  $fillable = [
      'id', 'uri', 'nome', 'sigla_partido', 'sigla_uf', 'id_legislatura', 'url_foto', 'email',
    ];

    public function gastos(): HasMany {
        return $this->hasMany(Despesa::class);
    }
}
