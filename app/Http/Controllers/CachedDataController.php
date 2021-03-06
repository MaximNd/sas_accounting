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
        $cacheData = new CachedData($request->input('cache'));
        $cacheData->save();
        return $cacheData;
    }

    public function deleteCachedData($id) {
        return CachedData::destroy($id);
    }
}
