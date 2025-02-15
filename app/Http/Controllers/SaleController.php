<?php

namespace App\Http\Controllers;

use App\Exports\SalesReportExport;
use App\Http\Requests\Sale\SaleCreateRequest;
use App\Http\Requests\Sale\SaleRequest;
use App\Services\Contracts\SaleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        if ($request->input('format') === 'json') {
            return $this->responseSuccess($sales, "", JsonResponse::HTTP_OK);
        }

        if ($request->input('format') === 'xlsx') {
            return Excel::download(new SalesReportExport($sales), 'reporte_ventas.xlsx');
        }
    }

    public function store(SaleCreateRequest $request)
    {
        $sale = $this->saleService->create($request);

        return $this->responseSuccess($sale, "Venta realizada exitosamente", JsonResponse::HTTP_OK);
    }
}
