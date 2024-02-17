<div class="p-6">
    @include('admin.components.product.show', compact('product'))

    @component('ui.card')
        <div class="flex justify-between">
            <div>
                <select wire:model.live="selectedStatus">
                    @foreach ($statuses as $status)
                        <option  value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <span class="text-lg font-semibold">нинішній статус модерації:</span> <span
                    class="text-xl font-bold">{{ $product->moderation->status }}</span>
            </div>
        </div>
    @endcomponent
</div>
