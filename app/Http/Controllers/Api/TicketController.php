<?php

namespace App\Http\Controllers\Api;

use App\Events\TicketEvent;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function createTicket(Request $request) {
        
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
        $this->endTicket($departamentId);
        $ticket = Ticket::where('departament_id', $departamentId)->where('status', 1)->first();
        if(!$ticket) return $this->returnFail(201, 'No hay tickets en cola');

        $ticket->status = 2;
        $ticket->save();
        event(new TicketEvent($departamentId));

        return $this->returnSuccess(200, $ticket);
    }
    private function endTicket ($departamentId) {
        $ticket = Ticket::where('departament_id', $departamentId)->where('status', 2)->first();
        if(!$ticket) return ;
        $ticket->status = 3;
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
}
