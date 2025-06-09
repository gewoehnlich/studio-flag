<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\Orders\IndexRequest;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Requests\Orders\UpdateRequest;
use App\Http\Requests\Orders\DeleteRequest;
use App\Http\Resources\OrderResource;
use App\Services\CartService;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index(IndexRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $result = OrderService::index($data);

        return response()->json([
            'success' => true,
            'result' => OrderResource::collection($result)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store(StoreRequest $request): JsonResponse
    {
        $id = $request->user()->id;

        $cart = CartService::index($id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Корзина не найдена.'
            ], 404);
        }

        $data = $request->validated();
        $data['items'] = $cart->toArray()['items'];
        $data['user_id'] = $id;
        $data['status'] = OrderStatus::PENDING;
        // $data['payment_link'] = route('payment.link', [
        //      'order_id' => $data['order_id'],
        //      'payment_method_id' => $data['payment_method_id']
        // ]);
        $data['payment_link'] = 'remove later';

        // dd($data);

        $result = OrderService::store($data);

        return response()->json([
            'success' => true,
            'message' => 'Успешно создан новый заказ!\n' .
                         'Перейдите по ссылке для оплаты: ' . route('payment.link', [
                             'order_id' => $result->id,
                             'payment_method_id' => $result->payment_method_id
                         ]),
            'result' => new OrderResource($result)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public static function update(UpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $result = OrderService::update($data, $id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти заказ с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно обновлен заказ № ' . $id . '!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(DeleteRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $result = OrderService::delete($data, $id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти заказ с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно удален заказ № ' . $id . '!'
        ]);
    }
}
