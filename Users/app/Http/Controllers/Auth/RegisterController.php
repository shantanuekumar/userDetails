<?php

namespace App\Http\Controllers\Auth;

use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            
        ]);
    }


     public function register(Request $request)
        {
            // Here the request is validated. The validator method is located
            // inside the RegisterController, and makes sure the name, email
            // password and password_confirmation fields are required.

            $data = $request->all();
            $condition = DB::select('select email from users where email like "'.$data['email'].'"');

            if($condition){
                $response['error'] = 'email already registered';
                $statusCode = 401;
                return response()->json($response ,$statusCode);
            }
            

            $this->validator($request->all())->validate();

            
            // A Registered event is created and will trigger any relevant
            // observers, such as sending a confirmation email or any 
            // code that needs to be run as soon as the user is created.
            event(new Registered($user = $this->create($request->all())));

            // After the user is created, he's logged in.
            $this->guard()->login($user);

            // And finally this is the hook that we want. If there is no
            // registered() method or it returns null, redirect him to
            // some other URL. In our case, we just need to implement
            // that method to return the correct response.
           
            return $this->registered($request, $user)?:response()->json(['data' =>'success'],201);
        }

    public function update(Request $request)
    {
        $data = $request->all();

        DB::table('users')
            ->where('email',$data['email'])
            ->update([
            'name' => $data['name'],
            'image' => $data['image'],
            'description' => $data['description']
 
        ]);

        $users = DB::select('select email,name,description from users where activated is true and email not like "'. $data['email'].'"');

        // return redirect()->back();
        // $this->registered($request, $user)
                            // ?: redirect($this->redirectPath());
            // return response()->json(['data' => 'success'], 201);
            return response()->json(['users' => $users],200);

    }

    



    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }

}
