<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Models\Departament;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function getWithLimit(){
        return $this->returnSuccess(200, $this->formatWithLimit());
    }
    
    private function formatWithLimit(){
        $departaments =  Departament::withCount('ticketsAtending')->get();
        $format = [];
        foreach ($departaments as $key ) {
            array_push($format,[
                'id'        =>  $key->id,
                'name'      =>  $key->name,
                'disabled'  =>  $key->limit == 0 ? false : $key->limit == $key->tickets_atending_count,
            ]);
        }
        return $format;
    }
    public static function getCorrelative($id, $date) {
        $departaments =  Departament::find($id);
        $correlative = Ticket::where('departament_id', $id)->whereDate('created_at', '=' , $date)
        ->whereTime('created_at', '<', '23:59:59')
        ->withTrashed()->count();

        $acr = $departaments->acr;
        $number = $correlative + 1;
        $cero = substr("000", strlen( (string)$number) );

        return $acr.$cero.$number;
    }
}
