<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionalService extends Model
{
    protected $fillable = [
        'name',
        'price',
        'comment',
        'order_id'
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
