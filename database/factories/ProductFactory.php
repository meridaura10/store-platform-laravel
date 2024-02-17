<?php

namespace Database\Factories;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => str()->slug(fake()->text()),
            'price' => fake()->numberBetween(25, 10000),
            'quantity' => fake()->numberBetween(5, 100),
            'status' => 1,
        ];
    }

    public function configure()
    {
        $images = Storage::files('testImages/products');
        $langs = localization()->getSupportedLocales();

        return $this->afterCreating(function (Product $product) use ($langs, $images) {

            $product->moderations()->create([
                'status' => fake()->numberBetween(2, 4) % 2 === 0 ? ModerationStatusesEnum::Approved : ModerationStatusesEnum::Now,
            ]);

            for ($i = 0; $i < fake()->numberBetween(1, 4); $i++) {
                $product->image()->create([
                    'path' => $images[fake()->numberBetween(0, count($images) - 1)],
                    'order' => $i,
                    'disk' => 'local',
                ]);
            }

            foreach ($langs as $lang) {
                $faker = Faker::create($lang->regional());
                $product->update([
                    $lang->key() => [
                        'title' => $faker->realText(60),
                        'description' =>  $faker->realText(200),
                    ]
                ]);
            }
        });
    }

    public function setStoreRelationId($store_id): Factory
    {
        return $this->state(fn () => [
            'store_id' => $store_id,
        ]);
    }

}

   
