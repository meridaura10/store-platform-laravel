<?php

namespace App\Services\NovaPoshta;


class NovaPoshtaApi
{
    private ?string $baseUrl = null;

    public function __construct()
    {
        $this->baseUrl = 'https://api.novaposhta.ua/v2.0/json/';
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
