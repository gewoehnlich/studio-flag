<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Cart\StoreRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $id = $request->user()->id;

        $result = CartService::index($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти корзину пользователя с ID № ' . $id . '.'
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
            'message' => 'Успешно обновлена корзина пользователя № ' . $id . '!',
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
    public function update(Request $request, string $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $id = $request->user()->id;

        $result = CartService::delete($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти корзину пользователя с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно удалены товары у корзины пользователя с № ' . $id . '!'
        ]);
    }
}
