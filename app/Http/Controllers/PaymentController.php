<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Requests\Payments\LinkRequest;
use App\Http\Requests\Payments\ConfirmationRequest;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public static function link(LinkRequest $request): JsonResponse
    {
        $id = $request->user()->id;

        $data = $request->validated();

        $order = Order::find($data['order_id']);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Такой заказ не найден.'
            ], 404);
        }

        if ($order->user_id != $id) {
            return response()->json([
                'success' => false,
                'message' => 'Можно оплатить только ваш заказ.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Перейдите по ссылке, чтобы подтвердить платеж!',
            'result' => route('payment.confirmation', [
                'order_id' => $data['order_id'],
                'payment_method_id' => $data['payment_method_id']
            ])
        ]);
    }

    public static function confirmation(ConfirmationRequest $request): JsonResponse
    {
        $id = $request->user()->id;

        $data = $request->validated();

        $order = Order::find($data['order_id']);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Такой заказ не найден.'
            ]);
        }

        if ($order->user_id != $id) {
            return response()->json([
                'success' => false,
                'message' => 'Можно оплатить только ваш заказ.'
            ]);
        }

        if ($order->status != OrderStatus::PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Время данное на оплату истекло.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Заказ успешно оплачен!',
        ]);
    }
}
