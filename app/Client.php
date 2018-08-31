<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'person_full_name',
        'company_name',
        'area',
        'telephone',
        'comment'
    ];

    protected $dates = ['deleted_at'];

    public function orders() {
        return $this->hasMany('App\Order', 'client_id');
    }
}
