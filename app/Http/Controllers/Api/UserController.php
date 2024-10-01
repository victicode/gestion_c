<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function storeUser(Request $request) {
        try {
			$validator = Validator::make($request->all(), [
				'email'=> 'required',
				'password'=>'required',
                'name' => 'required',
		    ]);
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'rol_id' => $request->rol ?? 1,
            ]);
		} catch (Exception $e) {
			return $this->returnFail(505,['message'=> $e->getMessage()]);
		}

        
        return $this->returnSuccess(200, $user);
    }
}
