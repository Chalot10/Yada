<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LoginController extends Controller
{
                
    public function index()
    {
        return view('auth.login');
    }

    
    
    public function create()
    {
        
    }


    // public function store(Request $request)
    // {
    //     $email = trim($request->input('email'));
    //     $Password = trim($request->input('password'));

    //     $user = User::where('email', $email)->first();

    //     $senhaComSalt = $Password . $user->salt;

    //     if (!$user || !Hash::check($senhaComSalt, $user->password)) 
    //     {
    //         session()->flash('erro', 'Login invalido');
    //         return redirect()->route('login');
    //     }
    //     else
    //     {    
    //         Auth::login($user);
    //         $request->session()->regenerate();
    
    //         if (Gate::allows('admin')) 
    //         {
    //             return redirect()->route('home');
    //         } 
    //         elseif (Gate::allows('avaliador')) 
    //         {
    //             return redirect()->route('home_gestor');
    //         } 
    //         else 
    //         {
    //             return redirect()->route('home_user');
    //         }
    //     }      
    // }

    public function authenticate(Request $request)
    {
        // 1. Validação
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = trim($request->email);
        $password = trim($request->password);

        // 2. Buscar utilizador
        $user = User::where('email', $email)->first();

        // 3. Verificar se existe
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email ou senha inválidos'
            ]);
        }

        // 4. Concatenar senha + salt
        $senhaComSalt = $password . $user->salt;

        // 5. Verificar senha
        if (!Hash::check($senhaComSalt, $user->password)) {
            return back()->withErrors([
                'password' => 'Email ou senha inválidos'
            ]);
        }
    
            Auth::login($user);
            $request->session()->regenerate();

            if (Gate::allows('admin')) {
                return redirect()->route('home');
            }
            
            if (Gate::allows('gestao')) {
                return redirect()->route('home_gestor');
            }

            return redirect()->route('login');
        
    }


    public function checkSession()
    {
        return Auth::check();
    }

    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }



    public function show(string $id)
    {
        //
    }



    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

 
    public function destroy(string $id)
    {
        //
    }
}
