<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        if ($request->password !== $request->password_confirmation) 
        {
            return back()->withErrors(['password_confirmation' => 'As passwords não coincidem.'])->withInput();
        }

        $salt = Str::random(32);


        User::create([
            'nome' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password . $salt), 
            'contacto' => '840000000',
            'dataNas' => '2000-01-01',
            'salt' => $salt,
            'joined' => now(),
            'groups' => '1',
        ]);

        return redirect('/')->with('success', 'Registration successful. Please login.');
    }


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
