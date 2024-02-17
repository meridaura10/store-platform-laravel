<?php

namespace Database\Seeders;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\Store\StoreStatuses;
use App\Models\Advertisement;
use App\Models\Moderation;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::factory(10)->create()->each(function (Store $store) {
            if ($store->moderation->status === ModerationStatusesEnum::Approved) {
                Product::factory(fake()->numberBetween(30, 50))->setStoreRelationId($store->id)->create();
            };
        });
    }
}
