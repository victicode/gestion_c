<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Ticket;
use App\Events\TicketEvent;
use App\Events\DisplayEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departament;
use App\Models\Hour;

class TicketController extends Controller
{
    public function createTicket(Request $request) {
        if($this->checkLimitTicket($request->departament_id)) return $this->returnFail(201, 'Has alcanzado el limites de cita por día en el departamento');
        date_default_timezone_set('America/Caracas');
        $ticket = Ticket::create([
            'number'            => $this->setNumberTicket($request->departament_id, $request->day ?? null ),
            'client_id'         => $this->setUserformat($request),
            'departament_id'    => $request->departament_id,
            'type'              => $request->type ?? 1,
            'status'            => 1,
            'hour'              => $request->time ?? null,
            'created_at'        => $request->day ?? date("Y-m-d H:i:s"),
        ]);
        event(new TicketEvent($request->departament_id));
        return $this->returnSuccess(200,  $ticket->load('client')->load('departament'));
    }
    public function deleteTicket($ticketId){

        $ticket = Ticket::find($ticketId);
        if(!$ticket) return $this->returnFail(400, 'Ticket no encontrado');
        $ticket->delete();

        event(new TicketEvent($ticket->departament_id));
        return $this->returnSuccess(200, $ticket);
    }
    
    public function nextTicket($departamentId){
        
        $this->endTicket($departamentId,3);

        $ticket = Ticket::where('departament_id', $departamentId)->where('status', 1)->orderBy('updated_at', 'desc')->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59')->first();

        if(!$ticket) return $this->returnFail(201, 'No hay tickets en cola');

        $ticket->status = 2;
        $ticket->save();
        event(new TicketEvent($departamentId));
        event(new DisplayEvent($departamentId));


        return $this->returnSuccess(200, $ticket);
    }
    public function recall($departamentId){
        $ticket = Ticket::where('departament_id', $departamentId)->where('status', 2)->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59')->first();
        if($ticket){
            event(new DisplayEvent($departamentId));
            event(new TicketEvent($departamentId));
            return $this->returnSuccess(200, true);
        }
        return $this->returnSuccess(201, false);
    }
    public function posNextTicket($departamentId){
        
        $this->endTicket($departamentId,1);
        $tickes = Ticket::where('departament_id', $departamentId)->where('status', 1)->orderBy('updated_at', 'ASC')->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59')->count();
        if($tickes == 1){
            event(new TicketEvent($departamentId));
            return  $this->returnSuccess(200, $tickes);
        }
        $ticket = Ticket::where('departament_id', $departamentId)->where('status', 1)->orderBy('updated_at', 'ASC')->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59')->first();
        if(!$ticket) return $this->returnFail(201, 'No hay tickets en cola');
        $ticket->status = 2;
        $ticket->save();
        event(new DisplayEvent($departamentId));

        return $this->returnSuccess(200, $ticket);
    }
    public function getHourAvaibleByDay(Request $request){
        $hours = Hour::all();
        $tickets = Ticket::where('departament_id', $request->departament)
        ->whereMonth('created_at', $request->month)
        ->whereDay('created_at', $request->day)->get();
        
        if(count($tickets) == 0) return $this->returnSuccess(200, $hours);

        return $this->returnSuccess(200, $this->filterAvaibleHourByDay($tickets, $hours));

    }
    public function getNotAvaibleDay(Request $request){
       $tickets = Ticket::where('departament_id', $request->departament)
        ->whereMonth('created_at', date("m"))
        ->whereDay('created_at','>=', date("d"))
        ->groupBy('created_at')
        ->get(); 
        
        return $this->returnSuccess(200, $tickets);

    }
    
    private function filterAvaibleHourByDay($tickets, $hours){
        $listAppointment = json_decode(json_encode($tickets), true);
        $listHour = json_decode(json_encode($hours), true);
        for ($i=0; $i < count($listAppointment) ; $i++) { 
            $index = array_search($listAppointment[$i]['hour'], array_column($listHour, 'hour'));
            if(gettype($index) == 'integer') {
                unset($listHour[$index]);
                $listHour = [...$listHour];
            }
        }
        return $listHour;
    }
    private function endTicket ($departamentId, $status) {
        $ticket = Ticket::where('departament_id', $departamentId)->where('status', 2)->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59')->first();
        if(!$ticket) return ;
        $ticket->status = $status;
        $ticket->save();
    }

    private function setUserformat(Request $request){
        return $request->client_id 
        ?   Client::find($request->client_id)->id
        :   ClientController::storeClient($request)->id;
    }
    
    private function setNumberTicket($departamentId, $date){
        return DepartamentController::getCorrelative($departamentId, date("Y-m-d", strtotime( $date ?? 'now')));
    }

    private function checkLimitTicket($id){
        $departament = Departament::find($id);
        $tickes = Ticket::where('departament_id', $id)->whereDate('created_at', '=' , date('Y-m-d'))
        ->whereTime('created_at', '<', '23:59:59')->count();

        return $departament->limit == 0 
        ?  false
        : $departament->limit <= $tickes;
    }
}
