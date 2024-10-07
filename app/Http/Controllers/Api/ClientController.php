<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function getByCi(Request $request) {
        $client = Client::where('ci', $request->ci)->first();
        return $this->returnSuccess(200, $client);
    }
    public static function storeClient(Request $request) {
        $client = Client::create([
            'ci'    => $request->ci,
            'name'  => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);
        return $client;
    }
}
