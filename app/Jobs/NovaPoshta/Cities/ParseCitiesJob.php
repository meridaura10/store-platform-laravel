<?php

namespace App\Jobs\NovaPoshta\Cities;

use App\Services\NovaPoshta\CityDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseCitiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $page;
    protected $perPage;

    public function __construct($page, $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }


    public function handle(CityDataService $service): void
    {
        $response = $service->fetchData($this->page, $this->perPage);

        if (!$response['data']) {
            return;
        }

        $service->setMany($response['data']);
    }
}
