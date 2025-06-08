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
        $data['payment_url_template'] = route('payment_method.base', ['name' => $data['name']]);

        return PaymentMethod::create($data);
    }

    public static function update(array $data, int $id): bool
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return false;
        }

        $data['payment_url_template'] = route('payment_method.base', ['name' => $data['name']]);

        $result = $paymentMethod->update($data);

        return $result;
    }

    public static function delete(int $id): bool
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return false;
        }

        return $paymentMethod->delete();
    }

    public static function paymentLink(int $id): ?string
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return null;
        }

        $template = $paymentMethod->payment_url_template;

        return $template . '/payment_link.php';
    }

    public static function paymentConfirmationLink(int $id): ?string
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return null;
        }

        $template = $paymentMethod->payment_url_template;

        return $template . '/payment_confirmation_link.php';
    }
}
