<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function dollarRate() {
        $session = curl_init('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=USD&json');
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);
        return response($json);
    }
}
