<?php

namespace App\Jobs;

use App\Models\Deputado;
use App\Models\Ocupacao;
use App\Models\Profissao;
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

    public function __construct()
    {
        //
    }

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
                    // ===> Detalhes do deputado
                    $detalhes = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$item['id']}")->json()['dados'];

                    $dep = Deputado::updateOrCreate(
                        ['id' => $item['id']],
                        [
                            'uri'                => $item['uri'],
                            'nome'               => $item['nome'],
                            'sigla_partido'      => $item['siglaPartido'],
                            'sigla_uf'           => $item['siglaUf'],
                            'id_legislatura'     => $item['idLegislatura'],
                            'url_foto'           => $item['urlFoto'],
                            'email'              => $detalhes['ultimoStatus']['gabinete']['email'] ?? null,
                            'nome_civil' => $detalhes['nomeCivil'] ?? null,
                            'data_nascimento' => $detalhes['dataNascimento'] ?? null,
                            'municipio_nascimento' => $detalhes['municipioNascimento'] ?? null,
                            'uf_nascimento' => $detalhes['ufNascimento'] ?? null,
                        ]
                    );

                    // ===> Ocupações
                    $ocupacoes = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$item['id']}/ocupacoes")->json()['dados'];
                    $dep->ocupacoes()->delete(); // limpa antigas
                    foreach ($ocupacoes as $ocup) {
                        $dep->ocupacoes()->create([
                            'titulo'     => $ocup['titulo'] ?? '-',
                            'entidade'   => $ocup['entidade'] ?? '-',
                            'ano_inicio' => $ocup['anoInicio'] ?? null,
                            'ano_fim'    => $ocup['anoFim'] ?? null,
                        ]);
                    }

                    // ===> Profissões
                    $profissoes = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$item['id']}/profissoes")->json()['dados'];
                    $dep->profissoes()->delete(); // limpa antigas
                    foreach ($profissoes as $prof) {
                        $dep->profissoes()->create([
                            'descricao' => $prof['titulo'] ?? '-',
                        ]);
                    }

                    // ===> Dispara despesas
                    SyncDespesasJob::dispatch($dep->id);
                }

                $page++;
            } while (isset($data['links']) && collect($data['links'])->contains(fn($l) => $l['rel'] === 'next'));

        } catch (\Throwable $e) {
            \Log::error('Erro no SyncDeputadosJob: ' . $e->getMessage());
            throw $e;
        }
    }
}
