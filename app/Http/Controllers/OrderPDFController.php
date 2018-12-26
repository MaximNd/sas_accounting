<?php

namespace App\Http\Controllers;

use App\OrderPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class OrderPDFController extends Controller
{
    private $pdfNames = [
        'CONNECT_TO_PLATFORM' => 'Підключення до платформи SASAGRO.COM',
        'MONITORING' => 'Цілодобовий моніторинг',
        'FIELD_MAPPING_BY_DRONES' => 'Картування полів Дронами',
        'FIELD_MAPPING_BY_PHYSICAL_MEASUREMENT' => 'Картування полів Фізичний обмір',
        'LAND_BANK_ACCOUNTING' => 'Облік земельного банку',
        'ENGINEER_PROJECT' => 'Інженерний проект',
        'ENGINEER_SUPPORT' => 'Інженерна підтримка',
        'PARTOL' => 'Патрулювання',
        'NDVI' => 'NDVI',
        'COUNTING_SEEDLINGS' => 'Підрахунок всходів',
        'PHOTO_VIDEO' => 'Фото/відео',
        'SAS_MAPPER' => 'SAS Mapper',
        'CHEMICAL_SOIL_ANALYSIS' => 'Хімічний аналіз грунтів',
        'MEASURING_THE_HARDNESS_OF_THE_SOIL' => 'Вимірювання твердості грунту',
        'INTEGRATION_1C' => 'Інтеграція 1С і Cropio з супроводом'
    ];

    public function getOrderPDF($order_id) {
        return OrderPDF::where('order_id', '=', $order_id)
                ->orderBy('id', 'DESC')
                ->get();
    }

    public function createPDF(Request $request, $order_id) {
        $data = [
            'pdf_names' => $this->pdfNames,
            'data' => $request->except(['pdf_name'])
        ];
        $pdf_name = str_replace([' ', ':'], '_', now().'_'.$request->input('pdf_name').'.pdf');
        $orderPDF = new OrderPDF([
            'order_id' => $order_id,
            'name' => $pdf_name
        ]);
        $orderPDF->save();

        try {
            $pdf = PDF::loadView('pdf.pdf', $data)
                ->setPaper([50, 100, 606.5, 852.5], 'landscape')
                ->setWarnings(false);

            Storage::disk('public')->put('/pdf/'.$pdf_name, $pdf->output());

            $orderPDF->update([
                'status' => 'FINISHED'
            ]);
        } catch (\Exception $exception) {
            $orderPDF->update([
                'status' => 'FAILED'
            ]);
        } catch (\Error $error) {
            $orderPDF->update([
                'status' => 'FAILED'
            ]);
        } catch (\Throwable $exception) {
            $orderPDF->update([
                'status' => 'FAILED'
            ]);
        }

        return $orderPDF;
    }

    public function deletePDF($id) {
        return DB::transaction(function() use ($id) {
            $orderPDF = OrderPDF::find($id);
            $orderPDF->delete();
            Storage::disk('public')->delete(['/pdf/'.$orderPDF->name]);
        });
    }
}
