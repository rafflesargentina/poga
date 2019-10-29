<?php

namespace Raffles\Console\Commands;

use Raffles\Modules\Poga\UseCases\GenerarMultas;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GenerarMultasRenta extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poga:generar:multas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera Multas de Rentas';

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
        $this->dispatchNow(new GenerarMultas());
    }
}
