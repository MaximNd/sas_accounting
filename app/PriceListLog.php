<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceListLog extends Model
{
    protected $fillable = [
        'price_list_id',
        'user_id',
        'before',
        'after',
        'type'
    ];

    public function equipment() {
        return $this->belongsTo('App\PriceList', 'price_list_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
