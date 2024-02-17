<?php

namespace App\Console\Commands\NovaPoshta;

use App\Jobs\NovaPoshta\AreaJob;
use Illuminate\Console\Command;

class AreasParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-poshta-parse:areas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new AreaJob());
    }
}
