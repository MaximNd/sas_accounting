<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountDataCreated;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Validator;

class UserController extends Controller
{

    function getUser(Request $request) {
        return $request->user();
    }

    function getUserById($id) {
        return User::findOrFail($id);
    }

    function gatAllUsers() {
        return User::orderBy('role')->get();
    }

    function updateUser(Request $request, $id) {
        $user = $request->user();
        if ($user->cannot('update-user', $id)) {
            return response()->json([
                'message' => 'You are not allowed to change information of this user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        $max_size = (int)ini_get('upload_max_filesize') * 1000;
        $this->validate($request, [
            'role' => Rule::in(['admin', 'user']),
            'email' => 'email|unique:users',
            'image' => 'image|max:'.$max_size,
            'telephone' => 'max:20',
            'password' => 'confirmed'
        ]);
        $updatedData = $request->all();
        if ($user->id !== intval($id) && $user->role === 'admin') {
            unset($updatedData['email']);
            unset($updatedData['password']);
        }
        if ($user->role === 'user') {
            unset($updatedData['role']);
        }

        if (isset($updatedData['password']) && isset($updatedData['password_confirmation'])) {
            $updatedData['password'] = Hash::make($updatedData['password']);
        }

        if (isset($request->image)) {
            $updatedData['image'] = $this->storeUserImage($request);
        }
        unset($updatedData['password_confirmation']);
        $res = User::where('id', $id)->update($updatedData);
        if (isset($updatedData['image']))
            return $updatedData['image'];
        else
            return $res;
    }

    function registerUser(Request $request) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to register new user'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        $max_size = (int)ini_get('upload_max_filesize') * 1000;
        $this->validate($request, [
            'role' => ['required', Rule::in(['admin', 'user'])],
            'position' => 'required|max:30',
            'last_name' => 'required|max:30',
            'first_name' => 'required|max:30',
            'mid_name' => 'required|max:30',
            'email' => 'required|email|unique:users',
            'image' => 'image|max:'.$max_size,
            'telephone' => 'required|max:20'
        ]);
        $imageName = 'no-avatar.png';
        if (isset($request->image)) {
            $imageName = $this->storeUserImage($request);
        }
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
            'image' => $imageName,
            'telephone' => $request->telephone,
            'password' => $hashed_password
        ]);
        $user->save();
        return $user;
    }

    function deleteUser(Request $request, $id) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'You are not allowed to deleting users'
            ])->setStatusCode(Response::HTTP_FORBIDDEN, Response::$statusTexts[Response::HTTP_FORBIDDEN]);
        }
        return User::destroy($id);
    }

    public function checkUniqueEmail($email) {
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        } else {
            return response()->json(['success' => true, 'message' => 'success'], 200);
        }
    }

    private function storeUserImage($request) {
        $image = $request->file('image');
        $imageName = uniqid('avatar_') . $image->getClientOriginalName();
        Storage::disk('public')->putFileAs('/', $image, $imageName);
        return $imageName;
    }
}
