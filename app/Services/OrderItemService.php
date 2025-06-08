<?php

namespace App\Services;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;

final class OrderItemService extends Service
{
    public static function index(array $data): Collection
    {
        //
    }

    public static function store(array $data): OrderItem
    {
        return OrderItem::create($data);
    }

    public static function update(array $data, int $id): bool
    {
        $item = OrderItem::find($id);

        if (!$item) {
            return false;
        }

        $result = $item->update($data);

        return $result;
    }

    public static function delete(int $id): bool
    {
        $item = OrderItem::find($id);

        if (!$item) {
            return false;
        }

        return $item->delete();
    }
}
