<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Deputado;

class Despesa extends Model
{
    protected $table = 'despesas';

    protected $fillable = [
        'deputado_id', 'ano', 'mes', 'tipo_despesa', 'cod_documento', 'tipo_documento', 'cod_tipo_documento', 'data_documento',
        'num_documento', 'valor_documento', 'url_documento', 'nome_fornecedor', 'cnpj_cpf_fornecedor', 'valor_liquido', 'valor_glosa',
        'num_ressarcimento', 'cod_lote', 'parcela',
    ];

    public function deputado(): BelongsTo {
        return $this->belongsTo(Deputado::class);
    }
}
