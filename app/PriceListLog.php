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
        return $this->belongsTo('App\PriseList', 'price_list_id');
    }


}
