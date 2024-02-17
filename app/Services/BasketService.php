<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\BasketProduct;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Livewire;

class BasketService
{
    private $basket;

    private Collection $basketProducts;

    private $totalQuantity = 0;

    private $token;

    public function __construct()
    {
        $this->token = session()->getId();
        $this->basketProducts = collect();
        $this->basket = $this->getBasket();


        $this->setTotalQuantity();
    }

    public function getBasket()
    {
        if (auth()->check()) {
            $this->basket = auth()->user()->basket;
        }

        if (!$this->basket) {
            $this->basket = $this->getBasketOrSession();
        }

        if (!$this->basket) {
            $this->basket = $this->createBasket();
        }

        return $this->basket;
    }

    private function getBasketOrSession(): Basket|null
    {
        return Basket::query()->where('session_id', $this->token)->first();
    }

    private function createBasket()
    {
        if (auth()->check()) {
            return auth()->user()->basket()->create();
        }

        return Basket::create([
            'session_id' => $this->token,
            'lifetime' => now(),
        ]);
    }

    public function isEmpty()
    {
        return !$this->BasketProductsQuery()->exists();
    }

    public function BasketProductsQuery()
    {
        return $this->basket->basketProducts()->with(['product.translations', 'product.image']);
    }

    public function getBasketProducts()
    {
        if ($this->basketProducts->isEmpty()) {
            $this->basketProducts = $this->BasketProductsQuery()->get();
        }

        return $this->basketProducts;
    }

    public function updateBasketProductQuantity(BasketProduct $basketProduct, $quantity)
    {

        if ($basketProduct->product->quantity >= $quantity) {
            $basketProduct->update([
                'quantity' => $quantity,
            ]);
        }

        $this->updated();
    }

    public function getBasketProductsGroupedByShop()
    {
        return $this->getBasketProducts()->groupBy(function ($basketProduct) {
            return $basketProduct->product->store_id;
        });
    }

    public function getBasketProductsToShop(Store $store)
    {
        return $this->BasketProductsQuery()->whereHas('product', function ($query) use ($store) {
            return $query->where('store_id', $store->id);
        })->get();
    }

    public function setBasketToUser(User $user)
    {
        $basket = $this->getBasketOrSession();

        $basket->update([
            'user_id' => $user->id,
            'lifetime' => null,
        ]);
    }

    public function clear()
    {
        $this->basket->basketProducts()->delete();
    }

    public function clearBasketProductsToStore(Store $store)
    {
        $this->BasketProductsQuery()->whereHas('product', function ($query) use ($store) {
            $query->where('store_id', $store->id);
        })->delete();
    }

    public function removeBasketProduct(BasketProduct $basketProduct)
    {
        $basketProduct->delete();

        $this->updated();
    }

    public function hasProduct(Product $product)
    {
        return $this->BasketProductsQuery()->where('product_id', $product->id)->exists();
    }

    public function createBasketProduct(Product $product)
    {
        if (!$this->BasketProductsQuery()->where('product_id', $product->id)->exists()) {
            $this->BasketProductsQuery()->create([
                'product_id' => $product->id
            ]);
        }

        $this->updated();
    }

    public function totalSum()
    {
        return $this->getBasketProducts()->sum('sum');
    }

    public function setTotalQuantity()
    {
        $this->totalQuantity = $this->BasketProductsQuery()->sum('quantity');
    }

    public function totalQuantity()
    {
        return $this->totalQuantity;
    }

    private function updated()
    {
        if (!auth()->check()) {
            $this->basket->update(['lifetime' => now()]);
        }

        $this->setTotalQuantity();
    }

    public function delete()
    {
        $this->basket->delete();
    }

    public function deleteOld()
    {
        Basket::where('lifetime', '<', now()->subMonth())->whereNotNull('lifetime')->delete();
    }
}
