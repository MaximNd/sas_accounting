<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CachedData extends Model
{
    protected $fillable = [
        'column_name',
        'value'
    ];
}
