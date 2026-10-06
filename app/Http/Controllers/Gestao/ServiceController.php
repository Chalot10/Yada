<?php

namespace App\Http\Controllers\Gestao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use Illuminate\Support\Facades\DB;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $categorias = [
                (object)[
                    'id' => 1,
                    'nome' => 'Serviços de Registo de Empresas'
                ],
                (object)[
                    'id' => 2,
                    'nome' => 'Serviços de Recursos Humanos'
                ],
                (object)[
                    'id' => 3,
                    'nome' => 'Serviços de Contabilidade'
                ],
                (object)[
                    'id' => 4,
                    'nome' => 'Outros Serviços'
                ],
            ];

        return view('gestao.servicos.add', compact('categorias'));
    }


    
    public function store(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string|max:255',
            'servicos' => 'required|array|min:1',
            'servicos.*.nome' => 'required|string|max:255',
            'servicos.*.preco' => 'required|numeric|min:0',
        ]);


        foreach ($request->servicos as $servico) {
            Servico::create([
                'nomeService' => $servico['nome'],
                'precoServico' => $servico['preco'],
                'categoria' => $request->categoria,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        
    }

        return redirect()->route('gestao.servicos.showAll')->with('success', 'Serviços adicionados com sucesso.');
    }


    public function showAll()
    {

        $servicos = Servico::all();

        return view('gestao.servicos.show', compact('servicos'));
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
           $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0'
        ]);

        DB::table('servicos')
            ->where('id', $id)
            ->update([
                'nomeService' => $request->nome,
                'categoria' => $request->categoria,
                'precoServico' => $request->preco,
            ]);

        return redirect()->route('gestao.servicos.showAll')->with('success', 'Serviço actualizado com sucesso.');
  
    }


    public function destroy(Request $request, string $id)
    {
        if($request->isMethod('delete'))
        {        
            DB::table('servicos')
            ->where('id', $id)
            ->delete();
        }

        return redirect()->route('gestao.servicos.showAll')->with('success', 'Serviço deletado com sucesso.');
    }


    public function catalogo()
    {
        $servicos = Servico::where('status', 0)->get();

        return view('gestao.servicos.catalogo', compact('servicos'));
    }

    public function cartao()
    {


        return view('gestao/servicos.cartao');
    }
}
