<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CachedData;

class CachedDataController extends Controller
{
    public function getCachedData() {
        return CachedData::all();
    }

    public function addCachedData(Request $request) {
        CachedData::insert($request->input('cache'));
    }
}
