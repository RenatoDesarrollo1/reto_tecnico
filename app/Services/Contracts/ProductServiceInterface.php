<?php

namespace App\Services\Contracts;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use Illuminate\Http\Request;

interface ProductServiceInterface
{
    public function list(Request $request);
    public function get(int $id);
    public function create(ProductCreateRequest $request);
    public function update(ProductUpdateRequest $request, int $id);
    public function delete(int $id);
}
