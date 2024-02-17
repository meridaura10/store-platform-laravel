<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show(Store $store)
    {
        $store->load('translations', 'image');
        return view('client.pages.store.show', compact('store'));
    }

    public function products(Store $store)
    {
        return view('client.pages.store.product.index', compact('store'));
    }
}
