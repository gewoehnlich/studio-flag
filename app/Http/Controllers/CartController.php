<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Cart\IndexRequest;
use App\Http\Requests\Cart\StoreRequest;
use App\Http\Requests\Cart\UpdateRequest;
use App\Http\Requests\Cart\DeleteRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $id = $request->user()->id;

        $result = CartService::index($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти корзину пользователя с ID № ' . $id . '.'     // fix message
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => new CartResource($result)
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
    public function store(StoreRequest $request): JsonResponse
    {
        $id = $request->user()->id;

        $data = $request->validated();
        $data['cart_id'] = $id;

        $result = CartService::store($data);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти корзину пользователя с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно добавлен новый товар в корзину!',
            'result' => new CartItemResource($result)
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
    public function update(UpdateRequest $request): JsonResponse
    {
        $id = $request->user()->id;

        $data = $request->validated();
        $data['cart_id'] = $id;

        $result = CartService::update($data);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти корзину пользователя с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно обновлена корзина пользователя № ' . $id . '!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteRequest $request): JsonResponse
    {
        $id = $request->user()->id;

        $data = $request->validated();
        $data['cart_id'] = $id;

        $result = CartService::delete($data);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти корзину пользователя с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно удалены товары у корзины пользователя с № ' . $id . '!' // fix message
        ]);
    }
}
