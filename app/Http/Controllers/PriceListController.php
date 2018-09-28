<?php

namespace App\Http\Controllers;

use App\PriceList;
use App\PriceListLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
                'price' => 'required|numeric',
                'pdf_layout' => ['required', Rule::in(['Підключення до платформи SASAGRO.COM', 'Картування полів Дронами', 'Картування полів Фізичний обмір', 'Облік земельного банку', 'GPS моніторинг', 'Патрулювання', 'NDVI', 'Підрахунок всходів', 'Фото/відео', 'SAS Mapper', 'Хімічний аналіз грунтів', 'Вимірювання твердості грунту', 'Інтеграція 1С і Cropio з супроводом'])]
            ]);
        } else {
            $this->validate($request, [
                'image' => 'required|image',
                'name' => 'required',
                'incoming_price' => 'required|numeric',
                'price' => 'required|numeric',
                'installation_price_for_one' => 'required|numeric',
                'installation_price_for_two' => 'nullable|numeric',
                'installation_price_for_three' => 'nullable|numeric',
                'description' => 'string'
            ]);
        }



        $result = DB::transaction(function() use ($request) {
            $data = $request->all();

            if ($data['type'] != 'Услуга') {
                $data['image'] = $this->storeEquipmentImage($request);
            }

            $equipment = new PriceList($data);
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
                'message' => 'You are not allowed to update priseLIST'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }

        $this->validate($request, [
            'isService' => 'required|boolean',
            'equipment.incoming_price' => 'numeric',
            'equipment.price' => 'numeric',
            'equipment.installation_price_for_one' => 'nullable|numeric',
            'equipment.installation_price_for_two' => 'nullable|numeric',
            'equipment.installation_price_for_three' => 'nullable|numeric',
            'equipment.type' => Rule::in(['GPS-трекеры', 'Датчики уровня топлива', 'Расходомеры топлива', 'Идентификация', 'Дополнительное оборудование']),
            'service.price' => 'numeric',
            'service.type' => Rule::in(['Услуга']),
            'service.pdf_layout' => ['required', Rule::in(['Підключення до платформи SASAGRO.COM', 'Картування полів Дронами', 'Картування полів Фізичний обмір', 'Облік земельного банку', 'GPS моніторинг', 'Патрулювання', 'NDVI', 'Підрахунок всходів', 'Фото/відео', 'SAS Mapper', 'Хімічний аналіз грунтів', 'Вимірювання твердості грунту', 'Інтеграція 1С і Cropio з супроводом'])],
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

    public function restore(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to register new user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        DB::transaction(function () use ($request, $id) {
            PriceList::withTrashed()
                ->where('id', '=', $id)
                ->restore();
            $priceListLog = new PriceListLog([
                'price_list_id' => $id,
                'user_id' => $request->user()->id,
                'type' => 'Восстановление',
                'before' => "{}",
                'after' => "{}"
            ]);
            $priceListLog->save();
        });
    }

    public function storeEquipmentImage(Request $request) {
        $image = $request->file('image');
        $imageName = uniqid('equipment_') . $image->getClientOriginalName();
        Storage::disk('public')->putFileAs('/', $image, $imageName);
        return $imageName;
    }
}
