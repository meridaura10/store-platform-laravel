<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldBasketsJob;
use Illuminate\Console\Command;

class DeleteOldBasketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basket:delete-old';

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
        dispatch(new DeleteOldBasketsJob());
    }
}
