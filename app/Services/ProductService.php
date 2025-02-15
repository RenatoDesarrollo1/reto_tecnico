<?php

namespace App\Services;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductService implements ProductServiceInterface
{

    public function list(Request $request)
    {
        $perpage = $request->perpage ?? 0;
        $products = Product::paginate($perpage);

        return $products;
    }

    public function get(int $id)
    {
        $product = Product::findOrFail($id);

        return $product;
    }

    public function create(ProductCreateRequest $request)
    {
        $product = Product::create($request->all());

        if (!isset($product->id)) {
            throw new \Exception('El producto no se pudo crear', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $product;
    }

    public function update(ProductUpdateRequest $request, int $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        if (!$product) {
            throw new \Exception('El producto no se pudo actualizar', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $product->refresh();
        return $product;
    }
    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        $isdeleted = $product->delete();

        if (!$isdeleted) {
            throw new \Exception('El producto no se pudo eliminar', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $isdeleted;
    }
}
