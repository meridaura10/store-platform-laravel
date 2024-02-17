<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.pages.order.index');
    }

    public function moderation(Order $order)
    {
        return view('admin.pages.order.moderation', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.pages.order.edit', compact('order'));
    }
}
