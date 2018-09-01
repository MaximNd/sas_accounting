<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PriceListLog;

class PriceListLogController extends Controller
{
    public function getLogs(Request $request) {
        $params = $request->query();
        $query = PriceListLog::query();

        if (isset($params['per_page']) && $params['per_page'] == -1) {
            $params['per_page'] = $query->count();
        }

        if (isset($params['query'])) {
            $value = '%'.$params['query'].'%';
            $query
                ->whereHas('equipment', function ($q) use ($value) {
                    $q
                        ->withTrashed()
                        ->where('name', 'like', $value)
                        ->orWhere('type', 'like', $value);
                })
                ->orWhereHas('user', function ($q) use ($value) {
                    $q
                        ->withTrashed()
                        ->where('last_name', 'like', $value)
                        ->orWhere('first_name', 'like', $value)
                        ->orWhere('mid_name', 'like', $value)
                        ->orWhere('email', 'like', $value);
                });
        }

        if (isset($params['sortBy']) && isset($params['direction'])) {
            $sortColumns = explode('.', $params['sortBy']);
            if (count($sortColumns) === 1) {
                $query->orderBy($params['sortBy'], $params['direction']);
            } else if ($sortColumns[0] == 'user') {
                $query
                    ->join('users', 'price_list_logs.user_id', '=', 'users.id')
                    ->orderBy('last_name', $params['direction'])
                    ->select('price_list_logs.*');
            } else if ($sortColumns[0] == 'equipment') {
                $query
                    ->join('price_lists', 'price_list_logs.price_list_id', '=', 'price_lists.id')
                    ->orderBy($sortColumns[1], $params['direction'])
                    ->select('price_list_logs.*');
            }
        }
//        \DB::listen(function($sql) {
//            dd($sql);
//        });
        return $query->with(['equipment' => function ($q) {
            $q->withTrashed();
        }])->with(['user' => function ($q) {
            $q->withTrashed();
        }])->paginate($params['per_page']);
    }
}
