<?php

namespace App\Http\Middleware;

use App\Models\Store;
use App\Models\StoreUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreAdmin
{  
    public function handle(Request $request, Closure $next): Response
    {
        $storeId = $request->route('store');
        $store = Store::query()->where('id', $storeId)->active()->exists();

        if (!$store) {
            return redirect()->route('client.index');
        }

        $user = StoreUser::query()->active()->where('store_id', $storeId)->whereUserId(auth()->id())->exists();

        if (!$user) {
            return redirect()->route('client.index');
        }

        return $next($request);
    }
}
