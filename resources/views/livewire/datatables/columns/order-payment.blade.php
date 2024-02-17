<div>
    <div>
        ціна: {{ $column->value($item)->amount }}
    </div>
    <div>
        статус: {{ $column->value($item)->status }}
    </div>
    <div>
        тип: {{ $column->value($item)->type }}
    </div>
    <div>
        система: {{ $column->value($item)->system }}
    </div>
    <div>
        крайній час оплати: {{ $column->value($item)->payment_expired_time ?? '-' }}
    </div>
</div>
