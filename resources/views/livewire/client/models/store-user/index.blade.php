<div class="container mx-auto px-4">
    @forelse ($userStores as $userStore)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg my-4">
            <div class="px-4 py-5 sm:px-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl leading-6 font-medium text-gray-900">
                        {{ $userStore->store->title }}
                    </h2>
                    <div class="h-12">
                        <img class="h-full object-contain" src="{{ $userStore->store->image->url }}" alt="">
                    </div>

                </div>

                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ $userStore->store->description }}
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Ваші права:
                </dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @foreach ($userStore->roles as $key => $role)
                        {{ $role->title }}
                        @if ($key + 1 < $userStore->roles->count())
                            ,
                        @endIf
                    @endforeach
                </dd>
            </div>
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                <div class="flex justify-between items-center">
                    @if ($userStore->store->moderation->isApproved)
                        <div>
                            <a href="{{ route('store.admin.home', $userStore->store->id) }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Перейти до адмін панелі
                            </a>
                        </div>
                    @endif
                    <div>
                        <div>
                            <span class="">Статус модерації:</span> <span
                                class="font-semibold">{{ $userStore->store->moderation->status }}</span>
                        </div>
                        <div>
                            <span class="">Статус:</span> <span
                                class="font-semibold">{{ $userStore->store->status ? 'активний' : 'не активний' }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @empty
        <div class="text-lg font-semibold text-center mt-8">
            <p>У вас ще не має жодного магазину</p>

        </div>
    @endforelse
</div>
