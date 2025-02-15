<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->list($request);

        return $this->responseSuccess($products, "", JsonResponse::HTTP_OK);
    }

    public function get(Request $request, int $id)
    {
        $products = $this->productService->get($id);

        return $this->responseSuccess($products, "", JsonResponse::HTTP_OK);
    }

    public function store(ProductCreateRequest $request)
    {
        $product = $this->productService->create($request);

        return $this->responseSuccess($product, "Producto creado correctamente", JsonResponse::HTTP_OK);
    }

    public function update(ProductUpdateRequest $request, int $id)
    {
        $product = $this->productService->update($request, $id);

        return $this->responseSuccess($product, "Producto actualizado correctamente", JsonResponse::HTTP_OK);
    }


    public function destroy(ProductUpdateRequest $request, int $id)
    {
        $product = $this->productService->delete($id);

        return $this->responseSuccess($product, "Producto eliminado correctamente", JsonResponse::HTTP_OK);
    }
}
