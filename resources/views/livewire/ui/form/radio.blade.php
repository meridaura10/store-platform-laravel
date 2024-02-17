<label class="flex gap-2 items-center cursor-pointer">

    <input type="radio" value="{{ $value }}"
        @if (isset($isLive) && $isLive) wire:model.live="{{ $model }}"
    @else 
    wire:model="{{ $model }}" @endif
        class="radio checked:bg-red-500" checked />
    <span class="label-text mr-2">{{ $label }}</span>
</label>
