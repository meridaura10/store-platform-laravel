<?php

namespace App\Console\Commands;

use App\Jobs\CheckStatusPaymentJob;
use Illuminate\Console\Command;

class CheckStatusPaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check-status';

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
        dispatch(new CheckStatusPaymentJob());
    }
}
