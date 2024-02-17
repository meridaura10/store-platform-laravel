<?php

namespace App\Livewire\Store\Models\Product;

use App\Livewire\Forms\ProductForm;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public ProductForm $form;

    public $categories;

    public function mount(Product $product)
    {
        $this->categories = Cache::remember('categories', 60 * 60 * 60, function () {
            return Category::query()
                ->whereNull('parent_id')
                ->with(['translations', 'image', 'subcategories.translations', 'subcategories.image'])
                ->get()
                ->toArray();
        });

        $this->form->init($product);
    }

    public function save()
    {
        $this->form->save();
    }

    public function removeImage($key,$flag){
        $this->form->removeImage($key,$flag);
    }

    function countSelectedSubcategories($category, $selectedCategories) {
        $count = count(array_intersect(array_column($category['subcategories'], 'id'), $selectedCategories));
    
        foreach ($category['subcategories'] as $subcategory) {
            $count += $this->countSelectedSubcategories($subcategory, $selectedCategories);
        }
    
        return $count;
    }

    public function render()
    {
        return view('livewire.store.models.product.form');
    }
}
