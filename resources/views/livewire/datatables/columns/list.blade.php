<div>
    @forelse  ($column->value($item) as $key => $value)
        {{ $value }}
        @if ($key + 1 < $column->count($column->value($item)))
            , <br>
        @endIf

    @empty
        -
    @endforelse
</div>
