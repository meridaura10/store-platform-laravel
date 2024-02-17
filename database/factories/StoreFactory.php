<?php

namespace Database\Factories;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\Store\StoreStatusEnum;
use App\Enums\Store\StoreStatuses;
use App\Enums\User\UserStoreRoleEnum;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreUser;
use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => 1,
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
        ];
    }

    public function configure()
    {
        $langs = localization()->getSupportedLocales();
        $images = Storage::files('testImages/shops');

        return $this->afterCreating(function (Store $shop) use ($langs, $images) {

            $shop->moderation()->create([
                // 'status' => fake()->boolean() ? ModerationStatusesEnum::Approved : ModerationStatusesEnum::Now,
                'status' => ModerationStatusesEnum::Approved,
            ]);

            $shop->image()->create([
                'path' => $images[fake()->numberBetween(0, count($images) - 1)],
                'order' => 0,
                'disk' => 'local',
            ]);


            foreach ($langs as $lang) {
                $faker = Faker::create($lang->regional());
                $shop->update([
                    $lang->key() => [
                        'title' => $faker->word(),
                        'description' =>  $faker->realText(200),
                    ]
                ]);
            }
        });
    }
}
