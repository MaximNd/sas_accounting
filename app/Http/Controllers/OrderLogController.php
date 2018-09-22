<?php

namespace App\Http\Controllers;

use App\OrderLog;
use Illuminate\Http\Request;

class OrderLogController extends Controller
{
    public function getLogs(Request $request) {
        $params = $request->query();
        $query = OrderLog::query();

        if (isset($params['per_page']) && $params['per_page'] == -1) {
            $params['per_page'] = $query->count();
        }

        if (isset($params['query'])) {
            $value = '%'.$params['query'].'%';
            $query
                ->whereHas('order', function ($q) use ($value) {
                    $q
                        ->withTrashed()
                        ->where('name', 'like', $value)
                        ->orWhereHas('client', function ($q) use ($value) {
                            $q
                                ->withTrashed()
                                ->where('person_full_name', 'like', $value)
                                ->orWhere('company_name', 'like', $value)
                                ->orWhere('telephone', 'like', $value);
                        });
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
                    ->join('users', 'order_logs.user_id', '=', 'users.id')
                    ->orderBy('last_name', $params['direction'])
                    ->select('order_logs.*');
            } else if ($sortColumns[0] == 'order') {
                $query
                    ->join('orders', 'order_logs.price_list_id', '=', 'orders.id')
                    ->orderBy($sortColumns[1], $params['direction'])
                    ->select('order_logs.*');
            }
        }
//        \DB::listen(function($sql) {
//            dd($sql);
//        });
        return $query->with(['order' => function ($q) {
            $q->withTrashed();
        }])->with(['user' => function ($q) {
            $q->withTrashed();
        }])->paginate($params['per_page']);
    }
}
