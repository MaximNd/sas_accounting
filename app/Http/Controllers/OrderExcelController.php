<?php

namespace App\Http\Controllers;

use App\Exports\GPSDataExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderExcelController extends Controller
{
    public function createExcel(Request $request) {
        return Excel::download(new GPSDataExport($request->all()), 'test.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
