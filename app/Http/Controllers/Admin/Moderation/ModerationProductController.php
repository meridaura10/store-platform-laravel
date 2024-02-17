<?php

namespace App\Http\Controllers\Admin\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModerationProductController extends Controller
{
    public function index()
    {
        return view('admin.pages.moderation.product.index');
    }
}
