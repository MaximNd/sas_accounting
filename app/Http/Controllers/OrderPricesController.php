<?php

namespace App\Http\Controllers;

use App\OrderPrices;
use App\PriceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderPricesController extends Controller
{
    public function createOrderPrices(Request $request, $order_id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to recalculate prices'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
//        $this->validate($request, [
//            'newPrices' => 'required|array'
//        ]);
        return DB::transaction(function() use ($order_id) {
            $currentPriceList = PriceList::all();
            $pricesData = $currentPriceList->map(function ($priceListRow) {
                return [
                    'id' => $priceListRow->id,
                    'price' => $priceListRow->price,
                    'installation_price_for_one' => $priceListRow->installation_price_for_one,
                    'installation_price_for_two' => $priceListRow->installation_price_for_two,
                    'installation_price_for_three' => $priceListRow->installation_price_for_three
                ];
            });
            OrderPrices::where('order_id', '=', $order_id)
                ->update([
                    'is_current' => false
                ]);

            $orderPrices = new OrderPrices([
                'order_id' => $order_id,
                'prices' => $pricesData,
                'is_current' => true
            ]);
            $orderPrices->save();
            return $orderPrices;
        });
    }
}
