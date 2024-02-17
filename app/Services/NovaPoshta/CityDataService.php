<?php

namespace App\Services\NovaPoshta;

use App\Models\City;
use Illuminate\Support\Facades\Http;

class CityDataService extends NovaPoshtaAbstractLocationService 
{
   public function fetchData(int $page, int $perPage): array
    {
        $requestPayload = [
            "modelName" => "Address",
            "calledMethod" => "getCities",
            "methodProperties" => [
                "Page" => $page,
                "Limit" => $perPage,
            ]
        ];

        return Http::post($this->getBaseUrl() . "Address/getCities", $requestPayload)->json();
    }

    public function set($data)
    {
        City::updateOrCreate(
            [
                'id' => $data['Ref']
            ],
            [
                'title' => $data['Description'],
                'area_id' => $data['Area'],
            ]
        );
    }
}
