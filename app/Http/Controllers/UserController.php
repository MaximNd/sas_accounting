<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountDataCreated;
use App\User;

class UserController extends Controller
{

    function getUserById($id) {
        return User::findOrFail($id);
    }

    function gatAllUsers() {
        return User::all();
    }

    function registerUser(Request $request) {
        $password = bin2hex(random_bytes(10));
        Mail::to($request->email)->send(new AccountDataCreated($password));
        $hashed_password = Hash::make($password);
        $user = new User([
            'role' => $request->role,
            'position' => $request->position,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'mid_name' => $request->mid_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => $hashed_password
        ]);
        $user->save();
    }
}
