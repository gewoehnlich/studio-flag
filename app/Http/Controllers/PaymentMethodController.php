<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\PaymentMethodService;
use App\Http\Requests\PaymentMethods\IndexRequest;
use App\Http\Requests\PaymentMethods\StoreRequest;
use App\Http\Requests\PaymentMethods\UpdateRequest;
use App\Http\Requests\PaymentMethods\DeleteRequest;
use App\Http\Resources\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index(IndexRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = PaymentMethodService::index($data);

        return response()->json([
            'success' => true,
            'result' => PaymentMethodResource::collection($result)
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

        $result = PaymentMethodService::store($data);

        return response()->json([
            'success' => true,
            'message' => 'Успешно создан новый платежный метод!',
            'result' => new PaymentMethodResource($result)
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

        $result = PaymentMethodService::update($data, $id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти платежный метод с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно обновлен платежный метод № ' . $id . '!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(DeleteRequest $request, int $id): JsonResponse
    {
        $result = PaymentMethodService::delete($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти платежный метод с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно удален платежный метод № ' . $id . '!'
        ]);
    }
}
