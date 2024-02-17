<?php

namespace App\Livewire\Client\Models\Category;

use App\Models\Category;
use Livewire\Component;

class Index extends Component
{
    private $categories;
    public function mount()
    {
        $this->categories = cache()->remember('client_categories', now()->addDay(), function () {
            return Category::whereNull('parent_id')
                ->with('translations', 'image')
                ->get();    
        });
    }
    public function render()
    {
        return view('livewire.client.models.category.index', [
            'categories' => $this->categories,
        ]);
    }
}
