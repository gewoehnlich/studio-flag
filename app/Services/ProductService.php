<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

final class ProductService extends Service
{
    public static function index(array $data): Collection
    {
        $query = Product::query();

        if (!empty($data['lower_price'])) {
            $query->where('price', '>=', $data['lower_price']);
        }

        if (!empty($data['upper_price'])) {
            $query->where('price', '<=', $data['upper_price']);
        }

        if (!empty($data['order_by'])) {
            $query->orderBy('price', $data['order_by']);
        }

        if (!empty($data['limit'])) {
            $query->limit($data['limit']);
        }

        return $query->get();
    }

    public static function store(array $data): Product
    {
        return Product::create($data);
    }

    public static function update(array $data, int $id): bool
    {
        $product = Product::find($id);

        if (!$product) {
            return false;
        }

        $result = $product->update($data);

        return $result;
    }

    public static function delete(int $id): bool
    {
        $product = Product::find($id);

        if (!$product) {
            return false;
        }

        return $product->delete();
    }
}
