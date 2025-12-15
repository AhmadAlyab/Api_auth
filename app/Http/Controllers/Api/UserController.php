<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // get all users from db
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    public function update(UpdateUserRequest $request)
    {
        // get user from db
        $user = User::findOrFail($request->id);

        // update user in db
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'updated was successful']);
    }

    public function destroy($id)
    {
        // delete user from db
        User::findOrFail($id)->delete();

        return response()->json(['message' => 'deleted was successful']);
    }
}
