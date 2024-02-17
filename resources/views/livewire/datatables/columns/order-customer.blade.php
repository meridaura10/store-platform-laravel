<div>
    <div>
      ім`я: {{ $column->value($item)->first_name }}
    </div>
    <div>
       фамілія:  {{ $column->value($item)->last_name }}
    </div>
    <div>
       по батькові: {{ $column->value($item)->patronymics }}
    </div>
    <div>
       телефон: {{ $column->value($item)->phone }}
    </div>
</div>
