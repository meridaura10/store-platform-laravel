<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\StoreUser;
use Illuminate\Http\Request;

class StoreUserController extends Controller
{
    public function index()
    {
        return view('store.pages.storeUser.index');
    }

    public function edit($store, StoreUser $storeUser)
    {
        $this->authorize('update', [$storeUser, $store]);
        return view('store.pages.storeUser.form', compact('storeUser'));
    }

    public function create($store, StoreUser $storeUser)
    {
        $this->authorize('create', [$storeUser, $store]);
        return view('store.pages.storeUser.form', compact('storeUser'));
    }
}
