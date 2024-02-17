<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'status' => 1,
            'slug' => $this->faker->slug,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            $imagesRoot = Storage::files('testImages/categories');
            $langs = localization()->getSupportedLocales();

            foreach ($langs as $lang) {
                $faker = Faker::create($lang->regional());
                $category->translateOrNew($lang->key())->title = $faker->realText(15);
            }

            for ($i = 0; $i < 3; $i++) {
                $subCategory = $category->subcategories()->create([
                    'status' => 1,
                    'slug' => $this->faker->slug,
                ]);

                $subCategory->image()->create([
                    'order' => 0,
                    'disk' => 'local',
                    'path' => $imagesRoot[array_rand($imagesRoot)],
                ]);

                foreach ($langs as $lang) {
                    $faker = Faker::create($lang->regional());
                    $subCategory->translateOrNew($lang->key())->title = $faker->realText(15);
                }

                $subCategory->save();

                for ($j = 0; $j < 4; $j++) {
                    $jsubSubCategory = $subCategory->subcategories()->create([
                        'status' => 1,
                        'slug' => $this->faker->slug,
                    ]);

                    $jsubSubCategory->image()->create([
                        'order' => 0,
                        'disk' => 'local',
                        'path' => $imagesRoot[array_rand($imagesRoot)],
                    ]);

                    foreach ($langs as $lang) {
                        $faker = Faker::create($lang->regional());
                        $jsubSubCategory->translateOrNew($lang->key())->title = $faker->realText(15);
                    }

                    $jsubSubCategory->save();
                }
            }

            $category->image()->create([
                'order' => 0,
                'disk' => 'local',
                'path' => $imagesRoot[array_rand($imagesRoot)],
            ]);

            $category->save();
        });
    }
}
