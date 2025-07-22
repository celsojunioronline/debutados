<?php

namespace App\Jobs;

use App\Models\Deputado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SyncDespesasJob;
class SyncDeputadosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $page = 1;
            do {
                $response = Http::get('https://dadosabertos.camara.leg.br/api/v2/deputados', [
                    'pagina' => $page,
                    'itens' => 100
                ]);

                $data = $response->json();

                foreach ($data['dados'] as $item) {
                    $dep = Deputado::updateOrCreate(
                        ['id' => $item['id']],
                        [
                            'uri'           => $item['uri'],
                            'nome'          => $item['nome'],
                            'sigla_partido' => $item['siglaPartido'],
                            'sigla_uf'      => $item['siglaUf'],
                            'id_legislatura'=> $item['idLegislatura'],
                            'url_foto'      => $item['urlFoto'],
                            'email'         => $item['email'] ?? null,
                        ]
                    );

                    SyncDespesasJob::dispatch($dep->id);
                }

                $page++;
            } while (isset($data['links']) && collect($data['links'])->contains(fn($l) => $l['rel'] === 'next'));

        } catch (\Throwable $e) {
            \Log::error('Erro no SyncDeputadosJob: ' . $e->getMessage());
            throw $e; // Se o job falhar e registrar na fila
        }
    }
}
