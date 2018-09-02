<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GPSData extends Model
{
    protected $fillable = [
        'order_id',
        'image',
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
        'connect_module',
        'can_reader',
        'deaerator',
        'additional_equipment',
        'cn03',
        'rs01'
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
