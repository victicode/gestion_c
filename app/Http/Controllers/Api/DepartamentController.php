<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departament;
use Illuminate\Http\Request;

class DepartamentController extends Controller
{
    //
    public function getPendings(Request $request) {
        $departaments =  Departament::query()->with('ticketsPending')->get();
        
        return $this->returnSuccess(200, $departaments);
    }
}
