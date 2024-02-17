<div class="bg-sky-200 rounded-lg p-4">
    <div class="text-2xl mb-2 font-bold">
        Категорії
    </div>
    
    @include('livewire.store.models.category.tree.tree', ['categories' => $categories])
</div>