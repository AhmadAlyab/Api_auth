<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        // get user from db
        $user = User::where('email',$request->email)->first();

        // check user is correct
        if (!$user) {
            return response()->json([
                    'message' => 'email is not correct'
                ]);
        }

        //create new password
        $password = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);

        // update user in db for new password
        $user->update([
            'password' => Hash::make($password)
        ]);

        // send mail to user for see your password
        Mail::to($user->email)->send(new SendMail($password));

        return response()->json([
                    'message' => 'your password in your mail'
                ]);
    }
}
