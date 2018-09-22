<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'before',
        'after',
        'type'
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
