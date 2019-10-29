<?php

namespace Raffles\Console\Commands;

use Raffles\Modules\Poga\UseCases\GenerarPagares;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GenerarPagaresRenta extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poga:generar:pagares';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera Pagares de Renta';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->dispatchNow(new GenerarPagares());
    }
}
