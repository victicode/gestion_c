<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departament;
use Illuminate\Http\Request;

class DepartamentController extends Controller
{
    //
    public function getPendings(Request $request) {
        $departaments =  Departament::query()->with('ticketsPending', 'currentTicket.client')->get();
        return $this->returnSuccess(200, $departaments);
    }
    public function getDepartamentQueueById($id) {
        $departament =  Departament::with('ticketsPending.client')->find($id);
        return $this->returnSuccess(200, $departament);
    }
    public static function getCorrelative($id) {
        $departaments =  Departament::withCount('ticketsByDay')->find($id);

        $acr = $departaments->acr;
        $number = $departaments->tickets_by_day_count + 1;
        $cero = substr("000", strlen( (string)$departaments->tickets_by_day_count) );

        return $acr.$cero.$number;
    }
}
