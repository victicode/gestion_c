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
        $departament =  Departament::withCount('ticketsAtending')->with('ticketsPending.client', 'currentTicket.client', 'ticketsByDay.client')->find($id);
        return $this->returnSuccess(200, $departament);
    }
    public function updateLimit($id, Request $request) {
        $departament = Departament::find($id);
        if(!$departament) return $this->returnFail(404,'Departamento no encontrado');
        $departament->limit = $request->limit;
        $departament->save();
        return $this->returnSuccess(200, $departament);
    }
    public static function getCorrelative($id) {
        $departaments =  Departament::withCount('correlative')->find($id);

        $acr = $departaments->acr;
        $number = $departaments->correlative_count + 1;
        $cero = substr("000", strlen( (string)$number) );

        return $acr.$cero.$number;
    }
}
