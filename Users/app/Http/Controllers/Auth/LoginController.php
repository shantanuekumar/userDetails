<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    

    public function login(Request $request){
      
    $this->validateLogin($request);

    if ($this->attemptLogin($request)) {
        $user = $this->guard()->user();
        $user->generateToken();

        return response()->json([
            'data' => $user->toArray(),
        ]);
    }

    $data = $request->all();

    $condition = DB::select('select email,activated from users where email like "'.$data['email'].'"');
       
    if(!$condition){
        $response['error'] = 'email does not exist';
        $statusCode = 404;
    }
    
    else if(!$condition[0]->activated){
    $response['error'] = 'password not set';
    $statusCode = 401;
    
    }

    else{
        $response['error'] = 'Incorrect password ';
        $statusCode = 402;
    }
    
    return response()->json($response ,$statusCode);

    }


    public function logout(Request $request)
{
    $user = Auth::guard('api')->user();

    if ($user) {
        $user->api_token = null;
        $user->save();
    }

    return response()->json(['data' => 'User logged out.'], 200);
}


public function response(array $errors)
{
    //This will always return JSON object error messages
    return new JsonResponse($errors, 422);
}


}
