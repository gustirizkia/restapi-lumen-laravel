<?php

namespace App\Http\Controllers;

use App\User;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $hasPassword = Hash::make($password);
        $user = User::create([
            'email' => $email,
            'password' => $hasPassword
        ]);

        return response()->json(['messege' => 'Regis Success'], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'=> 'required|email',
            'password'=> 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json(['message' => 'Email Salah'], 401);
        }

        $cekPassword = Hash::check($password, $user->password);
        if(!$cekPassword){
            return response()->json(['message' => 'Password Salah'], 401);
        }

        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);

        return response()->json($user);
    }
}
