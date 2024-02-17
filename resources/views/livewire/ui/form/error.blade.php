<div>
    @error($model)
        <label class="label">
            <span class="text-{{ isset($size) ? $size : 'sm' }}  text-error">{{ $message }}</span>
        </label>
    @endError
</div>