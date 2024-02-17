<?php

namespace App\Services\Payment\Api;

use Cloudipsp\Configuration;

class FondyApiService
{
    public function __construct()
    {
        Configuration::setMerchantId(config('fondy.merchantId'));
        Configuration::setSecretKey(config('fondy.secretKey'));
    }
}
