<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\SaleCreateRequest;
use App\Http\Requests\Sale\SaleRequest;
use App\Services\Contracts\SaleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleServiceInterface $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index(SaleRequest $request)
    {
        $sales = $this->saleService->list($request);

        return $this->responseSuccess($sales, "", JsonResponse::HTTP_OK);
    }

    public function store(SaleCreateRequest $request)
    {
        $sale = $this->saleService->create($request);

        return $this->responseSuccess($sale, "Venta realizada exitosamente", JsonResponse::HTTP_OK);
    }
}
