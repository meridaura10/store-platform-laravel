<?php

namespace App\Jobs\NovaPoshta\Warehouses;

use App\Services\NovaPoshta\WarehouseDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseWarehousesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $page;
    protected $perPage;

    public function __construct($page, $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }


    public function handle(WarehouseDataService $warehouseDataService): void
    {
        $response = $warehouseDataService->fetchData($this->page, $this->perPage);

        if (!$response['data']) {
            return;
        }

        $warehouseDataService->setMany($response['data']);
    }
}
