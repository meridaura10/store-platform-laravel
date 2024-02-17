<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class UserCabinetStoreController extends Controller
{
    public function index()
    {
        return view('client.pages.user.cabinet.store.index');
    }

    public function create(Store $store){
        return view('client.pages.user.cabinet.store.create',compact('store'));
    }
}
