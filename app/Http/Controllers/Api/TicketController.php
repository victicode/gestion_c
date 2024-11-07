<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Ticket;
use App\Events\TicketEvent;
use App\Events\DisplayEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departament;

class TicketController extends Controller
{
    public function createTicket(Request $request) {
        if($this->checkLimitTicket($request->departament_id)) return $this->returnFail(201, 'Has alcanzado el limites de cita por día en el departamento');
        
        $ticket = Ticket::create([
            'number'            => $this->setNumberTicket($request->departament_id),
            'client_id'         => $this->setUserformat($request),
            'departament_id'    => $request->departament_id,
            'type'              => 1,
            'status'            => 1,
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
    private function setNumberTicket($departamentId){
        return DepartamentController::getCorrelative($departamentId);
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
