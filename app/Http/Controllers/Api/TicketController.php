<?php

namespace App\Http\Controllers\Api;

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
        
        return $this->returnSuccess(200,  $ticket->load('client')->load('departament'));
    }
    public function deleteTicket($ticketId){
        $ticket = Ticket::find($ticketId);
        if(!$ticket) return $this->returnFail(400, 'Ticket no encontrado');
        $ticket->delete();

        return $this->returnSuccess(200, $ticket);
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
