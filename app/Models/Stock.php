<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'amount',
        'price',
        'total_price',
        'sku',
        'barcode',
        'supplier',
        'supplier_contact',
        'category',
        'brand',
        'location',
        'minimum_stock',
        'is_active',
        'unit',
        'additional_info',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($stock) {
            $stock->total_price = $stock->amount * $stock->price;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
