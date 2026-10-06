<?php

namespace App\Http\Controllers\Gestao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class FacturaController extends Controller
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
         $servicos = [
            (object)[
                'id' => 1,
                'nome' => 'Reserva de nome para empresa',
                'preco' => '300'
            ],
            (object)[
                'id' => 2,
                'nome' => 'Contrato de sociedade unipessoal Lda',
                'preco' => '2200'
            ],
            (object)[
                'id' => 3,
                'nome' => 'Contrato de sociedade por quotas Lda',
                'preco' => '3200'
            ],
             (object)[
                'id' => 4,
                'nome' => 'Contrato de sociedade anónima SA',
                'preco' => '5500'
            ],
             (object)[
                'id' => 5,
                'nome' => 'Acta de cessão de quotas',
                'preco' => '3500'
            ],
            (object)[
                'id' => 6,
                'nome' => 'Certidão comercial',
                'preco' => '4000'
        ],
            (object)[
                'id' => 7,
                'nome' => 'Declaração de início de actividade',
                'preco' => '4000'
            ],

        ];
  

        $dados = DB::table('servicos')->get();

        // $servicos = DB::table('')


        return view('gestao.facturas.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function processar(Request $request)
    {
        //
    }


    public function gerarPDF(Request $request)
    {
        //
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
