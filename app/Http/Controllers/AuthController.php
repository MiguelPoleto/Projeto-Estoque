<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function loginPost(Request $request)
    {

    }

    public function register()
    {
        return view("auth.register");
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            "fullname" => "required",
            "email" => "required",
            "password" => "required",
            "password_confirmation" => "required|same:password",
            "phoneNumber" => "required"
        ]);

        $user = new User();
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phoneNumber;
        if ($user->save()) {
            return redirect()->route('login')->with('success', 'Cadastro realizado!');
        }
        return redirect()->route('register')->with('error', 'Falha ao realizar cadastro.');
    }
    
}
