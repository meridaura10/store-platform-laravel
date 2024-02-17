<div>
    <button class='btn {{ $styles ?? "btn-accent" }}' type="{{ isset($type) ? $type : 'button' }}">
        {{ $slot ?? trans('base.save') }}
    </button>
</div>
