<?php

namespace App\Services;

use App\Http\Requests\Sale\SaleCreateRequest;
use App\Http\Requests\Sale\SaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Services\Contracts\SaleServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleService implements SaleServiceInterface
{
    public function list(SaleRequest $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth();

        $sales = Sale::with(['saleDetails', 'seller']);

        if ($startDate && $endDate) {
            $sales->whereBetween('date_time', [$startDate, $endDate]);
        }

        $sales = $sales->get();

        return $sales;
    }

    public function create(SaleCreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $productsarr = $request->products ?? [];
            $productIds = collect($productsarr)->pluck('product_id')->toArray();

            $products = Product::whereIn('id', $productIds)->select(['id', 'unit_price', 'stock', 'name', 'sku'])->get()->keyBy('id');

            $saleDetails = [];
            $updates = [];

            foreach ($productsarr as $productData) {
                $productId = $productData['product_id'];

                if (!isset($products[$productId])) {
                    throw new \Exception("El producto con ID {$productId} no existe");
                }

                $product = $products[$productId];
                $price = $productData['price'] ?? $product->unit_price;
                $quantity = $productData['quantity'];
                $subtotal = $price * $quantity;

                if ($product->stock < $quantity) {
                    throw new \Exception("No hay stock para el producto: {$product->name}");
                }

                $saleDetails[] = [
                    'product_id' => $productId,
                    'unit_price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];

                $totalAmount += $subtotal;
                $updates[$productId] = [
                    'id' => $productId,
                    'sku' => $product->sku,
                    'unit_price' => $product->unit_price,
                    'name' => $product->name,
                    'stock' => $product->stock - $quantity,
                ];
            }
            $sale = Sale::create([...$request->except(['products']), 'total_amount' => $totalAmount, 'seller_id' => Auth::id()]);

            $sale->saleDetails()->createMany($saleDetails);

            Product::upsert(array_values($updates), ['id'], ['stock']);

            if (!isset($sale->id)) {
                throw new \Exception('La venta no se pudo guardar', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $sale;
        });
    }
}
