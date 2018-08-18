<?php

namespace App\Http\Controllers;

use App\PriceList;
use App\PriceListLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PriceListController extends Controller
{
    public function getAll() {
        return PriceList::all();
    }

    public function create(Request $request) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to register new user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        $this->validate($request, [
            'model' => 'required',
            'incoming_price' => 'required|numeric',
            'price' => 'required|numeric',
            'installation_price' => 'required|numeric',
            'type' => ['required', Rule::in(['GPS-трекеры', 'Датчики уровня топлива', 'Расходомеры топлива', 'Идентификация', 'Дополнительное оборудование'])]
        ]);

        $result = DB::transaction(function() use ($request) {
            $equipment = new PriceList($request->all());
            $equipment->save();

            $log = new PriceListLog([
                'type' => 'Создание'
            ]);
            $equipment->logs()->save($log);
            $equipment->logs = [$log];
            return $equipment;
        });

        return $result;
    }

    public function update(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to register new user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        $this->validate($request, [
            'equipment.incoming_price' => 'numeric',
            'equipment.price' => 'numeric',
            'equipment.installation_price' => 'numeric',
            'equipment.type' => Rule::in(['GPS-трекеры', 'Датчики уровня топлива', 'Расходомеры топлива', 'Идентификация', 'Дополнительное оборудование']),
            'log.before' => 'required|string',
            'log.after' => 'required|string'
        ]);
        DB::transaction(function () use ($request, $id) {
            PriceList::where('id', $id)->update($request->input('equipment'));
            $priceListLog = new PriceListLog([
                'price_list_id' => $id,
                'user_id' => $request->user()->id,
                'type' => 'Обновление',
                'before' => $request->input('log.before'),
                'after' => $request->input('log.after')
            ]);
            $priceListLog->save();
        });
    }
}
