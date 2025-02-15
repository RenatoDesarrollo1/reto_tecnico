<?php

namespace App\Services\Contracts;

use App\Http\Requests\Sale\SaleCreateRequest;
use App\Http\Requests\Sale\SaleRequest;

interface SaleServiceInterface
{
    public function list(SaleRequest $request);
    public function create(SaleCreateRequest $request);
}
