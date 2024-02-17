<?php

namespace App\Livewire\Admin\Models\Product;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Models\Product;
use Livewire\Component;

class Moderation extends Component
{
    public Product $product;

    public $selectedStatus;

    public $statuses = [];

    public function mount(Product $product)
    {
        $this->product = $product->load('translations', 'images', 'categories.translations', 'moderation');
        $this->selectedStatus = $product->moderation->status;
        $this->statuses = ModerationStatusesEnum::values();
    }
    public function updatedSelectedStatus($value)
    {
        $this->product->moderation->update(['status' => $value]);
    }

    public function render()
    {
        return view('livewire.admin.models.product.moderation');
    }
}
