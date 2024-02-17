<div class="form-control w-full {{ $style ?? '' }}">
    @if (isset($label))
        <label class="label" id="{{ $id ?? ($name ?? $model) }}">
            <span class="label-text  {{ $styleLabelText ?? '' }}">{{ $label }}</span>
        </label>
    @endif
    <input type="{{ $type ?? 'text' }}" id="{{ $id ?? ($name ?? $model) }}" placeholder="{{ $placeholder ?? 'Type here' }}"
        class="input input-bordered @error($model) input-error @enderror w-full" wire:model={{ $model }}
        wire:loading.attr="disabled"
        @if (isset($wireInput)) wire:loading.attr="disabled" wire:model.debounce.500ms="{{ $wireInput }}" @endif />


    @include('livewire.ui.form.error', [
        'model' => $model,
    ])

</div>
