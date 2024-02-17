<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('store.pages.role.index');
    }

    public function edit($storeId, Role $role)
    {
        $this->authorize('update', [$role, $storeId]);
        return view('store.pages.role.form', compact('role'));
    }

    public function create($storeId, Role $role)
    {
        $this->authorize('create', [$role, $storeId]);
        return view('store.pages.role.form', compact('role'));
    }
}
