<?php

namespace App\Services\NovaPoshta;

use App\Contracts\NovaPoshta\NovaPoshtaAddressLoaderInterface;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Http;

class WarehouseDataService extends NovaPoshtaAbstractLocationService
{
    public function fetchData($page, $perPage): array
    {
        $requestPayload = [
            "modelName" => "Address",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "Page" => $page,
                "Limit" => $perPage,
            ]
        ];

        return Http::post($this->getBaseUrl() . "Address/getWarehouses", $requestPayload)->json();
    }

    public function set(array $data)
    {
        Warehouse::updateOrCreate(
            [
                'id' => $data['Ref']
            ],
            [
                'title' => $data['Description'],
                'city_id' => $data['CityRef'],
            ]
        );
    }
}
