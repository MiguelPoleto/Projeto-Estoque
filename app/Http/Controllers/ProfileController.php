<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado');
        }
        
        return view('profile', compact('user'));
    }
    
    public function updatePost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:14',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'city' => 'nullable|string|max:100',
            'street' => 'nullable|string|max:100',
            'house_number' => 'nullable|string|max:10',
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Usuário não encontrado');
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->city = $request->input('city');
        $user->street = $request->input('street');
        $user->house_number = $request->input('house_number');

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();
        return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso');
    }
}
