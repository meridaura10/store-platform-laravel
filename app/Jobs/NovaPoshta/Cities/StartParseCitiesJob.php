<?php

namespace App\Jobs\NovaPoshta\Cities;

use App\Services\NovaPoshta\CityDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartParseCitiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $perPage = 0;

    public function __construct()
    {
        $this->perPage = 100;
    }

    public function handle(CityDataService $service): void
    {
        $totalCount = $service->fetchTotalCount();

        $totalPages = ceil($totalCount / $this->perPage);

        for ($page = 1; $page <= $totalPages; $page++) {
            dispatch((new ParseCitiesJob($page, $this->perPage))->onQueue("low"));
        }
    }
}
