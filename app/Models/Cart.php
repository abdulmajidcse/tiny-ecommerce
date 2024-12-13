<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'guest_id',
        'product_id',
        'quantity',
        'ip',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
