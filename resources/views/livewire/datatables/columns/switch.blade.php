<input type="checkbox" wire:click="switchChange('{{ $column->key }}', '{{ $item->id }}')" @if ($column->value($item)) checked @endif value="1"  class="toggle toggle-sm" id="{{ $column->key.$item->id }}">