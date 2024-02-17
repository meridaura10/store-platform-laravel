<?php

namespace App\Console\Commands\NovaPoshta;

use App\Jobs\NovaPoshta\Cities\StartParseCitiesJob;
use App\Jobs\NovaPoshta\CityJob;
use App\Jobs\NovaPoshta\Warehouses\StartParseWarehousesJob;
use Illuminate\Console\Command;

class WarehousesParseCommand extends Command
{
 
    protected $signature = 'nova-poshta-parse:warehouses';

    protected $description = 'Command description';

    public function handle()
    {
        dispatch(new StartParseWarehousesJob());
    }
}
