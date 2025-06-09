<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Jobs\CancelOrderJob;
use Illuminate\Database\Eloquent\Collection;

final class OrderService extends Service
{
    public static function index(array $data): Collection
    {
        $query = Order::query();

        if (!empty($data['start_date'])) {
            $query->where('created_at', '>=', $data['start_date']);
        }

        if (!empty($data['end_date'])) {
            $query->where('created_at', '<=', $data['end_date']);
        }

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (!empty($data['id'])) {
            $query->where('id', $data['id']);
        }

        return $query->get();
    }

    public static function store(array $data): Order
    {
        $order = Order::create($data);

        foreach ($data['items'] as $item) {
            $order->items()->create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
            ]);
        }

        $cart = Cart::where(['id' => $data['user_id']])->first();
        $cart->items()->delete();

        CancelOrderJob::dispatch($order->id)->delay(now()->addMinutes(2));

        return $order;
    }

    public static function update(array $data, int $id): bool
    {
        $order = Order::find($id);

        if (!$order) {
            return false;
        }

        $result = $order->update($data);

        return $result;
    }

    public static function delete(int $id): bool
    {
        $order = Order::find($id);

        if (!$order) {
            return false;
        }

        return $order->delete();
    }
}
