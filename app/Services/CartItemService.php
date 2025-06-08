<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

final class CartItemService extends Service
{
    public static function store(array $data): CartItem
    {
        return CartItem::create($data);
    }

    public static function delete(int $id): bool
    {
        $item = CartItem::find($id);

        if (!$item) {
            return false;
        }

        return $item->delete();
    }
}
