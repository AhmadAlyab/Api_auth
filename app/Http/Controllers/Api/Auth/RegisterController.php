<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // verification from password
        if($request->password !== $request->confirm_password){
             return response()->json(['message' => 'The two passwords do not match']);
        }

        // create user in db
        $user = User::create([
            'name'      => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        // create access token for 10 min
        $token = $user->createToken('access_token', ['*'],now()->addMinutes(10))->plainTextToken;


        // return response for successfuly
        return response()->json([
            'user'    => [
                'name' => $request->name,
                'email'=> $request->email
            ],
            'token'   => $token,
            'message' => 'Registration was successful'
        ],200);
    }
}
