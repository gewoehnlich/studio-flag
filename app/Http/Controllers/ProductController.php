<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\ProductService;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index(IndexRequest $request): JsonResponse
    {
        $result = ProductService::index($request->validated());

        return response()->json([
            'success' => true,
            'result' => ProductResource::collection($result)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public static function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store(StoreRequest $request): JsonResponse
    {
        $result = ProductService::store($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Успешно создан новый товар!',
            'result' => new ProductResource($result)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public static function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public static function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public static function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = ProductService::update($request->validated(), $id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти товар с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно обновлен товар № ' . $id . '!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(string $id): JsonResponse
    {
        $result = ProductService::delete($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось найти товар с ID № ' . $id . '.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно удален товар № ' . $id . '!'
        ]);
    }
}
