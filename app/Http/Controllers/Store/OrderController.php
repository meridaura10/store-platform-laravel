<?php

namespace App\Http\Controllers\Store;

use App\Enums\User\UserRightTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Store;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($storeId)
    {
        $this->authorize('viewAny', [Order::class, $storeId]);
        return view('store.pages.order.index');
    }

    public function moderation($storeId, Order $order)
    {
        $this->authorize('view', [$order,  $storeId]);
        return view('store.pages.order.moderation', compact('order'));
    }

    public function edit($storeId, Order $order)
    {
        $this->authorize('update', [$order,  $storeId]);
        return view('store.pages.order.edit', compact('order'));
    }
}
