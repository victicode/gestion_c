<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function createTicket(Request $request) {
        
        // $ticket = Ticket::create([
        //     'number'            => $this->setNumberTicket($request->departament_id),
        //     'client_id'         => $this->setUserformat($request),
        //     'departament_id'    => $request->departament_id,
        //     'type'              => 1,
        //     'status'            => 1,
        // ]);
        
        return $this->returnSuccess(200, $this->setNumberTicket($request->departament_id));
    }
    private function setUserformat(Request $request){
        return $request->client_id 
        ?   Client::find($request->client_id)->id
        :   ClientController::storeClient($request)->id;
    }
    private function setNumberTicket($departamentId){
        $number = ''


        return DepartamentController::getCorrelative($departamentId);
    }
}
