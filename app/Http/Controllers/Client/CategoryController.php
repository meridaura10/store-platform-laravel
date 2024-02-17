<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $category->load('subcategories.translations', 'subcategories.image');

        if ($category->subcategories->isEmpty()) {
            return view('client.pages.category.show',compact('category'));
        }

        return view('client.pages.category.subcategories',compact('category'));
    }
}
