<div class="dropdown">
    <div tabindex="0" role="button" class="btn m-1">
        Theme
        <svg width="12px" height="12px" class="h-2 w-2 fill-current opacity-60 inline-block"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2048 2048">
            <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
        </svg>
    </div>
    <ul tabindex="0" class="dropdown-content z-[1] p-2 shadow-2xl bg-base-300 rounded-box w-52">
        @foreach ($themes as $key => $theme)
            <li wire:key='themes.{{ $key }}.item'>
                <input type="radio" name="theme-dropdown" wire:input='switch("{{ $theme }}")'
                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                    @if ($theme === $active) checked @endif aria-label="{{ $theme }}"
                    value="{{ $theme }}" />
            </li>
        @endforeach
    </ul>
</div>
