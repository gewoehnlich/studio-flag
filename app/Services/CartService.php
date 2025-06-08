<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

final class CartService extends Service
{
    public static function index(int $id): Cart | null
    {
        return Cart::with('items')->where('id', $id)->first();
    }

    public static function store(array $data): bool
    {
        $cart = Cart::find($data['cart_id']);

        if (!$cart) {
            return false;
        }

        $result = $cart->items()->delete();

        foreach ($data['product_ids'] as $id) {
            $item = CartItemService::store(['cart_id' => $data['cart_id'], 'product_id' => $id]);
        }

        return true;
    }

    public static function delete(int $id): bool
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return false;
        }

        return $cart->items()->delete();
    }
}
