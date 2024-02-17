<?php

use App\Services\BasketService;


if (! function_exists('basket')) {
    function basket()
    {
        return resolve(BasketService::class);
    }
}


