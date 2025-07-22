<?php

namespace App\Jobs;

use App\Models\Despesa;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncDespesasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $deputadoId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $page = 1;

        do {
            $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$this->deputadoId}/despesas", [
                'pagina' => $page,
                'itens' => 100
            ]);

            $data = $response->json();

            foreach ($data['dados'] as $item) {
                Despesa::updateOrCreate(
                    [
                        'cod_documento' => $item['codDocumento'],
                        'deputado_id' => $this->deputadoId
                    ],
                    [
                        'ano'                  => $item['ano'],
                        'mes'                  => $item['mes'],
                        'tipo_despesa'         => $item['tipoDespesa'],
                        'tipo_documento'       => $item['tipoDocumento'],
                        'cod_tipo_documento'   => $item['codTipoDocumento'],
                        'data_documento'       => $item['dataDocumento'],
                        'num_documento'        => $item['numDocumento'],
                        'valor_documento'      => intval($item['valorDocumento'] * 100), // em centavos
                        'url_documento'        => $item['urlDocumento'],
                        'nome_fornecedor'      => $item['nomeFornecedor'],
                        'cnpj_cpf_fornecedor'  => $item['cnpjCpfFornecedor'],
                        'valor_liquido'        => intval($item['valorLiquido'] * 100),
                        'valor_glosa'          => intval($item['valorGlosa'] * 100),
                        'num_ressarcimento'    => $item['numRessarcimento'],
                        'cod_lote'             => $item['codLote'],
                        'parcela'              => $item['parcela'],
                    ]
                );
            }

            $page++;
        } while (isset($data['links']) && collect($data['links'])->contains(fn($l) => $l['rel'] === 'next'));
    }
}
