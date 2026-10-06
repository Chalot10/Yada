<?php

namespace App\Http\Controllers\Gestao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class CotacaoPDFController extends Controller
{
    public function gerarPDFTCPDF(Request $request)
    {
        try {
            // Obter dados
            $dados = $request->input('cotacao_data');
            
            if (is_string($dados)) {
                $dados = json_decode($dados, true);
            }
            
            // Preparar dados para a view
            $data = [
                'cotacao' => $dados['cotacao'] ?? [
                    'numero' => $request->input('numero_cotacao', 'COT-' . date('Ymd-His')),
                    'data_emissao' => $request->input('data_emissao', date('d/m/Y')),
                    'validade_dias' => $request->input('validade_dias', '15'),
                    'validade_data' => date('d/m/Y', strtotime('+' . ($request->input('validade_dias', 15)) . ' days')),
                    'status' => $dados['status'] ?? 'Pendente'
                ],
                
                'cliente' => $dados['cliente'] ?? [
                    'nome' => $request->input('nome_cliente', 'Cliente não informado'),
                    'nuit' => $request->input('nuit', 'Não informado'),
                    'endereco' => $request->input('endereco', 'Não informado'),
                    'contacto' => $request->input('contacto', 'Não informado')
                ],
                
                'empresa' => $dados['empresa'] ?? [
                    'nome' => 'Yada Key Consulting and Services',
                    'nuit' => '999999999',
                    'endereco' => 'Maputo, Moçambique',
                    'telefone' => '+258 84 000 0000',
                    'email' => 'contato@yadakey.com',
                    'banco' => 'BIM',
                    'conta' => '0123456789',
                    'nib' => '000000000',
                    'responsavel' => 'Gestor Comercial'
                ],
                
                'servicos' => $dados['servicos'] ?? [],
                'valores' => $dados['valores'] ?? [
                    'subtotal_formatado' => 'MZN 0,00',
                    'desconto_global_percent' => 0,
                    'desconto_global_formatado' => 'MZN 0,00',
                    'iva_formatado' => 'MZN 0,00',
                    'total_formatado' => 'MZN 0,00',
                    'total_extenso' => 'Meticais zero e zero centavos',
                    'prazo_pagamento' => $dados['pagamento']['prazo_dias'] ?? '15'
                ],
                
                'observacoes' => $dados['observacoes'] ?? 'Esta cotação é válida até a data indicada acima.',
                'data_geracao' => now()->format('d/m/Y H:i'),
            ];

            // Calcular totais para exibição
            $subtotalServicos = 0;
            $totalDescontoServicos = 0;
            $servicosDetalhados = [];
            
            if (!empty($data['servicos'])) {
                foreach ($data['servicos'] as $servico) {
                    $subtotal = ($servico['preco_unitario'] ?? 0) * ($servico['quantidade'] ?? 1);
                    $descontoPercent = $servico['desconto_percent'] ?? 0;
                    $descontoValor = $subtotal * ($descontoPercent / 100);
                    $subtotalComDesconto = $subtotal - $descontoValor;
                    
                    $subtotalServicos += $subtotal;
                    $totalDescontoServicos += $descontoValor;
                    
                    $servicosDetalhados[] = [
                        'nome' => $servico['nome'] ?? 'Serviço',
                        'descricao' => $servico['descricao'] ?? 'Prestação de serviços profissionais',
                        'quantidade' => $servico['quantidade'] ?? 1,
                        'preco_unitario' => $servico['preco_unitario'] ?? 0,
                        'desconto_percent' => $descontoPercent,
                        'desconto_valor' => $descontoValor,
                        'subtotal' => $subtotalComDesconto
                    ];
                }
            }
            
            $data['servicosDetalhados'] = $servicosDetalhados;
            $data['subtotalServicos'] = $subtotalServicos;
            $data['totalDescontoServicos'] = $totalDescontoServicos;
            
            // Criar novo objeto TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            
            // Configurações do documento
            $pdf->SetCreator('Sistema SIGEYADA');
            $pdf->SetAuthor($data['empresa']['nome']);
            $pdf->SetTitle('Cotação ' . $data['cotacao']['numero']);
            $pdf->SetSubject('Cotação de Serviços');
            
            // Remover cabeçalho e rodapé padrão
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Configurar margens MÍNIMAS para máximo aproveitamento
            $pdf->SetMargins(8, 5, 8);
            $pdf->SetAutoPageBreak(true, 5);
            
            // Adicionar uma única página
            $pdf->AddPage();
            
            // Configurar fonte reduzida
            $pdf->SetFont('helvetica', '', 7);
            
            // Gerar o HTML do PDF - VERSÃO ULTRA COMPACTA
            $html = $this->gerarHTMLCotacaoProfissionalCompacto($data);
            
            // Escrever o HTML
            $pdf->writeHTML($html, true, false, true, false, '');
            
            // Nome do arquivo
            $numeroCotacao = $data['cotacao']['numero'] ?? 'COT-' . date('Ymd-His');
            $nomeArquivo = 'Cotacao_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $numeroCotacao) . '.pdf';
            
            // Saída do PDF
            $pdf->Output($nomeArquivo, 'I');
            
        } catch (\Exception $e) {
            Log::error('Erro ao gerar PDF com TCPDF: ' . $e->getMessage());
            return back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }
    
    private function gerarHTMLCotacaoProfissionalCompacto($data)
    {
        // Helper para formatar moeda
        $formatMZN = function($valor) {
            return number_format($valor, 2, ',', '.') . ' MZN';
        };
        
        // Calcular valores para exibição
        $subtotalServicos = $data['subtotalServicos'] ?? 0;
        $totalDescontoServicos = $data['totalDescontoServicos'] ?? 0;
        $descontoGlobalPercent = $data['valores']['desconto_global_percent'] ?? 0;
        $descontoGlobalValor = $subtotalServicos * ($descontoGlobalPercent / 100);
        $descontoTotal = $totalDescontoServicos + $descontoGlobalValor;
        $subtotalComDesconto = $subtotalServicos - $descontoTotal;
        $iva = $subtotalComDesconto * 0.17;
        $totalGeral = $subtotalComDesconto + $iva;
        
        // Limitar número de serviços para caber em 1 página (máx 7-8 itens)
        $servicosExibicao = array_slice($data['servicosDetalhados'], 0, 8);
        $temMaisServicos = count($data['servicosDetalhados']) > 8;
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                * { 
                    margin: 0; 
                    padding: 0; 
                    box-sizing: border-box; 
                }
                
                body {
                    font-family: 'helvetica', sans-serif;
                    font-size: 7pt;
                    line-height: 1.2;
                    color: #1a1a1a;
                }
                
                /* LAYOUT COMPACTO */
                .header {
                    width: 100%;
                    margin-bottom: 5px;
                    padding-bottom: 3px;
                    border-bottom: 1.5px solid #0b4f6c;
                    display: table;
                }
                
                .header-left {
                    display: table-cell;
                    width: 60%;
                    vertical-align: middle;
                }
                
                .company-name {
                    font-size: 11pt;
                    font-weight: bold;
                    color: #0b4f6c;
                    letter-spacing: -0.3px;
                    margin-bottom: 2px;
                }
                
                .company-info {
                    font-size: 6.5pt;
                    color: #444;
                    line-height: 1.2;
                }
                
                .header-right {
                    display: table-cell;
                    width: 40%;
                    text-align: right;
                    vertical-align: middle;
                }
                
                .doc-title {
                    font-size: 14pt;
                    font-weight: bold;
                    color: #0b4f6c;
                    line-height: 1;
                    margin-bottom: 2px;
                }
                
                .doc-number {
                    font-size: 8pt;
                    color: #d35400;
                    font-weight: bold;
                    background: #fef2e9;
                    padding: 2px 5px;
                    display: inline-block;
                    border-radius: 2px;
                }
                
                .status {
                    font-size: 6.5pt;
                    background: #0b4f6c;
                    color: white;
                    padding: 2px 6px;
                    border-radius: 2px;
                    font-weight: bold;
                    display: inline-block;
                    margin-left: 3px;
                }
                
                /* CLIENTE - COMPACTO */
                .client-area {
                    width: 100%;
                    margin: 5px 0;
                    background: #f8fafc;
                    padding: 4px 6px;
                    border-left: 3px solid #0b4f6c;
                    display: table;
                }
                
                .client-label {
                    display: table-cell;
                    width: 50px;
                    font-weight: bold;
                    color: #0b4f6c;
                    font-size: 7pt;
                }
                
                .client-data {
                    display: table-cell;
                    font-size: 7pt;
                }
                
                .client-name {
                    font-weight: bold;
                    color: #000;
                }
                
                /* INFO GRID */
                .info-grid {
                    width: 100%;
                    margin: 5px 0;
                    display: table;
                    border-collapse: collapse;
                }
                
                .info-row {
                    display: table-row;
                }
                
                .info-cell {
                    display: table-cell;
                    padding: 2px 3px;
                    font-size: 6.5pt;
                }
                
                .info-label {
                    font-weight: bold;
                    color: #0b4f6c;
                    width: 80px;
                }
                
                /* TABELA DE SERVIÇOS - SUPER COMPACTA */
                .services {
                    width: 100%;
                    margin: 5px 0;
                    border-collapse: collapse;
                    font-size: 6.5pt;
                }
                
                .services th {
                    background: #0b4f6c;
                    color: white;
                    padding: 4px 2px;
                    font-weight: bold;
                    text-align: left;
                    font-size: 6.5pt;
                    border: 0.5px solid #0b4f6c;
                }
                
                .services td {
                    padding: 3px 2px;
                    border: 0.5px solid #ddd;
                    vertical-align: top;
                }
                
                .service-desc {
                    font-size: 6pt;
                    color: #555;
                    line-height: 1.1;
                }
                
                /* TABELA DE TOTAIS - COMPACTA */
                .totals-area {
                    width: 100%;
                    margin: 5px 0;
                    display: table;
                }
                
                .totals-box {
                    display: table-cell;
                    width: 45%;
                    background: #f8fafc;
                    padding: 5px;
                    border: 0.5px solid #0b4f6c;
                }
                
                .totals-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 6.5pt;
                }
                
                .totals-table td {
                    padding: 2px 0;
                }
                
                .grand-total {
                    font-size: 8pt;
                    font-weight: bold;
                    color: #0b4f6c;
                    border-top: 0.5px solid #0b4f6c;
                }
                
                /* COLUNA DA DIREITA */
                .info-right {
                    display: table-cell;
                    width: 53%;
                    padding-left: 8px;
                    vertical-align: top;
                }
                
                /* BANCOS E OBS - MINIMALISTA */
                .bank-info {
                    background: #fff;
                    border: 0.5px solid #ddd;
                    padding: 4px;
                    margin-bottom: 5px;
                    font-size: 6pt;
                }
                
                .bank-title {
                    font-weight: bold;
                    color: #0b4f6c;
                    border-bottom: 0.5px solid #0b4f6c;
                    padding-bottom: 1px;
                    margin-bottom: 3px;
                }
                
                .notes {
                    background: #fff9e6;
                    border: 0.5px solid #ffb300;
                    padding: 4px;
                    font-size: 6pt;
                }
                
                .notes-title {
                    font-weight: bold;
                    color: #b45309;
                }
                
                /* RODAPÉ - MINIMAL */
                .footer {
                    width: 100%;
                    margin-top: 8px;
                    padding-top: 3px;
                    border-top: 0.5px solid #ddd;
                    font-size: 5.5pt;
                    color: #666;
                    text-align: center;
                }
                
                .text-right { text-align: right; }
                .text-center { text-align: center; }
                .currency { font-family: 'courier', monospace; }
                .clearfix { clear: both; }
            </style>
        </head>
        <body>
        
        <!-- CABEÇALHO PROFISSIONAL -->
        <div class="header">
            <div class="header-left">
                <div class="company-name"><?php echo $data['empresa']['nome']; ?></div>
                <div class="company-info">
                    NUIT: <?php echo $data['empresa']['nuit']; ?> | Tel: <?php echo $data['empresa']['telefone']; ?><br>
                    <?php echo $data['empresa']['email']; ?> | <?php echo $data['empresa']['endereco']; ?>
                </div>
            </div>
            <div class="header-right">
                <div class="doc-title">COTAÇÃO</div>
                <div>
                    <span class="doc-number"><?php echo $data['cotacao']['numero']; ?></span>
                    <span class="status"><?php echo strtoupper(substr($data['cotacao']['status'] ?? 'PENDENTE', 0, 8)); ?></span>
                </div>
                <div style="font-size: 6.5pt; margin-top: 2px;"><?php echo $data['cotacao']['data_emissao']; ?></div>
            </div>
        </div>
        
        <!-- CLIENTE COMPACTO -->
        <div class="client-area">
            <div class="client-label">CLIENTE:</div>
            <div class="client-data">
                <span class="client-name"><?php echo $data['cliente']['nome']; ?></span>
                <?php if($data['cliente']['nuit'] != 'Não informado'): ?> | NUIT: <?php echo $data['cliente']['nuit']; ?><?php endif; ?>
                <?php if($data['cliente']['contacto'] != 'Não informado'): ?> | Tel: <?php echo $data['cliente']['contacto']; ?><?php endif; ?>
                <br><span style="color: #666;"><?php echo $data['cliente']['endereco']; ?></span>
            </div>
        </div>
        
        <!-- INFO LINHA ÚNICA -->
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Validade:</div>
                <div class="info-cell"><?php echo $data['cotacao']['validade_dias']; ?> dias (até <?php echo $data['cotacao']['validade_data']; ?>)</div>
                <div class="info-cell info-label">Pagamento:</div>
                <div class="info-cell"><?php echo $data['valores']['prazo_pagamento']; ?> dias</div>
                <div class="info-cell info-label">Moeda:</div>
                <div class="info-cell">MZN</div>
            </div>
        </div>
        
        <!-- TABELA DE SERVIÇOS OTIMIZADA -->
        <table class="services" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th width="40%">Descrição</th>
                    <th width="7%">Qtd</th>
                    <th width="15%">Preço Unit.</th>
                    <th width="15%">Total</th>
                    <?php if($totalDescontoServicos > 0): ?>
                    <th width="10%">Desc%</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($servicosExibicao)): ?>
                    <?php $i = 1; ?>
                    <?php foreach($servicosExibicao as $servico): ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td>
                            <b><?php echo $this->truncateTexto($servico['nome'], 35); ?></b>
                            <div class="service-desc"><?php echo $this->truncateTexto($servico['descricao'], 45); ?></div>
                        </td>
                        <td class="text-center"><?php echo $servico['quantidade']; ?></td>
                        <td class="text-right currency"><?php echo $formatMZN($servico['preco_unitario']); ?></td>
                        <td class="text-right currency"><?php echo $formatMZN($servico['subtotal']); ?></td>
                        <?php if($totalDescontoServicos > 0): ?>
                        <td class="text-center"><?php echo $servico['desconto_percent'] > 0 ? $servico['desconto_percent'] . '%' : '-'; ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if($temMaisServicos): ?>
                    <tr>
                        <td colspan="6" style="text-align: right; padding: 3px; font-style: italic; color: #0b4f6c;">
                            + <?php echo count($data['servicosDetalhados']) - 8; ?> serviço(s) adicional(is) conforme proposta completa
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 10px; color: #999;">
                            Nenhum serviço cadastrado
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- ÁREA DE TOTAIS E INFORMAÇÕES - LADO A LADO -->
        <div class="totals-area">
            <!-- TOTAIS -->
            <div class="totals-box">
                <table class="totals-table">
                    <tr>
                        <td>Subtotal:</td>
                        <td class="text-right currency"><?php echo $formatMZN($subtotalServicos); ?></td>
                    </tr>
                    <?php if($totalDescontoServicos > 0): ?>
                    <tr>
                        <td>Descontos:</td>
                        <td class="text-right currency" style="color: #c0392b;">- <?php echo $formatMZN($totalDescontoServicos); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($descontoGlobalPercent > 0): ?>
                    <tr>
                        <td>Desc. Global (<?php echo $descontoGlobalPercent; ?>%):</td>
                        <td class="text-right currency" style="color: #c0392b;">- <?php echo $formatMZN($descontoGlobalValor); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td>Subtotal c/ Desc.:</td>
                        <td class="text-right currency"><b><?php echo $formatMZN($subtotalComDesconto); ?></b></td>
                    </tr>
                    <tr>
                        <td>IVA (17%):</td>
                        <td class="text-right currency"><?php echo $formatMZN($iva); ?></td>
                    </tr>
                    <tr class="grand-total">
                        <td>TOTAL GERAL:</td>
                        <td class="text-right currency"><b><?php echo $formatMZN($totalGeral); ?></b></td>
                    </tr>
                </table>
                <div style="font-size: 5.5pt; margin-top: 3px; color: #666;">
                    <?php echo $this->truncateTexto($data['valores']['total_extenso'], 70); ?>
                </div>
            </div>
            
