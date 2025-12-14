<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function login(LoginRequest $request)
    {
        // check if user from table users or admins
        $user  = User::where('email',$request->email)->first();
        $admin = Admin::where('email',$request->email)->first();

        // check if user is in users or password is correct
        if ($user && Hash::check($request->password,$user->password)) {
            // create access token for 10 min
            $token = $user->createToken('access_token', ['*'],now()->addMinutes(10))
                          ->plainTextToken;
            $type = 'user';
            $data = [
                    'name'     => $user->name,
                    'email'    => $user->email,
                ];

        // check if admin is in admins or password is correct
        }elseif($admin && Hash::check($request->password,$admin->password)){
            // create access token for 10 min
            $token = $admin->createToken('admin_token', ['*'],now()->addMinutes(10))
                           ->plainTextToken;
            $type = 'admin';
            $data = [
                    'name'     => $admin->name,
                    'email'    => $admin->email,
                ];
        }else{
            return response()->json([
                    'message' => 'email or password is not correct'
                ]);
        }

        return response()->json([
                'type'    => $type,
                'data'    => $data,
                'token'   => $token,
                'message' => 'login was successful'
            ]);

    }
}
