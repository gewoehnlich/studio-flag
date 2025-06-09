<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

final class CartService extends Service
{
    public static function index(int $id): Cart | null
    {
        return Cart::with('items')->where('id', $id)->first();
    }

    public static function store(array $data): CartItem | null
    {
        $item = CartItem::where(['product_id' => $data['product_id'], 'cart_id' => $data['cart_id']])->first();

        if ($item) {
            return null;
        }

        return CartItem::create($data);
    }

    public static function update(array $data): bool
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

    public static function delete(array $data): bool
    {
        $cart = Cart::find($data['cart_id']);

        if (isset($data['product_id'])) {
            $item = CartItem::where(['product_id' => $data['product_id'], 'cart_id' => $data['cart_id']])->first();

            if (!$item) {
                return false;
            }

            return $item->delete();
        }

        return $cart->items()->delete();
    }
}
