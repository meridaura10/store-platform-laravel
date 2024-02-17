<div class="form-control w-full max-w-xs">
    <label class="label">
        <span class="label-text">{{ $filter->title }}</span>
    </label>
    <input type="date" wire:model.live='f.{{ $filter->key }}' class="input input-bordered input-sm w-full max-w-xs">
  </div>
  