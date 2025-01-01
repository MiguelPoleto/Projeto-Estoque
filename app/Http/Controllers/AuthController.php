<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if (FacadesAuth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/opcoes');
        } else {
            return redirect()->back()->with('error', 'Credenciais inválidas.');
        }
    }

    public function logout()
    {
        FacadesAuth::logout();
        return redirect()->route('home');
    }

    public function register()
    {
        return view("auth.register");
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            "fullname" => "required",
            "email" => "required|email|unique:users,email",
            "phone_number" => "required|min:11",
            "password" => "required|min:6",
            "passwordConfirmation" => "required|same:password"
        ]);

        $user = new User();
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        if ($user->save()) {
            return redirect()->route('login')->with('success', 'Cadastro realizado!');
        }
        return redirect()->route('register')->with('error', 'Falha ao realizar cadastro.');
    }
    
}
