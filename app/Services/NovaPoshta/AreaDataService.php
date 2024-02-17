<?php

namespace App\Services\NovaPoshta;

use App\Models\Area;
use Illuminate\Support\Facades\Http;

class AreaDataService extends NovaPoshtaAbstractLocationService
{

    public function fetchData(int $page, int $perPage): array
    {
        $requestPayload = [
            "modelName" => "Address",
            "calledMethod" => "getAreas",
        ];

        return Http::post($this->getBaseUrl() . "Address/getAreas", $requestPayload)->json();
    }

    public function set($data)
    {
        Area::updateOrCreate(
            [
                'id' => $data['Ref']
            ],
            [
                'title' => $data['Description'],
            ]
        );
    }
}
