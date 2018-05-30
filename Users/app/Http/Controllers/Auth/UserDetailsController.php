<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserDetailsController extends Controller
{

    public function users(Request $request){
    
        $data = $request->all();

        $users = DB::select('select email,name,description from users where activated is true and email not like "'. $data['email'].'"');
            
                
        return response()->json(['users' => $users],200);
    }
    
}
