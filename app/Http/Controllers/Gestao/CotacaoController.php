<?php

namespace App\Http\Controllers\Gestao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Servico;
use App\Models\Cotacao;
use App\Models\CotacaoServico;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Cliente;
use App\Models\ValoresCotacao;
use App\Models\HistoricoValoresCotacao;
use App\Models\HistoricoCotacao;
use App\Models\HistoricoCliente;
use App\Library\PDF\CotacaoPDF;



class CotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

     /**
     * Contador estático para números sequenciais de cotação
     * Mantém o valor entre requisições durante a mesma sessão
     */
    protected static $contadorCotacao = 1000; // Começa em 1000 (ou o valor que desejar)
    protected static $numerosGerados = [];

        
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        // Incrementa o contador a cada nova abertura da view
        self::$contadorCotacao++;
        
        // Formatar o número sequencial
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        $sequencial = str_pad(self::$contadorCotacao, 5, '0', STR_PAD_LEFT);
        
        // Gerar número da cotação: COT-ANO-MES-DIA-SEQUENCIAL
        $numeroCotacao = "COT-{$ano}{$mes}{$dia}-{$sequencial}";
        
        // Armazenar para debug (opcional)
        self::$numerosGerados[] = $numeroCotacao;
        
        // Log para verificar (opcional)
        Log::info('Nova cotação gerada:', [
            'numero' => $numeroCotacao,
            'contador' => self::$contadorCotacao,
            'total_gerados' => count(self::$numerosGerados)
        ]);
        
        $dados = DB::table('servicos')->get();

        return view('gestao.cotacoes.create', compact('dados', 'numeroCotacao'));
    }
    
    /**
     * Método para resetar o contador (útil para testes)
     */
    public function resetarContador()
    {
        self::$contadorCotacao = 0001;
        self::$numerosGerados = [];
        
        return response()->json([
            'success' => true,
            'message' => 'Contador resetado para 1000'
        ]);
    }
    
    /**
     * Método para obter o próximo número 
     */
    public function getProximoNumero()
    {
        self::$contadorCotacao++;
        
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        $sequencial = str_pad(self::$contadorCotacao, 5, '0', STR_PAD_LEFT);
        
        $numeroCotacao = "COT-{$ano}{$mes}{$dia}-{$sequencial}";
        
        return response()->json([
            'success' => true,
            'numero_cotacao' => $numeroCotacao,
            'contador' => self::$contadorCotacao
        ]);
    }
    
    /**
     * Método para visualizar os números gerados (para debug)
     */
    public function verNumerosGerados()
    {
        return response()->json([
            'contador_atual' => self::$contadorCotacao,
            'numeros_gerados' => self::$numerosGerados,
            'total' => count(self::$numerosGerados)
        ]);
    }

 
    public function processar(Request $request)
    {
        // Validação corrigida
        $validator = Validator::make($request->all(), [
            'nome_cliente' => 'required|min:3',
            'numero_cotacao' => 'required',
            'data_emissao' => 'required|date',
            'servicos' => 'required|array|min:1',
            'servicos.*.servico_id' => 'required',
            'servicos.*.quantidade' => 'required|integer|min:1',
            'servicos.*.preco_unitario' => 'required|numeric|min:0',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // $qrCodeData = $this->gerarQRCodeData($cotacao);

            $empresa = (object)[
                'nome' => 'Yada Key Consulting and Services',
                'nuit' => '999999999',
                'endereco' => 'Maputo, Moçambique',
                'telefone' => '+258 84 913 0222',
                'email' => 'yada@fbn.com',
                'website' => 'www.yada.com',
            ];
            
            // Calcular totais
            $subtotal = 0;
            $servicosDetalhados = [];
            
            foreach ($request->servicos as $index => $servicoData) {
                $precoUnitario = floatval($servicoData['preco_unitario']);
                $quantidade = intval($servicoData['quantidade']);
                $desconto = floatval($servicoData['desconto'] ?? 0);
                
                $nomeServico = $servicoData['nome'] ?? 'Serviço #' . $servicoData['servico_id'];
                
                // Calcular valores
                $subtotalServico = $precoUnitario * $quantidade;
                $valorDescontoServico = $subtotalServico * ($desconto / 100);
                $subtotalComDescontoServico = $subtotalServico - $valorDescontoServico;
                
                $servicosDetalhados[] = [
                    'nome' => $nomeServico,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $precoUnitario,
                    'desconto_percent' => $desconto,
                    'desconto_valor' => $valorDescontoServico,
                    'subtotal' => $subtotalComDescontoServico,
                    'preco_formatado' => number_format($precoUnitario, 2, ',', '.'),
                    'desconto_formatado' => number_format($valorDescontoServico, 2, ',', '.'),
                    'subtotal_formatado' => number_format($subtotalComDescontoServico, 2, ',', '.'),
                ];
                
                $subtotal += $subtotalComDescontoServico;
            }
            
            // Aplicar desconto global
            $descontoGlobal = floatval($request->desconto ?? 0);
            $valorDescontoGlobal = $subtotal * ($descontoGlobal / 100);
            $subtotalComDesconto = $subtotal - $valorDescontoGlobal;
            
            // Calcular IVA (16%)
            $ivaPercent = 16;
            $iva = $subtotalComDesconto * ($ivaPercent / 100);
            $total = $subtotalComDesconto + $iva;
            
            // Calcular data de validade
            $dataEmissao = new \DateTime($request->data_emissao);
            $validadeDias = intval($request->validade_dias ?? 15);
            $dataValidade = clone $dataEmissao;
            $dataValidade->modify("+{$validadeDias} days");
            

            $cliente = Cliente::create([
                'nome' => $request->nome_cliente,
                'nuit' => $request->nuit,
                'endereco' => $request->endereco,
                'contacto' => $request->contacto,
            ]);
            
            // Salvar histórico do cliente

            $historicoCliente = HistoricoCliente::create([
                    'nome' => $cliente->nome,
                    'nuit' => $cliente->nuit,
                    'endereco' => $cliente->endereco,
                    'contacto' => $cliente->contacto,
            ]);


            if($request->status == 'Pendente'){
                $status = 0;
            } elseif($request->status == 'Aprovada'){
                $status = 1;
            } elseif($request->status == 'Rejeitada'){
                $status = 2;
            } else{
                $status = 0;
            }



            // Salvar serviços da cotação
            foreach ($request->servicos as $servicoData) {
                $cotacao = Cotacao::create([
                    'numero_cotacao' => $request->numero_cotacao,
                    'data_emissao' => $request->data_emissao,
                    'validade_dias' => $validadeDias,
                    'data_validade' => $dataValidade->format('Y-m-d'),
                    'status' => $status,
                    'quantidade' => $servicoData['quantidade'],
                    'preco_unitario' => $servicoData['preco_unitario'],
                    // 'subtotal' => $servicoData['preco_unitario'] * $servicoData['quantidade'] * 
                    //             (1 - ($servicoData['desconto'] ?? 0) / 100),
                    'id_cliente' => $cliente->id,
                    'id_servico' => $servicoData['servico_id'],
                    'id_user' => auth()->user()->id,
                ]);


                $valoresCotacao = ValoresCotacao::create([
                    'subtotal' => $servicoData['preco_unitario'] * $servicoData['quantidade'] * (1 - ($servicoData['desconto'] ?? 0) / 100),
                    'desconto_global_percent' => $descontoGlobal,
                    'desconto_global_valor' => $valorDescontoGlobal,
                    'subtotal_com_desconto' => $subtotalComDesconto,
                    'iva_percent' => $ivaPercent,
                    'iva_valor' => $iva,
                    'total' => $total,
                    'prazo_pagamento' => $request->prazo_pagamento,
                    'pago' => 0,
                    'idCotacao' => $cotacao->id,
                ]);

                // Salvar histórico da cotação

                $historicoCotacao = HistoricoCotacao::create([
                    'numero_cotacao' => $request->numero_cotacao,
                    'data_emissao' => $request->data_emissao,
                    'validade_dias' => $validadeDias,
                    'data_validade' => $dataValidade->format('Y-m-d'),
                    'status' => $status,
                    'quantidade' => $servicoData['quantidade'],
                    'preco_unitario' => $servicoData['preco_unitario'],
                    'nome_servico' => $servicoData['nome'] ?? 'Serviço #' . $servicoData['servico_id'],
                    'id_cliente' => $historicoCliente->id,
                    'id_servico' => $servicoData['servico_id'],
                    'id_user' => auth()->user()->id,
                ]);


                $historicoValoresCotacao = HistoricoValoresCotacao::create([
                    'subtotal' => $servicoData['preco_unitario'] * $servicoData['quantidade'] * (1 - ($servicoData['desconto'] ?? 0) / 100),
                    'desconto_global_percent' => $descontoGlobal,
                    'desconto_global_valor' => $valorDescontoGlobal,
                    'subtotal_com_desconto' => $subtotalComDesconto,
                    'iva_percent' => $ivaPercent,
                    'iva_valor' => $iva,
                    'total' => $total,
                    'prazo_pagamento' => $request->prazo_pagamento,
                    'pago' => 0,
                    'idHistCotacao' => $historicoCotacao->id,
                ]);

            }

            DB::commit();
            
            // Preparar resposta
            return response()->json([
                'success' => true,
                'message' => 'Cotação processada com sucesso!',
                'cotacao_id' => 1,
                'recibo' => [
                    'empresa' => [
                        'nome' => $empresa->nome,
                        'nuit' => $empresa->nuit,
                        'endereco' => $empresa->endereco,
                        'telefone' => $empresa->telefone,
                        'email' => $empresa->email,
                        'website' => $empresa->website,
                    ],
                    
                    'cotacao' => [
                        'id' => 1,
                        'numero' => $request->numero_cotacao,
                        'data_emissao' => date('d/m/Y', strtotime($request->data_emissao)),
                        'data_validade' => $dataValidade->format('d/m/Y'),
                        'validade_dias' => $validadeDias,
                        'status' => $request->status ?? 'Pendente',
                        'status_badge' => ['bg-green-100 text-green-800', 'Pendente'],
                    ],
                    
                    'cliente' => [
                        'nome' => $request->nome_cliente,
                        'nuit' => $request->nuit ?? 'Não informado',
                        'endereco' => $request->endereco ?? 'Não informado',
                        'contacto' => $request->contacto,
                    ],
                    
                    'servicos' => $servicosDetalhados,
                    
                    'valores' => [
                        'subtotal' => $subtotal,
                        'subtotal_formatado' => number_format($subtotal, 2, ',', '.'),
                        
                        'desconto_global_percent' => $descontoGlobal,
                        'desconto_global_valor' => $valorDescontoGlobal,
                        'desconto_global_formatado' => number_format($valorDescontoGlobal, 2, ',', '.'),
                        
                        'subtotal_com_desconto' => $subtotalComDesconto,
                        'subtotal_com_desconto_formatado' => number_format($subtotalComDesconto, 2, ',', '.'),
                        
                        'iva_percent' => $ivaPercent,
                        'iva_valor' => $iva,
                        'iva_formatado' => number_format($iva, 2, ',', '.'),
                        
                        'total' => $total,
                        'total_formatado' => number_format($total, 2, ',', '.'),
                        
                        'total_extenso' => $this->valorPorExtenso($total) ?? 'Meticais ' . number_format($total, 2, ',', '.'),
                    ],
                    
                    'pagamento' => [
                        'prazo' => $request->prazo_pagamento,
                        'prazo_dias' => is_numeric($request->prazo_pagamento) ? 
                                    $request->prazo_pagamento . ' dias' : 
                                    ($request->prazo_personalizado ?? 'A combinar'),
                    ],
                    
                    'observacoes' => 'Esta cotação é válida até ' . $dataValidade->format('d/m/Y') . '. Para dúvidas, contacte-nos.',
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erro ao processar cotação: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao processar cotação: ' . $e->getMessage()
            ], 500);
        }
    }
   
    private function getStatusBadge($status)
    {
        $badges = [
            'Pendente' => ['bg-yellow-100 text-yellow-800', 'Pendente'],
            'Aprovada' => ['bg-green-100 text-green-800', 'Aprovada'],
            'Rejeitada' => ['bg-red-100 text-red-800', 'Rejeitada'],
            'Convertida' => ['bg-blue-100 text-blue-800', 'Convertida em Fatura'],
        ];
        
        return $badges[$status] ?? $badges['Pendente'];
    }
    
/*
    private function valorPorExtenso($valor)
    {
        $unidades = [
            '', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis',
            'sete', 'oito', 'nove', 'dez', 'onze', 'doze',
            'treze', 'catorze', 'quinze', 'dezasseis',
            'dezassete', 'dezoito', 'dezanove'
        ];

        $dezenas = [
            '', '', 'vinte', 'trinta', 'quarenta',
            'cinquenta', 'sessenta', 'setenta',
            'oitenta', 'noventa'
        ];

        $centenas = [
            '', 'cem', 'duzentos', 'trezentos',
            'quatrocentos', 'quinhentos',
            'seiscentos', 'setecentos',
            'oitocentos', 'novecentos'
        ];

        $valor = number_format($valor, 2, '.', '');
        [$inteiro, $centavos] = explode('.', $valor);

        $extensoInteiro = $this->numeroPorExtenso($inteiro, $unidades, $dezenas, $centenas);
        $extensoCentavos = $this->numeroPorExtenso($centavos, $unidades, $dezenas, $centenas);

        $resultado = '';

        if ($inteiro > 0) {
            $resultado .= ucfirst($extensoInteiro) . ' meticais';
    }

    if ($centavos > 0) {
        $resultado .= ($inteiro > 0 ? ' e ' : '');
        $resultado .= $extensoCentavos . ' centavos';
    }

    return $resultado;
}

*/


    /**
 * Converte um valor numérico para sua representação por extenso em português (moçambicano/brasileiro).
 *
 * @param float $valor
 * @return string
 */
private function valorPorExtenso($valor)
{
    $valor = number_format($valor, 2, '.', '');
    [$inteiro, $centavos] = explode('.', $valor);

    $extensoInteiro = $this->numeroExtensoCompleto($inteiro);
    $extensoCentavos = $this->numeroExtensoGrupo($centavos, 0);

    if ($inteiro == 0) {
        $resultado = 'Zero meticais';
    } else {
        $resultado = ucfirst($extensoInteiro) . ' meticais';
    }

    if ($centavos > 0) {
        $resultado .= ($inteiro > 0 ? ' e ' : '') . $extensoCentavos . ' centavos';
    }

    return $resultado;
}

/**
 * Converte um número inteiro (até trilhões) para sua representação por extenso.
 *
 * @param int|string $numero
 * @return string
 */
private function numeroExtensoCompleto($numero)
{
    $numero = (int)$numero;
    if ($numero == 0) {
        return 'zero';
    }

    // Divide o número em grupos de 3 dígitos da direita para a esquerda
    $grupos = array_reverse(str_split(str_pad($numero, ceil(strlen($numero) / 3) * 3, '0', STR_PAD_LEFT), 3));
    $classes = ['', 'mil', 'milhão', 'bilhão', 'trilhão'];

    $partes = [];

    foreach ($grupos as $indice => $grupo) {
        $valorGrupo = intval($grupo);
        if ($valorGrupo == 0) {
            continue;
        }

        $extensoGrupo = $this->numeroExtensoGrupo($valorGrupo, $indice);
        $classe = $classes[$indice];

        if ($classe) {
            if ($indice == 1) { // milhares
                if ($valorGrupo == 1) {
                    $extensoGrupo = ''; // "mil" em vez de "um mil"
                }
            } elseif ($indice >= 2) { // milhões, bilhões, trilhões
                if ($valorGrupo == 1) {
                    $extensoGrupo = 'um'; // "um milhão", "um bilhão"
                } else {
                    // Aplica plural
                    $pluralMap = [
                        'milhão'  => 'milhões',
                        'bilhão'  => 'bilhões',
                        'trilhão' => 'trilhões',
                    ];
                    if (isset($pluralMap[$classe])) {
                        $classe = $pluralMap[$classe];
                    }
                }
            }
        }

        $partes[] = trim($extensoGrupo . ' ' . $classe);
    }

    // Reverte para ordem crescente (maior para menor)
    $partes = array_reverse($partes);
    return implode(' e ', $partes);
}

/**
 * Converte um número de 0 a 999 para sua representação por extenso.
 *
 * @param int $numero
 * @param int $indiceGrupo (não utilizado, mantido para compatibilidade)
 * @return string
 */
private function numeroExtensoGrupo($numero, $indiceGrupo = 0)
{
    $unidades = [
        '', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis',
        'sete', 'oito', 'nove', 'dez', 'onze', 'doze',
        'treze', 'catorze', 'quinze', 'dezasseis',
        'dezassete', 'dezoito', 'dezanove'
    ];

    $dezenas = [
        '', '', 'vinte', 'trinta', 'quarenta',
        'cinquenta', 'sessenta', 'setenta',
        'oitenta', 'noventa'
    ];

    $centenas = [
        '', 'cento', 'duzentos', 'trezentos',
        'quatrocentos', 'quinhentos',
        'seiscentos', 'setecentos',
        'oitocentos', 'novecentos'
    ];

    if ($numero == 0) {
        return '';
    }

    $numero = str_pad($numero, 3, '0', STR_PAD_LEFT);
    $centena = intval($numero[0]);
    $dezena = intval($numero[1]);
    $unidade = intval($numero[2]);

    $texto = [];

    if ($centena > 0) {
        if ($centena == 1 && $dezena == 0 && $unidade == 0) {
            $texto[] = 'cem';
        } else {
            $texto[] = $centenas[$centena];
        }
    }

    if ($dezena == 1) {
        $texto[] = $unidades[$dezena * 10 + $unidade];
    } else {
        if ($dezena > 1) {
            $texto[] = $dezenas[$dezena];
        }
        if ($unidade > 0) {
            $texto[] = $unidades[$unidade];
        }
    }

    return implode(' e ', $texto);
}



    private function numeroPorExtenso($numero, $u, $d, $c)
    {
        if ($numero == 0) {
            return 'zero';
        }

        $numero = str_pad($numero, 3, '0', STR_PAD_LEFT);
        $centena = intval($numero[0]);
        $dezena = intval($numero[1]);
        $unidade = intval($numero[2]);

        $texto = [];

        if ($centena > 0) {
            if ($centena == 1 && $dezena == 0 && $unidade == 0) {
                $texto[] = 'cem';
            } else {
                $texto[] = $c[$centena];
            }
        }

        if ($dezena == 1) {
            $texto[] = $u[$dezena * 10 + $unidade];
        } else {
            if ($dezena > 1) {
                $texto[] = $d[$dezena];
            }
            if ($unidade > 0) {
                $texto[] = $u[$unidade];
            }
        }

        return implode(' e ', $texto);
    }


    private function gerarQRCodeData($dados)
    {
        return [
            'texto' => "COTAÇÃO: " . ($dados['cotacao']['numero'] ?? '') . "\n" .
                      "CLIENTE: " . ($dados['cliente']['nome'] ?? '') . "\n" .
                      "VALOR: " . ($dados['valores']['total_formatado'] ?? '') . "\n" .
                      "DATA: " . ($dados['cotacao']['data_emissao'] ?? ''),
            'url' => url('/cotacao/visualizar/' . ($dados['cotacao']['id'] ?? '')),
        ];
    }


    // private function gerarQRCodeData($cotacao)
    // {
    //     // Criar texto para o QR Code
    //     $textoQR = "COTAÇÃO DE SERVIÇOS\n" .
    //                "Número: {$cotacao->numero_cotacao}\n" .
    //                "Cliente: {$cotacao->nome_cliente}\n" .
    //                "Valor Total: MZN " . number_format($cotacao->total, 2, ',', '.') . "\n" .
    //                "Data: " . date('d/m/Y', strtotime($cotacao->data_emissao)) . "\n" .
    //                "Validade: " . date('d/m/Y', strtotime($cotacao->data_validade)) . "\n" .
    //                "Status: {$cotacao->status}\n" .
    //                "---\n" .
    //                "Yada Key Consulting and Services\n" .
    //                "consulte em: " . url('/cotacoes/' . $cotacao->id);
        
    //     // Gerar QR Code como base64
    //     $qrCodeBase64 = $this->gerarQRCodeBase64($textoQR);
        
    //     return [
    //         'texto' => $textoQR,
    //         'base64' => $qrCodeBase64,
    //         'numero' => $cotacao->numero_cotacao
    //     ];
    // }
    
    private function gerarQRCodeBase64($texto)
    {
        // Gerar QR Code e converter para base64
        $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->color(44, 82, 130) // Cor da marca (#2c5282)
            ->backgroundColor(255, 255, 255)
            ->generate($texto);
        
        return 'data:image/png;base64,' . base64_encode($qrCode);
    }
    
    // Método para exibir QR Code individual
    public function mostrarQRCode($id)
    {
        $cotacao = Cotacao::findOrFail($id);
        $textoQR = $this->gerarTextoQR($cotacao);
        
        return view('cotacoes.qrcode', compact('textoQR', 'cotacao'));
    }
    
    // Método para download do QR Code
    public function downloadQRCode($id)
    {
        $cotacao = Cotacao::findOrFail($id);
        $textoQR = $this->gerarTextoQR($cotacao);
        
        return response(QrCode::format('png')
            ->size(400)
            ->generate($textoQR))
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="QRCode_Cotacao_' . $cotacao->numero_cotacao . '.png"');
    }



    public function enviarWhatsApp(Request $request)
    {
        try {
            $dados = $request->all();
            
            // Aqui você pode integrar com uma API de WhatsApp como:
            // - Twilio
            // - WhatsApp Business API
            // - Serviço próprio
            
            // Por enquanto, retornamos sucesso
            return response()->json([
                'success' => true,
                'message' => 'Mensagem do WhatsApp preparada com sucesso!',
                'whatsapp_link' => 'https://wa.me/...' // Link gerado
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar WhatsApp: ' . $e->getMessage()
            ], 500);
        }
    }

    public function enviarEmail(Request $request)
    {
        // try {
        //     $dados = $request->all();
            
        //     // Enviar email usando Laravel Mail
        //     Mail::to($dados['to_email'])->send(new CotacaoEmail($dados));
            
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Email enviado com sucesso!'
        //     ]);
            
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Erro ao enviar email: ' . $e->getMessage()
        //     ], 500);
        // }
    }




    // CotacaoController.php
   
    //    public function visualizar($id)
    // {
    //     try {
    //         // Buscar cotação com relacionamentos
    //         $cotacao = Cotacao::with([
    //             'cliente',
    //             'servicos.servico', // Ajuste conforme sua estrutura
    //             'categoria'
    //         ])->findOrFail($id);
            
    //         // Verificar se é requisição AJAX
    //         if (request()->ajax() || request()->wantsJson()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'html' => view('gestao.cotacoes.partials.detalhes', compact('cotacao'))->render()
    //             ]);
    //         }
            
    //         // Se não for AJAX, retornar view normal
    //         return view('gestao.cotacoes.show', compact('cotacao'));
            
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         if (request()->ajax() || request()->wantsJson()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Cotação não encontrada'
    //             ], 404);
    //         }
    //         abort(404);
            
    //     } catch (\Exception $e) {
    //         if (request()->ajax() || request()->wantsJson()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Erro interno do servidor: ' . $e->getMessage()
    //             ], 500);
    //         }
    //         abort(500);
    //     }
    // }
   

    // app/Http/Controllers/Gestao/CotacaoController.php
// public function visualizar($id)
// {
//     try {
//         // Buscar cotação com relacionamentos corretos
//         $cotacao = Cotacao::with([
//             'cliente',
//             'servico',  // Singular, não plural
//             'user'
//         ])->findOrFail($id);
        
//         // Verificar se é requisição AJAX
//         if (request()->ajax() || request()->wantsJson()) {
//             return response()->json([
//                 'success' => true,
//                 'html' => view('gestao.cotacoes.partials.detalhes', compact('cotacao'))->render()
//             ]);
//         }
        
//         // Se não for AJAX, retornar view normal
//         return view('gestao.cotacoes.show', compact('cotacao'));
        
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         if (request()->ajax() || request()->wantsJson()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Cotação não encontrada'
//             ], 404);
//         }
//         abort(404);
        
//     } catch (\Exception $e) {
//         if (request()->ajax() || request()->wantsJson()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Erro interno do servidor: ' . $e->getMessage()
//             ], 500);
//         }
//         abort(500);
//     }
// }

    // public function visualizar($id)
    // {
    //     $cotacao = Cotacao::with(['cliente', 'servicos', 'categoria'])->findOrFail($id);
        
    //     if (request()->ajax()) {
    //         return response()->json([
    //             'html' => view('partials.cotacao-detalhes', compact('cotacao'))->render()
    //         ]);
    //     }
        
    //     return view('cotacao.visualizar', compact('cotacao'));
    // }

  
    // // FacturaController.php
    public function criarDaCotacao(Request $request)
    {
        try {
            $request->validate([
                'cotacao_id' => 'required|exists:cotacoes,id',
                'numero_fatura' => 'required|string|unique:faturas,numero_fatura',
                'data_emissao' => 'required|date',
            ]);
            
            // Lógica para criar fatura a partir da cotação
            
            return response()->json([
                'success' => true,
                'message' => 'Fatura criada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar fatura: ' . $e->getMessage()
            ], 500);
        }
    }

    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //  $cotacoes = Cotacao::with(['cliente', 'servicos'])
        //                 ->orderBy('created_at', 'desc')
        //                 ->paginate(10); 
    
        // return view('gestao.cotacoes.index', compact('cotacoes'));
    }


    // public function listar()
    // {
    //      $cotacoes = Cotacao::with(['cliente', 'servico'])
    //                     ->orderBy('created_at', 'desc')
    //                     ->paginate(10); 
    
    //     return view('gestao.cotacoes.showData', compact('cotacoes'));
    // }

public function listar()
{
    // Usando select para buscar apenas os campos necessários
    $cotacoes = Cotacao::select([
            'id',
            'numero_cotacao',
            'id_cliente',
            'id_servico',
            'quantidade',
            'preco_unitario',
            'status',
            'data_emissao',
            'validade_dias',
            'created_at'
        ])
        ->with([
            'cliente:id,nome,contacto', // Apenas id, nome e contacto do cliente
            'servico:id,nomeService,categoria' // Apenas id, nomeService e categoria do serviço
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    // Adicionar valor total calculado a cada cotação
    $cotacoes->getCollection()->transform(function ($cotacao) {
        $cotacao->valor_total = ($cotacao->quantidade ?? 1) * ($cotacao->preco_unitario ?? 0);
        return $cotacao;
    });
    
    return view('gestao.cotacoes.showData', compact('cotacoes'));
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
    public function destroy($id)
    {
        try {
            $cotacao = Cotacao::findOrFail($id);
            $cotacao->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Cotação removida com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover cotação: ' . $e->getMessage()
            ], 500);
        }
    }














        /**
     * Gerar PDF da cotação usando TCPDF
     */
    public function gerarPDF(Request $request)
    {
        try {
            // Obter dados da cotação
            $dados = $request->input('cotacao_data');
            
            if (is_string($dados)) {
                $dados = json_decode($dados, true);
            }
            
            // Dados da empresa
            $empresa = [
                'nome' => 'YADA KEY CONSULTING AND SERVICES, LDA',
                'nuit' => '999999999',
                'endereco' => 'Av. 25 de Setembro, nº 1234, Maputo - Moçambique',
                'telefone' => '+258 84 913 0222',
                'email' => 'geral@yadakey.co.mz',
                'website' => 'www.yadakey.co.mz',
                'logo_path'      => public_path('img/YADA_noBG.png'),    
                'watermark_path' => public_path('img/yada.png'), 
            ];
            
            // Preparar dados para o PDF
            $cotacaoData = [
                'cotacao' => [
                    'numero' => $dados['cotacao']['numero'] ?? $request->input('numero_cotacao', 'COT-' . date('Ymd-His')),
                    'data_emissao' => $dados['cotacao']['data_emissao'] ?? date('d/m/Y'),
                    'data_validade' => $dados['cotacao']['data_validade'] ?? date('d/m/Y', strtotime('+15 days')),
                    'validade_dias' => $dados['cotacao']['validade_dias'] ?? 15,
                    'status' => $dados['cotacao']['status'] ?? 'Pendente',
                    'observacoes' => $dados['observacoes'] ?? 'Esta cotação é válida por 15 dias a partir da data de emissão. Os preços incluem IVA à taxa de 16%.',
                ],
                'cliente' => $dados['cliente'] ?? [
                    'nome' => $request->input('nome_cliente', 'Cliente não informado'),
                    'nuit' => $request->input('nuit', 'Não informado'),
                    'endereco' => $request->input('endereco', 'Não informado'),
                    'contacto' => $request->input('contacto', 'Não informado'),
                ],
                'servicos' => $dados['servicos'] ?? [],
                'valores' => $dados['valores'] ?? [
                    'subtotal_formatado' => 'MZN 0,00',
                    'desconto_global_percent' => 0,
                    'desconto_global_formatado' => 'MZN 0,00',
                    'subtotal_com_desconto_formatado' => 'MZN 0,00',
                    'iva_percent' => 16,
                    'iva_formatado' => 'MZN 0,00',
                    'total_formatado' => 'MZN 0,00',
                    'total_extenso' => 'Meticais zero e zero centavos',
                    'prazo_pagamento' => $dados['pagamento']['prazo_dias'] ?? '15 dias',
                ]
            ];
            
            // Instanciar e gerar PDF
            $pdf = new CotacaoPDF($cotacaoData, $empresa);
            $pdf->gerarCotacao();
            
            // Nome do arquivo
            $numeroCotacao = preg_replace('/[^a-zA-Z0-9_-]/', '_', $cotacaoData['cotacao']['numero']);
            $nomeArquivo = "Cotacao_{$numeroCotacao}_" . date('Ymd') . ".pdf";
            
            // Output do PDF
            return response($pdf->Output($nomeArquivo, 'I'), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $nomeArquivo . '"');
            
        } catch (\Exception $e) {
            Log::error('Erro ao gerar PDF com TCPDF: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao gerar PDF: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }
    
    /**
     * Método alternativo para gerar PDF diretamente do banco de dados
     */
    public function gerarPDFCotacao($id)
    {
        try {
            // Buscar cotação do banco
            $cotacao = Cotacao::with(['cliente', 'servico', 'valoresCotacao'])
                ->findOrFail($id);
            
            // Montar estrutura de dados
            $cotacaoData = [
                'cotacao' => [
                    'numero' => $cotacao->numero_cotacao,
                    'data_emissao' => date('d/m/Y', strtotime($cotacao->data_emissao)),
                    'data_validade' => date('d/m/Y', strtotime($cotacao->data_validade)),
                    'validade_dias' => $cotacao->validade_dias,
                    'status' => $this->getStatusText($cotacao->status),
                    'observacoes' => 'Cotação válida até ' . date('d/m/Y', strtotime($cotacao->data_validade)),
                ],
                'cliente' => [
                    'nome' => $cotacao->cliente->nome,
                    'nuit' => $cotacao->cliente->nuit ?? 'Não informado',
                    'endereco' => $cotacao->cliente->endereco ?? 'Não informado',
                    'contacto' => $cotacao->cliente->contacto ?? 'Não informado',
                ],
                'servicos' => [],
                'valores' => []
            ];
            
            // Buscar serviços e valores
            $cotacaoServicos = CotacaoServico::where('id_cotacao', $cotacao->id)->get();
            $valores = ValoresCotacao::where('idCotacao', $cotacao->id)->first();
            
            foreach ($cotacaoServicos as $item) {
                $servico = Servico::find($item->id_servico);
                
                $cotacaoData['servicos'][] = [
                    'nome' => $servico->nomeService ?? 'Serviço #' . $item->id_servico,
                    'quantidade' => $item->quantidade,
                    'preco_unitario' => $item->preco_unitario,
                    'preco_formatado' => number_format($item->preco_unitario, 2, ',', '.'),
                    'desconto_percent' => $item->desconto ?? 0,
                    'desconto_valor' => ($item->preco_unitario * $item->quantidade * ($item->desconto ?? 0) / 100),
                    'subtotal' => $item->preco_unitario * $item->quantidade * (1 - ($item->desconto ?? 0) / 100),
                    'subtotal_formatado' => number_format($item->preco_unitario * $item->quantidade * (1 - ($item->desconto ?? 0) / 100), 2, ',', '.'),
                ];
            }
            
            if ($valores) {
                $cotacaoData['valores'] = [
                    'subtotal_formatado' => number_format($valores->subtotal, 2, ',', '.'),
                    'desconto_global_percent' => $valores->desconto_global_percent,
                    'desconto_global_formatado' => number_format($valores->desconto_global_valor, 2, ',', '.'),
                    'subtotal_com_desconto_formatado' => number_format($valores->subtotal_com_desconto, 2, ',', '.'),
                    'iva_percent' => $valores->iva_percent,
                    'iva_formatado' => number_format($valores->iva_valor, 2, ',', '.'),
                    'total_formatado' => number_format($valores->total, 2, ',', '.'),
                    'total_extenso' => $this->valorPorExtenso($valores->total),
                    'prazo_pagamento' => $valores->prazo_pagamento . ' dias',
                ];
            }
            
            // Dados da empresa
            $empresa = [
                'nome' => 'YADA KEY CONSULTING AND SERVICES, LDA',
                'nuit' => '999999999',
                'endereco' => 'Av. 25 de Setembro, nº 1234, Maputo - Moçambique',
                'telefone' => '+258 84 913 0222',
                'email' => 'geral@yadakey.co.mz',
                'website' => 'www.yadakey.co.mz',
            ];
            
            // Gerar PDF
            $pdf = new CotacaoPDF($cotacaoData, $empresa);
            $pdf->gerarCotacao();
            
            $nomeArquivo = "Cotacao_{$cotacao->numero_cotacao}_" . date('Ymd') . ".pdf";
            
            return response($pdf->Output($nomeArquivo, 'I'), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $nomeArquivo . '"');
                
        } catch (\Exception $e) {
            Log::error('Erro ao gerar PDF da cotação #' . $id . ': ' . $e->getMessage());
            return back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }
    
    private function getStatusText($status)
    {
        $statuses = [
            0 => 'Pendente',
            1 => 'Aprovada',
            2 => 'Rejeitada',
            3 => 'Convertida',
        ];
        
        return $statuses[$status] ?? 'Pendente';
    }
    
    /**
     * Visualizar cotação e gerar PDF
     */
    public function visualizar($id)
    {
        try {
            $cotacao = Cotacao::with(['cliente', 'servico', 'user', 'valoresCotacao'])
                ->findOrFail($id);
            
            // Se for requisição AJAX, retornar HTML parcial
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'html' => view('gestao.cotacoes.partials.detalhes', compact('cotacao'))->render()
                ]);
            }
            
            // Se não for AJAX, retornar view completa
            return view('gestao.cotacoes.show', compact('cotacao'));
            
        } catch (\Exception $e) {
            Log::error('Erro ao visualizar cotação: ' . $e->getMessage());
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao carregar cotação: ' . $e->getMessage()
                ], 500);
            }
            
            abort(404);
        }
    }
    
    // Adicione esta rota para gerar PDF diretamente do banco
    public function downloadPDF($id)
    {
        return $this->gerarPDFCotacao($id);
    }



}
