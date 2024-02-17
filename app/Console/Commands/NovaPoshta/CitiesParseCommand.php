<?php

namespace App\Console\Commands\NovaPoshta;

use App\Jobs\NovaPoshta\Cities\StartParseCitiesJob;
use App\Jobs\NovaPoshta\CityJob;
use Illuminate\Console\Command;

class CitiesParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-poshta-parse:cities';

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
        dispatch(new StartParseCitiesJob());
    }
}
