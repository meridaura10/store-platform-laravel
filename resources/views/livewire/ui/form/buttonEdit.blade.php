<div class="flex items-center gap-2 hover:text-red-400 hover:fill-red-400 fill-blue-600 text-blue-600 " @if (isset($click))
wire:click="{{ $click }}"
@endif>
    <div><svg xmlns="http://www.w3.org/2000/svg" class="transition-colors"  viewBox="0 0 24 24" width="32"
            height="32">
            <path
                d="M16.7574 2.99666L14.7574 4.99666H5V18.9967H19V9.2393L21 7.2393V19.9967C21 20.5489 20.5523 20.9967 20 20.9967H4C3.44772 20.9967 3 20.5489 3 19.9967V3.99666C3 3.44438 3.44772 2.99666 4 2.99666H16.7574ZM20.4853 2.09717L21.8995 3.51138L12.7071 12.7038L11.2954 12.7062L11.2929 11.2896L20.4853 2.09717Z">
            </path>
        </svg></div>
    <div>
        <span class="transition-colors font-bold">Редагувати</span>
    </div>
</div>