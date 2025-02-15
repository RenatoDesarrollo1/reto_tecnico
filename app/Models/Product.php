<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sku',
        'name',
        'unit_price',
        'stock',
    ];

    protected $messages = [
        'notfound' => "Este producto no existe"
    ];

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }
}
