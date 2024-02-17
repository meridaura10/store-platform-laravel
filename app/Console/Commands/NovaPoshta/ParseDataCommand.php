<?php

namespace App\Console\Commands\NovaPoshta;

use Illuminate\Console\Command;

class ParseDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-poshta:parse';

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
        $this->call('nova-poshta-parse:areas');
        $this->call('nova-poshta-parse:cities');
        $this->call('nova-poshta-parse:warehouses');
    }
}
