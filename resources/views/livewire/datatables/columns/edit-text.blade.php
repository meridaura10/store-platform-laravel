<button class="flex items-center gap-1 btn btn-secondary btn-sm" wire:click='actionEditField("{{ $column->key }}",{{ $item }})'>
    <div>
        <i class="ri-pencil-line"></i>
    </div>
    <div>
        {{ $column->value($item) }}
    </div>
</button>
