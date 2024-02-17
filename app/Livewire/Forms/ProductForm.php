<?php

namespace App\Livewire\Forms;

use App\Enums\Advertisement\AdvertisementStatuses;
use App\Models\Advertisement;
use App\Models\Product;
use App\Traits\FillModelFormTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{
    use FillModelFormTrait;

    public Product $product;

    public $price = 0;

    public $quantity = 0;

    public $status = true;

    public $translations = [];


    public $categories = [];

    public $store_id = null;

    public $images = [];

    public $newImages = [];


    public function init(Product $product)
    {
        $this->initForm($product, ['status', 'price', 'quantity', 'images'], 'product');
        $this->categories = $product->categories->pluck('id')->toArray();
        $this->store_id = request()->route('store');
        $this->translations = $product->getTranslationsArray();
    }

    public function rules()
    {
        $rules = [
            'status' => ['required', 'boolean'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:1'],
        ];

        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.title"] = [$defaultRule, 'string', 'max:190'];
            $rules["translations.$lang.description"] = [$defaultRule, 'string', 'max:480'];
        }

        $rulesToRequiredNewImages = [
            'newImages.orders' => ['required', 'array'],
            'newImages' => ['required', 'array'],
            'newImages.images.*' => ['required'],
        ];

        if (array_key_exists('images', $this->newImages)) {
            foreach (array_keys($this->newImages['images']) as $key) {
                $rulesToRequiredNewImages["newImages.orders.$key"] = ['required', 'min:0'];
            }
        }

        if (count($this->newImages['images'])) {
            $rules =  array_merge($rules, $rulesToRequiredNewImages);
        } else {
            $rules['newImages.orders'] = ['nullable'];
            $rules['newImages'] = ['nullable', 'array'];
            $rules['newImages.images.*'] = ['nullable', 'image'];
            $rules['newImages.orders.*'] = ['nullable', 'min:0'];
        }

        if (count($this->images)) {
            $rules['images'] = ['required'];
            $rules['images.*.order'] = ['required', 'numeric', 'min:0'];
        } else {
            $rules =  array_merge($rules, $rulesToRequiredNewImages);
        }



        return $rules;
    }

    public function removeImage($key, $flag)
    {
        if ($flag) {
            unset($this->images[$key]);
        } else {
            unset($this->newImages['images'][$key]);
            unset($this->newImages['orders'][$key]);
        }
    }

    private function saveImages(Product $product)
    {
        $imagesToNotDelete = array_map(function ($item) use ($product) {

            $imageToUpdate = $product->images()->find($item['id']);

            $imageToUpdate->update($item);

            return $item['id'];
        }, $this->images);

        $product->images()->whereNotIn('id', $imagesToNotDelete)->delete();

        if (!count($this->newImages)) {
            return;
        };

        foreach ($this->newImages['images'] as $key => $image) {
            $path = $image->store("products/$product->id");
            $product->images()->create([
                'order' => (int) $this->newImages['orders'][$key],
                'path' => $path,
                'disk' => 'local',
            ]);
        }
    }

    public function save()
    {
        $this->validate();

        $this->exactFillModel(['status', 'price', 'quantity'], 'product');

        $this->product->slug = str()->slug($this->translations[localization()->getDefaultLocale()]['title']);

        $this->product->save();

        $this->product->update($this->translations);

        $this->product->categories()->sync($this->categories);

        $this->saveImages($this->product);
    }

}
