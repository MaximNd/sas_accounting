<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $fillable = [
        'model',
        'incoming_price',
        'price',
        'installation_price',
        'type'
    ];

    public function logs() {
        return $this->hasMany('App\PriceListLog', 'price_list_id');
    }
}
