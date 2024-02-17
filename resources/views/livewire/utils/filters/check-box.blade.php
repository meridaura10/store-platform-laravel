<ul>
    @foreach ($filter->getValues() as $key => $value)
        <li wire:key='{{ $key . $value }}' class="form-control ">
            <div class="flex items-center pl-3">
                <input wire:loading.attr="disabled" wire:model.live="f.{{ $filter->key }}"
                    id="check-box.{{ $filter->key }}.{{ $key }}" type="checkbox" value="{{ $key }}"
                    class="checkbox checkbox-accent">

                <label for="vue-checkbox"
                    class="w-full py-3 ml-2 text-sm font-medium text-gray-900 :text-gray-300">{{ $value }}</label>
            </div>
        </li>
    @endforeach
</ul>
