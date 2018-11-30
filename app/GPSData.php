<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GPSData extends Model
{
    protected $fillable = [
        'order_id',
        'order',
        'image',
        'type',
        'multiplier',
        'mark',
        'model',
        'year_of_issue',
        'fuel_type',
        'power',
        'number',
        'gps_tracker',
        'fuel_gauge',
        'counter',
        'rf_id',
        'reader_of_trailed_equipment',
        'can_reader',
        'deaerator_small',
        'deaerator_large',
        'additional_equipment',
        'cn03',
        'rs01',
        'manual_installation_price'
    ];

    protected $casts = [
        'fuel_gauge' => 'array',
        'additional_equipment' => 'array',
        'cn03' => 'array',
        'rs01' => 'array'
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
