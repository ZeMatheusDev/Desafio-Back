<?php

namespace App\Http\Controllers;

use App\Mail\SenhaMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(){
        return view('/home/home');
    }

    public function create(){
        return view('/home/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'max:50'],
        ], [
            'email.unique' => 'Este email já está em uso.',
            'email.required' => 'Digite um email.',
            'name.required' => 'Digite um nome.',
            'phone.required' => 'Digite um telefone.',
            'password.required' => 'Digite uma senha.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'deleted' => 0,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('home')->with(
            'success', 'Conta criada com sucesso!'
        );
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required']
        ], [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'senha.required' => 'A senha é obrigatória.'
        ]);

        $user = User::where('email', $validated['email'])
                ->where('deleted', 0)
                ->first();

        if (!$user || !Hash::check($validated['senha'], $user->password)) {
            return response()->json([
                'errors' => ['error' => ['Credenciais inválidas']],
                'message' => 'Verifique os erros no formulário'
            ], 422);
        }

        Auth::login($user);

        $request->session()->regenerate();

        $request->session()->put([
            'email' => $user->email,
            'nome' => $user->name
        ]);

        return redirect()->back();
    }

    public function senha(){
        return view('home/senha');
    }

    public function senhaStore(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required','email'],
        ],[
            'email.required' => 'O campo e‑mail é obrigatório.',
            'email.email'    => 'O e‑mail informado não é válido.',
        ]);
    
        $user = User::where('email', $validated['email'])
                    ->where('deleted', 0)
                    ->first();
    
        if (! $user) {
            return back()
                   ->withErrors(['email' => 'E‑mail não cadastrado.'])
                   ->withInput();
        }
    
        $plain = Str::random(8);
    
        $user->password = Hash::make($plain);
        $user->save();
    
        Mail::to($user->email)->send(new SenhaMail($plain));
    
        return redirect()
               ->route('home')
               ->with('success', 'Uma nova senha foi enviada para seu e‑mail.');
    }
    
}
