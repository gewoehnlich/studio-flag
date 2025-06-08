<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\OrderItemService;
use App\Http\Requests\OrderItems\IndexRequest;
use App\Http\Requests\OrderItems\StoreRequest;
use App\Http\Requests\OrderItems\UpdateRequest;
use App\Http\Requests\OrderItems\DeleteRequest;
use App\Http\Resources\OrderItemResource;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index(IndexRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $result = OrderItemService::index($data);

        return response()->json([
            'success' => true,
            'result' => OrderItemResource::collection($result)
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
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $result = OrderItemService::store($data);

        return response()->json([
            'success' => true,
            'message' => 'Успешно создан новый заказ!',
            'result' => new OrderItemResource($result)
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

        $result = OrderItemService::update($data, $id);

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

        $result = OrderItemService::delete($data, $id);

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
