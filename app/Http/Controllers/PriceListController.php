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
            'type' => ['required', Rule::in(['GPS-трекеры', 'Датчики уровня топлива', 'Расходомеры топлива', 'Идентификация', 'Дополнительное оборудование', 'Услуга'])]
        ]);

        if ($request->input('type') === 'Услуга') {
            $this->validate($request, [
                'name' => 'required',
                'price' => 'required|numeric'
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required',
                'incoming_price' => 'required|numeric',
                'price' => 'required|numeric',
                'installation_price' => 'required|numeric',
                'description' => 'string'
            ]);
        }



        $result = DB::transaction(function() use ($request) {
            $equipment = new PriceList($request->all());
            $equipment->save();

            $log = new PriceListLog([
                'type' => 'Создание',
                'user_id' => $request->user()->id,
                'before' => "{}",
                'after' => $equipment->toJson()
            ]);
            $equipment->logs()->save($log);
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
            'isService' => 'required|boolean',
            'equipment.incoming_price' => 'numeric',
            'equipment.price' => 'numeric',
            'equipment.installation_price' => 'numeric',
            'equipment.description' => 'string',
            'equipment.type' => Rule::in(['GPS-трекеры', 'Датчики уровня топлива', 'Расходомеры топлива', 'Идентификация', 'Дополнительное оборудование']),
            'service.price' => 'numeric',
            'service.type' => Rule::in(['Услуга']),
            'log.before' => 'required|string',
            'log.after' => 'required|string'
        ]);
        DB::transaction(function () use ($request, $id) {
            if ($request->input('isService')) {
                PriceList::where('id', $id)->update($request->input('service'));
            } else {
                PriceList::where('id', $id)->update($request->input('equipment'));
            }
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

    public function delete(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to register new user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        DB::transaction(function () use ($request, $id) {
            PriceList::destroy($id);
            $priceListLog = new PriceListLog([
                'price_list_id' => $id,
                'user_id' => $request->user()->id,
                'type' => 'Удаление',
                'before' => "{}",
                'after' => "{}"
            ]);
            $priceListLog->save();
        });
    }
}