            <!-- DADOS BANCÁRIOS E OBSERVAÇÕES -->
            <div class="info-right">
                <div class="bank-info">
                    <div class="bank-title">DADOS BANCÁRIOS</div>
                    <table style="width: 100%; font-size: 6pt;">
                        <tr>
                            <td width="40%"><b>Banco:</b></td>
                            <td><?php echo $data['empresa']['banco']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Conta:</b></td>
                            <td><?php echo $data['empresa']['conta']; ?></td>
                        </tr>
                        <tr>
                            <td><b>NIB:</b></td>
                            <td><?php echo $data['empresa']['nib']; ?></td>
                        </tr>
                    </table>
                </div>
                
                <div class="notes">
                    <div class="notes-title">OBSERVAÇÕES</div>
                    <div style="line-height: 1.2;">
                        <?php echo $this->truncateTexto($data['observacoes'], 120); ?>
                    </div>
                    <div style="font-size: 5.5pt; margin-top: 2px; color: #666;">
                        Gerado: <?php echo $data['data_geracao']; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- RODAPÉ LIMPO -->
        <div class="footer">
            <?php echo $data['empresa']['nome']; ?> • NUIT: <?php echo $data['empresa']['nuit']; ?> • 
            <?php echo $data['empresa']['telefone']; ?> • <?php echo $data['empresa']['email']; ?>
        </div>
        
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Truncar texto para caber no espaço
     */
    private function truncateTexto($texto, $limite = 50)
    {
        if (strlen($texto) <= $limite) {
            return $texto;
        }
        
        return substr($texto, 0, $limite) . '...';
    }
}