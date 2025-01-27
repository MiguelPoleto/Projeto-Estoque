<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
        'price',
        'total_price',
        'buy_date'
    ];

    protected $casts = [
        'buy_date' => 'datetime',
        'price' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Stock::class, 'product_id', 'product_id');
    }
}
