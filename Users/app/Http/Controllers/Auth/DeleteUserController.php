<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;

class DeleteUserController extends Controller
{
    public function destroy(Request $request){
        
         $data = $request->all();

         DB::table('users')
            ->where('email',$data['email'])
            ->delete();


         return response()->json(['data' => 'success'], 201);
    }
}
