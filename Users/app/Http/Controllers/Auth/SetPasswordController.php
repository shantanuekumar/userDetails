<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


use DB;

class SetPasswordController extends Controller
{
    //
    protected function validator(array $data)
    {
        return Validator::make($data, [
            
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function setpassword(Request $request){
        
        $data = $request->all();
        $this->validator($request->all())->validate();

        if(DB::table('users')
        ->where('email',$data['email'])
        ->and('activated','<>',true)
        ->update(['password' => Hash::make($data['password']), 
                  'activated' => true])){
                      return response()->json(['data'=> 'password set successfully'], 201);
                  }
        else{
            $response['error'] = 'password already set';
            $statusCode = 401;
            return response()->json($response,$statusCode);
            
        }

    }

}
