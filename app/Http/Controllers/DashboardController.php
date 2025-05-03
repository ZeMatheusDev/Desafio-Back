<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(){    
        return view('dashboard/home');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
    
        return redirect()->route('home'); 
    }

    public function perfil(){
        $user = User::where('id', Auth::user()->id)->first();
        return view('dashboard/perfil', ['user' => $user]);
    }

    public function update(Request $request){
        /** @var User $user */

        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:11|min:11',
            'password' => 'nullable|string'
        ]);
    
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone']
        ];
    
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }
    
        $user->update($updateData);
    
        return redirect()->route('dashboard')->with('success', 'Perfil atualizado com sucesso!');
    }
}
