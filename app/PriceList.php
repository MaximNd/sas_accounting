<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceList extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image',
        'name',
        'pdf_layout',
        'incoming_price',
        'price',
        'installation_price_for_one',
        'installation_price_for_two',
        'installation_price_for_three',
        'description',
        'type'
    ];

    protected $dates = ['deleted_at'];

    public function logs() {
        return $this->hasMany('App\PriceListLog', 'price_list_id');
    }
}
