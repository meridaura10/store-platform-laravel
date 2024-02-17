<dialog id="modal" class="modal" @if ($open) open @endif>
    <div class="w-screen h-screen relative  bg-base-content opacity-40">
    </div>
    @if ($item)
        <form method="dialog"
            class="modal-box absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
            <h3 class="font-bold text-lg">{{ $title }}</h3>
            <p>{{ $description }}</p>
            <div class="text-gray-500 font-bold">
                можна зміниит на:
            </div>
            <div class="my-5 flex gap-2 flex-wrap">
                @foreach ($values as $value)
                    <button wire:click='save("{{ $value }}")' class="btn btn-primary">
                        {{ $value }}
                    </button>
                @endforeach
            </div>
            <div class="flex justify-between items-center">
                <div class="font-semibold">
                    зараз: <span class="font-bold">{{ $this->value() }}</span>
                </div>
                <button class="btn">Close</button>
            </div>
        </form>
    @endif
</dialog>
