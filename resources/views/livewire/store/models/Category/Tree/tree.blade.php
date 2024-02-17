<ul class="border-t-2 border-r-2 border-transparent transition-all grid gap-2 py-2 rounded-lg">
    @foreach ($categories as $category)
        @if (count($category['subcategories']) > 0)
            <li x-data="{ open: false }" class="hover:bg-blue-200 hover:border-blue-300">
                <div class="flex gap-2 mb-2 items-center cursor-pointer" @click="open = !open">
                    <i x-bind:class="open ? 'ri-arrow-right-s-line' : 'ri-arrow-down-s-line'" class="text-xl"></i>
                    <span class="font-semibold pl-2 text-lg">{{ $category['title'] }}
                        ({{ $this->countSelectedSubcategories($category,$form->categories) }})
                    </span>
                    <div class="w-8 h-8">
                        <img class="w-full h-full" src="{{ $category['image']['url'] }}" alt="image to category">
                    </div>
                </div>
                <ul class="border-l-4 border-b-[3px] border-white pl-4" x-show="open">
                    @include('livewire.store.models.category.tree.tree', [
                        'categories' => $category['subcategories'],
                    ])
                </ul>
            </li>
        @else
            <li class="mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-8 items-center h-8">
                        <img class="w-full h-full" src="{{ $category['image']['url'] }}" alt="image to category">
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">
                                <div class="mr-2">
                                    <p class="">{{ $category['title'] }}</p>
                                </div>
                            </span>
                            <input value="{{ $category['id'] }}" wire:model.live='form.categories' type="checkbox"
                                checked="checked" class="checkbox checkbox-accent" />
                        </label>
                    </div>
                </div>
            </li>
        @endif
    @endforeach
</ul>
