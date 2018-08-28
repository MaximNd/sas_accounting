<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'person_full_name',
        'company_name',
        'area',
        'telephone',
        'comment'
    ];
}
