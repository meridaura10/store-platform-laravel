<?php

namespace App\Jobs\NovaPoshta;

use App\Services\NovaPoshta\AreaDataService;
use App\Services\NovaPoshta\AreaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AreaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function handle(AreaDataService $service): void
    {
        $response = $service->fetchData(1, 100);

        if (!$response['data']) {
            return;
        }

        $service->setMany($response['data']);
    }
}
