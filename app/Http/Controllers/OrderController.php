<?php

namespace App\Http\Controllers;

use App\Order;
use App\GPSData;
use App\OrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function dollarRate() {
        $session = curl_init('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=USD&json');
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);
        return response($json);
    }

    public function uploadImage(Request $request) {
        $max_size = (int)ini_get('upload_max_filesize') * 1000;
        $this->validate($request, [
            'image' => 'image|max:'.$max_size
        ]);
        $image = $request->file('image');
        $imageName = uniqid('transport_') . $image->getClientOriginalName();
        Storage::disk('public')->putFileAs('/', $image, $imageName);
        return $imageName;
    }

    public function createOrder(Request $request) {
        $this->validate($request, [
            'client_id' => 'required|numeric',
            'dollar_rate' => 'required|numeric',
            'name' => 'required',
            'area' => 'required|numeric',
            'days' => 'required|numeric',
            'price_for_day' => 'required|numeric',
            'price_for_transportation_per_km' => 'required|numeric',
            'number_of_trips' => 'required|numeric',
            'transportation_kms' => 'required|numeric',
            'route' => 'required',
            'services' => 'required',
            'GPSData' => 'required|array'
        ]);

        $result = DB::transaction(function() use ($request) {
            $order = new Order($request->except('GPSData'));
            $order->save();
            $gpsData = $request->input('GPSData');
            $gpsDataLength = count($gpsData);
            $orderGPSData = [];
            for ($i = 0; $i < $gpsDataLength; ++$i) {
                $orderGPSData[] = new GPSData($gpsData[$i]);
            }
            $order->gpsData()->saveMany($orderGPSData);
            $log = new OrderLog([
                'type' => 'Создание',
                'user_id' => $request->user()->id,
                'before' => '[]',
                'after' => '[]'
            ]);
            $order->logs()->save($log);
            return $order;
        });

        return $result;
    }

    public function getOrder($id) {
        return Order::with('client')->with('gpsData')->find($id);
    }

    public function getOrders(Request $request) {
        $params = $request->query();
        $query = Order::query();

        if (isset($params['per_page']) && $params['per_page'] == -1) {
            $params['per_page'] = $query->count();
        }

        if (isset($params['query'])) {
            $value = '%'.$params['query'].'%';

            $query
                ->where('name', 'like', $value)
                ->orWhere('area', 'like', $value)
                ->orWhereHas('client', function ($q) use ($value) {
                    $q
                        ->where('person_full_name', 'like', $value)
                        ->orWhere('company_name', 'like', $value);
                });
        }

        if (isset($params['sortBy']) && isset($params['direction'])) {
            $sortColumns = explode('.', $params['sortBy']);
            if (count($sortColumns) === 1) {
                $query->orderBy($params['sortBy'], $params['direction']);
            } else {
                $query
                    ->join('clients', 'orders.client_id', '=', 'clients.id')
                    ->orderBy($sortColumns[1], $params['direction'])
                    ->select('orders.*');
            }
        }
//        \DB::listen(function($sql) {
//            dd($sql);
//        });
        return $query->with('client')->paginate($params['per_page']);
    }

    public function updateOrder(Request $request, $id) {

    }

    public function deleteOrder(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to register new user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        DB::transaction(function () use ($request, $id) {
            Order::destroy($id);
            $orderLog = new OrderLog([
                'order_id' => $id,
                'user_id' => $request->user()->id,
                'type' => 'Удаление',
                'before' => "{}",
                'after' => "{}"
            ]);
            $orderLog->save();
        });
    }
}
