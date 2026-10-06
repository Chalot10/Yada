<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $users = User::where('groups', '2')->get();

        return view('admin.users.showDataUsers', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contacto' => 'required|string|max:15',
            'cargo' => 'required|string|max:100',
            'endereco' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        // Lógica para armazenar o usuário no banco de dados    
        if ($request->password !== $request->password_confirmation) 
        {
            return back()->withErrors(['password_confirmation' => 'As passwords não coincidem.'])->withInput();
        }

        $salt = Str::random(32);

        User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password . $salt), 
            'contacto' => $request->contacto,
            'dataNas' => $request->dataNasc,
            'salt' => $salt,
            'joined' => now(),
            'groups' => '2',
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // modal de edição pode ser implementado aqui se necessário
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'contacto' => 'required|string|max:15',
            'cargo' => 'required|string|max:100',
            'endereco' => 'required|string|max:255',
        ]);

        DB::table('users')
            ->where('id', $id)
            ->update([
                'nome' => $request->nome,
                'email' => $request->email,
                'contacto' => $request->contacto,
                // 'cargo' => $request->cargo,
                // 'endereco' => $request->endereco,
            ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        if($request->isMethod('delete'))
        {        
            DB::table('users')
            ->where('id', $id)
            ->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuário deletado com sucesso.');
    }
}
