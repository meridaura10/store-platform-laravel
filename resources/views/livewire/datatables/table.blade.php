<div class="overflow-x-auto p-6">
    @livewire('datatables.utils.modal-confirm')
    @livewire('datatables.utils.modal-edit-field')    
    <div class="mb-4">
        @component('ui.card')
            <div class="flex justify-between items-center">
                @if ($this->hasCreatedLink())
                    <a href="{{ $this->getCreatedLink() }}">
                        <button class="btn btn-accent btn-sm">
                            <i class="ri-add-line"></i>
                        </button>
                    </a>
                @endif
                <div>
                    <h1 class="font-bold text-xl">
                        {{ $this->getTitle() }}
                    </h1>
                </div>
                <div>

                    <button @if (!$this->hasFilter()) disabled @endif class="btn" wire:click="clearFilter">
                        скинути фільтри
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 items-center justify-center md:grid-cols-2 xl:grid-cols-4 lg:grid-cols-3">
                @foreach ($filters as $filter)
                    {!! $filter->render($this) !!}
                @endforeach
            </div>
            @if ($this->hasTabs())
                <ul
                    class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400  mt-3  rounded-lg">
                    @foreach ($tabs as $tab)
                        <li wire:click="selectTab('{{ $tab->key }}')" class="me-2 cursor-pointer">
                            <div
                                class="inline-block px-4 py-3 text-white  rounded-lg @if ($this->tabActive($tab)) bg-blue-600 @else bg-blue-300 @endIf">
                                {{ $tab->title }}
                            </div>
                        </li>
                    @endforeach
                    <li wire:click="selectTab()" class="me-2 cursor-pointer">
                        <div
                            class="inline-block px-4 py-3 text-white rounded-lg @if (!$this->hasSelectedTab()) bg-blue-600 @else bg-blue-300 @endIf">
                            Всі
                        </div>
                    </li>
                </ul>
            @endif
        @endcomponent
    </div>



    <div class="overflow-x-auto">
        @component('ui.card')
            <table class="table w-full">
                <thead>
                    <tr class="select-none">
                        @foreach ($columns as $column)
                            <th
                                @if ($column->sortable) wire:click="sortByNext('{{ $column->key }}')"
                             class="cursor-pointer" @endif>
                                {{ $column->title }}

                                @if ($column->sortable)
                                    @if ($sortKey == $column->key)
                                        @if ($sortDirection)
                                            <i class="ri-arrow-up-line"></i>
                                        @else
                                            <i class="ri-arrow-down-line"></i>
                                        @endif
                                    @else
                                        <i class="ri-arrow-up-down-line"></i>
                                    @endif
                                @endif
                            </th>
                        @endforeach

                        @if ($this->hasActions())
                            <th class="text-right">дії</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="hover" wire:key="{{ $item->id }}">
                            @foreach ($columns as $column)
                                <td>
                                    {!! $column->render($item) !!}
                                </td>
                            @endforeach

                            @if ($this->hasActions())
                                <td>
                                    <div class="flex justify-end">
                                        <div class="join-item">
                                            @foreach ($actions as $action)
                                                <button wire:click="action('{{ $action->key }}', '{{ $item->id }}')">

                                                    {!! $action->render($item) !!}

                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endcomponent
        @if ($usePagination)
            <div class="mt-4">
                @component('ui.card')
                    <div class="flex justify-between items-end p-2 ">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">{{ trans('base.table.per_page') }}</span>
                            </label>
                            <select class="select select-bordered w-full max-w-xs" wire:model.live="perPage">
                                @foreach ($perPages as $perPageOption)
                                    <option value={{ $perPageOption }}
                                        @if ($perPageOption == $perPage) class="selected" @endif>
                                        {{ $perPageOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            {{ $items->links() }}
                        </div>
                    </div>
                @endcomponent
            </div>
        @endif
    </div>
</div>
