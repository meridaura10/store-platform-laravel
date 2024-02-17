<div id="{{ $id ?? '' }}" x-data='{ activeTab: {{ localization()->getDefaultLocale() }}}'>
    <div class="text-sm font-medium text-center">
        <ul class="flex flex-wrap -mb-px">
            @foreach (localization()->getSupportedLocalesKeys() as $lang)
                <li x-bind:class="activeTab === {{ $lang }} ? 'text-blue-600 border-b-2 border-blue-600' :
                    'text-gray-400 border-gray-200 border-b-2'"
                    x-on:click.prevent="activeTab = {{ $lang }}" id="{{ $lang }}" class="me-2">
                    <a href="#" class="inline-block p-4 rounded-t-lg">
                        {{ $lang }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tabs">

    </div>

    @foreach (localization()->getSupportedLocalesKeys() as $lang)
        <div x-show="activeTab === {{ $lang }}">
            @foreach ($fields as $field)
                @include('livewire.ui.form.' . $field['type'], [
                    'id' => isset($id) ? $id . $lang : 'input',
                    'label' => trans('base.form.' . $field['name']),
                    'model' => "form.translations.$lang." . $field['name'],
                ])
            @endforeach
        </div>
    @endforeach
</div>
