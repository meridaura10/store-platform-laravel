<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.pages.product.index');
    }

    public function moderation(Product $product)
    {
        return view('admin.pages.product.moderation',compact('product'));
    }
}
