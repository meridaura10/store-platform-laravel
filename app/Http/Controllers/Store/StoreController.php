<?php

namespace App\Http\Controllers\Store;

use App\Enums\User\UserRightTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($storeId)
    {
        $store = Store::query()->with('image', 'translations')->find($storeId);
        $this->authorize('view', [$store, UserRightTypeEnum::Store]);
        return view('store.pages.store.show', compact('store'));
    }

    public function edit($storeId)
    {
        $store = Store::find($storeId);
        $this->authorize('update', [$store, UserRightTypeEnum::Store]);
        return view('store.pages.store.edit', compact('store'));
    }
}
