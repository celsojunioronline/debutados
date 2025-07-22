<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncDeputadosJob;

class SincronizarDeputados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:deputados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza deputados e suas despesas';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Iniciando sincronização...');
        SyncDeputadosJob::dispatch();
        $this->info('Job enfileirado com sucesso');
    }
}
