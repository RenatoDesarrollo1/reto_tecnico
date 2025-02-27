<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
    ];

    protected $messages = [
        'notfound' => "Esta venta no existe"
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }
}
