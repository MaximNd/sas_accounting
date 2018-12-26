<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPDF extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'status'
    ];
}
