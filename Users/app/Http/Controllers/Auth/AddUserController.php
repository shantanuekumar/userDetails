<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;


class AddUserController extends Controller
{
    //

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users'
        ]);
    }


    protected function create(array $data)
    {
       
        return User::create([
            'email' => $data['email'],
            'activated' => false,
        ]);
    }

    public function addUser(Request $request)
        {
            // Here the request is validated. The validator method is located
            // inside the RegisterController, and makes sure the name, email
            // password and password_confirmation fields are required.
            $this->validator($request->all())->validate();



            // A Registered event is created and will trigger any relevant
            // observers, such as sending a confirmation email or any 
            // code that needs to be run as soon as the user is created.
            // event(new Registered($user = $this->create($request->all())));
            $user = $this->create($request->all());
            // After the user is created, he's logged in.

            // $this->guard()->login($user);

            // And finally this is the hook that we want. If there is no
            // registered() method or it returns null, redirect him to
            // some other URL. In our case, we just need to implement
            // that method to return the correct response.
            return $this->addedUser($request, $user)
                            ?:response()->json(['data' => 'success'], 201);
        }

    

    protected function addedUser(Request $request, $user)
    {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }


}
