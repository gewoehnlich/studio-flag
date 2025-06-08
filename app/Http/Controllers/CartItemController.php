<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\CartItemService;
use App\Http\Resources\CartItemResource;
use App\Http\Requests\CartItems\StoreRequest;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $id): JsonResponse
    {
        //
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
        $data = $request->validated();
        $data['cart_id'] = $request->user()->id;

        $result = CartItemService::store($data);

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $result = CartItemService::delete($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти товар с ID № ' . $id . ' в корзине.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно удален товар № ' . $id . ' из корзины!'
        ]);
    }
}
