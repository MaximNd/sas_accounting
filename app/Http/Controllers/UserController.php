<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountDataCreated;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

class UserController extends Controller
{

    function getUserById($id) {
        return User::findOrFail($id);
    }

    function gatAllUsers() {
        return User::all();
    }

    function updateUser(Request $request, $id) {
        $user = $request->user();
        if ($user->cannot('update-user', $id)) {
            return response()->json([
                'message' => 'You are not allowed to change information of this user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }

        $this->validate($request, [
            'role' => Rule::in(['admin', 'user']),
            'email' => 'email|unique:users',
            'telephone' => 'max:20',
            'password' => 'confirmed'
        ]);
        $updatedData = $request->all();
        if ($user->id !== $id && $user->role === 'admin') {
            unset($updatedData['email']);
            unset($updatedData['password']);
        }
        if ($user->role === 'user') {
            unset($updatedData['role']);
        }
        if ($updatedData['password'] && $updatedData['password_confirmation']) {
            $updatedData['password'] = Hash::make($updatedData['password']);
        }
        unset($updatedData['password_confirmation']);
        return User::where('id', $id)->update($updatedData);
    }

    function registerUser(Request $request) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to register new user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        $this->validate($request, [
            'role' => ['required', Rule::in(['admin', 'user'])],
            'position' => 'required|max:30',
            'last_name' => 'required|max:30',
            'first_name' => 'required|max:30',
            'mid_name' => 'required|max:30',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|max:20'
        ]);
        $password = bin2hex(random_bytes(10));
        Mail::to($request->email)->send(new AccountDataCreated($request->email, $password));
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

    function deleteUser(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to deleting users'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        return User::destroy($id);
    }
}
