<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function getAllClients() {
        return Client::orderBy('person_full_name')->get();
    }

    public function getClient($id) {
        return Client::with('orders')->find($id);
    }

    public function getClients(Request $request) {
        $params = $request->query();
        $query = Client::query();

        if (isset($params['per_page']) && $params['per_page'] == -1) {
            $params['per_page'] = $query->count();
        }

        if (isset($params['query'])) {
            $value = '%'.$params['query'].'%';
            $query
                ->where('person_full_name', 'like', $value)
                ->orWhere('company_name', 'like', $value)
                ->orWhere('telephone', 'like', $value);
        }

        if (isset($params['sortBy']) && isset($params['direction'])) {
            $query->orderBy($params['sortBy'], $params['direction']);
        }

        return $query->paginate($params['per_page']);
    }

    public function createClient(Request $request) {
        $this->validate($request, [
            'person_full_name' => 'required',
            'company_name' => 'required',
            'area' => 'required',
            'telephone' => 'required|max:20'
        ]);

        $client = new Client($request->all());
        $client->save();
        return $client;
    }

    public function updateClient(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to update client'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }

        Client::where('id', '=', $id)->update($request->all());
    }

    function deleteClient(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to deleting clients'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        return Client::destroy($id);
    }
}
