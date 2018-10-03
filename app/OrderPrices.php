<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPrices extends Model
{
    protected $fillable = [
        'order_id',
        'prices',
        'is_current'
    ];

    protected $casts = [
        'prices' => 'array',
        'is_current' => 'boolean'
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
