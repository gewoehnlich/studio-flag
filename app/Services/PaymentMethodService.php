<?php

namespace App\Services;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

final class PaymentMethodService extends Service
{
    public static function index(array $data): Collection
    {
        $query = PaymentMethod::query();

        if (!empty($data['id'])) {
            $query->where('id', $data['id']);
        }

        if (!empty($data['name'])) {
            $query->where('name', $data['name']);
        }

        return $query->get();
    }

    public static function store(array $data): PaymentMethod
    {
        return PaymentMethod::create($data);
    }

    public static function update(array $data, int $id): bool
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return false;
        }

        return $paymentMethod->update($data);
    }

    public static function delete(int $id): bool
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return false;
        }

        return $paymentMethod->delete();
    }
}
