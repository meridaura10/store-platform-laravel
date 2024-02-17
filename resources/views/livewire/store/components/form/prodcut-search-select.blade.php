<div>
    <div x-data="{ isOpen: false }" class="relative w-full max-w-[600px]">
        <div class="relative">
            <button @click="isOpen = !isOpen" type="button" class="btn btn-light w-full rounded-t-md rounded-md"
                :class="{ 'rounded-none': isOpen }">
                {{ $selected ? $selected[$fillables['title']] : $label }}
            </button>
            <div x-show="isOpen" @click.away="isOpen = false"
                class="absolute w-full bg-white border shadow-xl rounded-b-lg  z-10">
                <div class="">
                    <div class="p-2 border-b">
                        <input wire:model.live.debounce.300ms="searchQuery" type="text" class="form-input w-full"
                            placeholder="Search...">
                    </div>
                    <ul class="max-h-48 overflow-y-auto">
                        @foreach ($options as $option)
                            <li class="w-full flex items-center justify-between px-2">
                                <div class="w-10 h-10">
                                    <img src="{{ $option['image']['url'] }}" alt="">
                                </div>
                                <div @click="isOpen = false" wire:click="save({{ json_encode($option) }})"
                                    class="
                                    @if ($selected && $selected[$fillables['value']] === $option->{$fillables['value']}) bg-gray-200 hover:bg-gray-300 @endif
                                    px-4 w-full py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer
                                    ">
                                    {{ $option->{$fillables['title']} }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
