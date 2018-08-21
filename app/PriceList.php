<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceList extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'incoming_price',
        'price',
        'installation_price',
        'description',
        'type'
    ];

    protected $dates = ['deleted_at'];

    public function logs() {
        return $this->hasMany('App\PriceListLog', 'price_list_id');
    }
}
