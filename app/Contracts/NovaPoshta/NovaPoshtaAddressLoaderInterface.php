<?php 

namespace App\Contracts\NovaPoshta;

interface NovaPoshtaAddressLoaderInterface{
    public function fetchData(int $page,int $perPage): array;

    public function fetchTotalCount(): int;

    public function setMany(array $data);

    public function set(array $data);
}