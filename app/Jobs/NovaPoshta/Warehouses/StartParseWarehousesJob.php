<?php

namespace App\Jobs\NovaPoshta\Warehouses;

use App\Services\NovaPoshta\WarehouseDataService;
use App\Services\NovaPoshta\WarehouseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartParseWarehousesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $perPage = 0;

    public function __construct()
    {
        $this->perPage = 100;
    }

    public function handle(WarehouseDataService $warehouseDataService): void
    {
        $totalCount = $warehouseDataService->fetchTotalCount();

        $totalPages = ceil($totalCount / $this->perPage);

        for ($page = 1; $page <= $totalPages; $page++) {
            dispatch((new ParseWarehousesJob($page, $this->perPage))->onQueue("low"));
        }

    }
}
