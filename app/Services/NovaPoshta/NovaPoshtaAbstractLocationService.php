<?php

namespace App\Services\NovaPoshta;

use App\Contracts\NovaPoshta\NovaPoshtaAddressLoaderInterface;

abstract class NovaPoshtaAbstractLocationService extends NovaPoshtaApi implements NovaPoshtaAddressLoaderInterface
{
    public function fetchTotalCount(): int
    {
        $response = $this->fetchData(1, 1);

        if (!isset($response['info']['totalCount'])) {
            return 0;
        }

        return $response['info']['totalCount'];
    }

    public function setMany(array $data)
    {
        foreach ($data as $warehouseData) {
            $this->set($warehouseData);
        }
    }
}
