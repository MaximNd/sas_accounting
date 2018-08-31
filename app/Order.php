<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'is_sent',
        'is_agreed',
        'is_paid',
        'dollar_rate',
        'name',
        'area',
        'days',
        'price_for_day',
        'price_for_transportation_per_km',
        'number_of_trips',
        'transportation_kms',
        'route',
        'services'
    ];

    protected $dates = ['deleted_at'];

    public function client() {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function gpsData() {
        return $this->hasMany('App\GPSData', 'order_id');
    }

    public function logs() {
        return $this->hasMany('App\OrderLog', 'order_id');
    }
}
