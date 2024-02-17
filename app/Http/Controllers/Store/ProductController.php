<?php

namespace App\Http\Controllers\Store;

use App\Enums\User\UserRightTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('store.pages.product.index');
    }

    public function form($store, Product $product)
    {
        $this->authorize('update', [$product, $store]);
        return view('store.pages.product.form', compact('product'));
    }
}
