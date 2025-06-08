<?php

namespace App\Services;

use App\Models\Order;
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
            $query->where('status', '===', $data['status']);
        }

        return $query->get();
    }

    public static function store(array $data): Order
    {
        $data['status'] = 'pending';
        return Order::create($data);
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
