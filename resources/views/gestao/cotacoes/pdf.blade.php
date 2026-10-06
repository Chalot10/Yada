<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cotacao_{{ $cotacao['numero'] ?? 'N_A' }}</title>
    
    <style>
        @page {
            size: A4;
            margin: 15mm 20mm;
            @bottom-center {
                content: "Página " counter(page) " de " counter(pages);
                font-size: 8pt;
                color: #666;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        /* ===== CABEÇALHO ELEGANTE ===== */
        .header-container {
            width: 100%;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #03588C;
            position: relative;
            overflow: hidden;
        }

        .header-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: linear-gradient(135deg, #03588C 0%, #024059 100%);
            opacity: 0.1;
            z-index: 0;
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .logo-section {
            flex: 0 0 40%;
        }

        .logo-display {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #03588C 0%, #024059 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18pt;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .company-name {
            font-size: 18pt;
            font-weight: 700;
            color: #024059;
            margin: 0;
            line-height: 1.1;
        }

        .company-tagline {
            font-size: 9pt;
            color: #666;
            font-style: italic;
            margin-top: 2px;
        }

        .company-details {
            font-size: 8pt;
            color: #03588C;
            line-height: 1.3;
            padding-left: 75px;
        }

        .document-section {
            flex: 0 0 55%;
            text-align: right;
        }

        .document-title {
            font-size: 32pt;
            font-weight: 800;
            color: #03588C;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .document-number {
            font-size: 14pt;
            color: #024059;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .status-container {
            margin-bottom: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 20px;
            background: linear-gradient(135deg, #F2B84B 0%, #D97B29 100%);
            color: #fff;
            border-radius: 20px;
            font-size: 9pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(217, 123, 41, 0.2);
        }

        .document-dates {
            display: inline-grid;
            grid-template-columns: repeat(3, auto);
            gap: 15px;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .date-item {
            text-align: center;
        }

        .date-label {
            display: block;
            font-size: 7pt;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .date-value {
            display: block;
            font-size: 9pt;
            font-weight: 600;
            color: #024059;
        }

        /* ===== SEÇÕES DE INFORMAÇÃO ===== */
        .section-container {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: 600;
            color: #03588C;
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #F2B84B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .info-icon {
            width: 24px;
            height: 24px;
            background: #03588C;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10pt;
        }

        .info-details {
            font-size: 9pt;
            line-height: 1.5;
        }

        .detail-row {
            display: flex;
            margin-bottom: 6px;
        }

        .detail-label {
            flex: 0 0 100px;
            font-weight: 600;
            color: #024059;
        }

        .detail-value {
            flex: 1;
            color: #333;
        }

        /* ===== TABELA DE SERVIÇOS ELEGANTE ===== */
        .services-container {
            margin: 25px 0;
        }

        .services-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .services-table thead {
            background: linear-gradient(135deg, #03588C 0%, #024059 100%);
        }

        .services-table th {
            color: white;
            font-weight: 600;
            padding: 12px 10px;
            text-align: left;
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .services-table th:first-child {
            border-top-left-radius: 10px;
        }

        .services-table th:last-child {
            border-top-right-radius: 10px;
        }

        .services-table tbody tr {
            background: white;
            transition: background-color 0.2s;
        }

        .services-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .services-table tbody tr:hover {
            background: #e3f2fd;
        }

        .services-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
            font-size: 9pt;
        }

        .service-name {
            font-weight: 600;
            color: #024059;
        }

        .service-description {
            font-size: 8pt;
            color: #666;
            margin-top: 2px;
            line-height: 1.3;
        }

        .quantity-badge {
            display: inline-block;
            padding: 2px 8px;
            background: #e3f2fd;
            color: #03588C;
            border-radius: 10px;
            font-size: 8pt;
            font-weight: 600;
        }

        .discount-badge {
            display: inline-block;
            padding: 2px 6px;
            background: #ffebee;
            color: #c62828;
            border-radius: 8px;
            font-size: 7pt;
            font-weight: 600;
        }

        /* ===== RESUMO FINANCEIRO ===== */
        .summary-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 25px 0;
        }

        .qr-section {
            text-align: center;
        }

        .qr-container {
            background: white;
            padding: 15px;
            border-radius: 12px;
            border: 2px solid #03588C;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(3, 88, 140, 0.1);
        }

        .qr-title {
            font-size: 9pt;
            font-weight: 600;
            color: #03588C;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .qr-placeholder {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border: 1px solid #dee2e6;
        }

        .qr-note {
            font-size: 7pt;
            color: #666;
            margin-top: 8px;
            font-style: italic;
        }

        .totals-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #03588C;
        }

        .totals-title {
            font-size: 11pt;
            font-weight: 600;
            color: #03588C;
            margin: 0 0 15px 0;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table tr {
            border-bottom: 1px solid #dee2e6;
        }

        .totals-table tr:last-child {
            border-bottom: none;
        }

        .totals-table td {
            padding: 8px 0;
            font-size: 9pt;
        }

        .total-label {
            color: #666;
        }

        .total-value {
            text-align: right;
            font-weight: 500;
            color: #333;
        }

        .total-row {
            background: #03588C;
            color: white;
            border-radius: 6px;
        }

        .total-row .total-label {
            color: white;
            font-weight: 600;
        }

        .total-row .total-value {
            color: white;
            font-weight: 700;
        }

        .total-in-words {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed #dee2e6;
            font-size: 8pt;
            color: #666;
            text-align: center;
            font-style: italic;
        }

        /* ===== SEÇÃO DE PAGAMENTO ===== */
        .payment-container {
            background: linear-gradient(135deg, rgba(242, 184, 75, 0.1) 0%, rgba(217, 123, 41, 0.1) 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #F2B84B;
        }

        .payment-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .payment-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #F2B84B 0%, #D97B29 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14pt;
        }

        .payment-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .payment-method {
            background: white;
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        .payment-label {
            font-size: 8pt;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .payment-value {
            font-size: 9pt;
            font-weight: 600;
            color: #024059;
        }

        /* ===== OBSERVAÇÕES ===== */
        .notes-container {
            background: #e3f2fd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #03588C;
        }

        .notes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }

        .note-item {
            text-align: center;
            padding: 8px;
            background: white;
            border-radius: 6px;
            border: 1px solid #bbdefb;
        }

        .note-label {
            font-size: 7pt;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .note-value {
            font-size: 8pt;
            font-weight: 600;
            color: #03588C;
        }

        /* ===== RODAPÉ ===== */
        .footer-container {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 3px solid #03588C;
            text-align: center;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 15px;
        }

        .footer-item {
            text-align: center;
        }

        .footer-label {
            font-size: 8pt;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .footer-value {
            font-size: 9pt;
            font-weight: 600;
            color: #024059;
        }

        .footer-signature {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            padding: 0 40px;
        }

        .signature-box {
            text-align: center;
            padding-top: 40px;
            position: relative;
        }

        .signature-line {
            width: 80%;
            height: 1px;
            background: #024059;
            margin: 0 auto;
            position: relative;
            top: 20px;
        }

        .signature-name {
            font-size: 10pt;
            font-weight: 600;
            color: #03588C;
            margin-top: 25px;
        }

        .signature-role {
            font-size: 8pt;
            color: #666;
            margin-top: 2px;
        }

        .signature-date {
            font-size: 7pt;
            color: #999;
            margin-top: 5px;
            font-style: italic;
        }

        .footer-note {
            font-size: 7pt;
            color: #999;
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
        }

        /* ===== UTILITÁRIOS ===== */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-bold { font-weight: 600; }
        .text-muted { color: #666; }

        .currency {
            font-family: 'DejaVu Sans Mono', monospace;
            letter-spacing: 0.5px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #03588C, transparent);
            margin: 20px 0;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt;
            color: rgba(3, 88, 140, 0.03);
            font-weight: 800;
            z-index: -1;
            white-space: nowrap;
        }
    </style>
</head>

<body>

@php
    // Helper para formatar moeda
    function formatMZN($valor) {
        return 'MZN ' . number_format($valor, 2, ',', '.');
    }
    
    // Calcular totais
    $subtotalServicos = 0;
    $totalDescontoServicos = 0;
    $servicosDetalhados = [];
    
    if (!empty($servicos)) {
        foreach ($servicos as $servico) {
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
    
    // Valores globais
    $descontoGlobalPercent = $valores['desconto_global_percent'] ?? 0;
    $descontoGlobalValor = $subtotalServicos * ($descontoGlobalPercent / 100);
    $descontoTotal = $totalDescontoServicos + $descontoGlobalValor;
    $subtotalComDesconto = $subtotalServicos - $descontoTotal;
    $iva = $subtotalComDesconto * 0.17;
    $totalGeral = $subtotalComDesconto + $iva;
    
    // Gerar texto para QR Code
    $qrText = "COTAÇÃO {$cotacao['numero']}\nCliente: {$cliente['nome']}\nValor: " . formatMZN($totalGeral) . "\nEmissão: {$cotacao['data_emissao']}\nValidade: " . ($cotacao['validade_dias'] ?? '15') . " dias\nStatus: {$cotacao['status']}";
@endphp

<!-- MARCA D'ÁGUA -->
<div class="watermark">
    {{ $empresa['nome'] ?? 'YKCS' }}
</div>

<!-- CABEÇALHO ELEGANTE -->
<div class="header-container">
    <div class="header-background"></div>
    <div class="header-content">
        <div class="logo-section">
            <div class="logo-display">
                <div class="logo-circle">YK</div>
                <div>
                    <div class="company-name">{{ $empresa['nome'] ?? 'Yada Key Consulting and Services' }}</div>
                    <div class="company-tagline">Consultoria & Serviços Profissionais</div>
                </div>
            </div>
            <div class="company-details">
                NUIT: {{ $empresa['nuit'] ?? '999999999' }} • 
                {{ $empresa['endereco'] ?? 'Maputo, Moçambique' }}<br>
                Tel: {{ $empresa['telefone'] ?? '+258 84 000 0000' }} • 
                Email: {{ $empresa['email'] ?? 'contato@yadakey.com' }}
            </div>
        </div>
        
        <div class="document-section">
            <h1 class="document-title">Cotação</h1>
            <div class="document-number">Nº {{ $cotacao['numero'] ?? 'COT-' . date('Ymd-His') }}</div>
            
            <div class="status-container">
                <span class="status-badge">{{ strtoupper($cotacao['status'] ?? 'PENDENTE') }}</span>
            </div>
            
            <div class="document-dates">
                <div class="date-item">
                    <span class="date-label">Emissão</span>
                    <span class="date-value">{{ $cotacao['data_emissao'] ?? date('d/m/Y') }}</span>
                </div>
                <div class="date-item">
                    <span class="date-label">Validade</span>
                    <span class="date-value">{{ $cotacao['validade_dias'] ?? '15' }} dias</span>
                </div>
                <div class="date-item">
                    <span class="date-label">Válido até</span>
                    <span class="date-value">{{ $cotacao['validade_data'] ?? date('d/m/Y', strtotime('+15 days')) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- INFORMAÇÕES DO CLIENTE E EMPRESA -->
<div class="section-container">
    <h2 class="section-title">Informações</h2>
    <div class="info-grid-container">
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">👤</div>
                <h3 style="margin: 0; font-size: 10pt;">Cliente</h3>
            </div>
            <div class="info-details">
                <div class="detail-row">
                    <div class="detail-label">Nome:</div>
                    <div class="detail-value">{{ $cliente['nome'] ?? 'Cliente não informado' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">NUIT:</div>
                    <div class="detail-value">{{ $cliente['nuit'] ?? 'Não informado' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Contacto:</div>
                    <div class="detail-value">{{ $cliente['contacto'] ?? 'Não informado' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Endereço:</div>
                    <div class="detail-value">{{ $cliente['endereco'] ?? 'Não informado' }}</div>
                </div>
            </div>
        </div>
        
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">🏢</div>
                <h3 style="margin: 0; font-size: 10pt;">Empresa</h3>
            </div>
            <div class="info-details">
                <div class="detail-row">
                    <div class="detail-label">Responsável:</div>
                    <div class="detail-value">{{ $empresa['responsavel'] ?? 'Gestor Comercial' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Contacto:</div>
                    <div class="detail-value">{{ $empresa['telefone_comercial'] ?? $empresa['telefone'] ?? '+258 84 000 0000' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">{{ $empresa['email_comercial'] ?? $empresa['email'] ?? 'comercial@yadakey.com' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Referência:</div>
                    <div class="detail-value">{{ $cotacao['numero'] ?? 'COT-' . date('Ymd-His') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SERVIÇOS DETALHADOS -->
<div class="services-container">
    <h2 class="section-title">Serviços Propostos</h2>
    
    <table class="services-table">
        <thead>
            <tr>
                <th width="45%">Descrição do Serviço</th>
                <th width="10%" class="text-center">Qtd</th>
                <th width="15%" class="text-right">Preço Unitário</th>
                <th width="15%" class="text-center">Desconto</th>
                <th width="15%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($servicosDetalhados))
                @foreach($servicosDetalhados as $servico)
                <tr>
                    <td>
                        <div class="service-name">{{ $servico['nome'] }}</div>
                        <div class="service-description">{{ $servico['descricao'] }}</div>
                    </td>
                    <td class="text-center">
                        <span class="quantity-badge">{{ $servico['quantidade'] }}</span>
                    </td>
                    <td class="text-right currency">{{ formatMZN($servico['preco_unitario']) }}</td>
                    <td class="text-center">
                        @if($servico['desconto_percent'] > 0)
                        <span class="discount-badge">{{ $servico['desconto_percent'] }}%</span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-right currency text-bold">{{ formatMZN($servico['subtotal']) }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Nenhum serviço informado
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- RESUMO FINANCEIRO COM QR CODE -->
<div class="summary-container">
    <div class="qr-section">
        <div class="qr-container">
            <div class="qr-title">QR Code da Cotação</div>
            <div class="qr-placeholder">
                <!-- QR Code será gerado aqui -->
                <div style="font-size: 8pt; color: #666; text-align: center;">
                    {{ $cotacao['numero'] ?? 'COTACAO' }}<br>
                    ⬢ ⬢ ⬢ ⬢<br>
                    ⬢ &nbsp;&nbsp;&nbsp;&nbsp; ⬢<br>
                    ⬢ ⬢ ⬢ ⬢<br>
                    QR Code
                </div>
            </div>
            <div class="qr-note">
                Escaneie para verificar autenticidade
            </div>
        </div>
    </div>
    
    <div class="totals-section">
        <h3 class="totals-title">Resumo Financeiro</h3>
        
        <table class="totals-table">
            <tr>
                <td class="total-label">Subtotal dos Serviços</td>
                <td class="total-value currency">{{ formatMZN($subtotalServicos) }}</td>
            </tr>
            
            @if($totalDescontoServicos > 0)
            <tr>
                <td class="total-label">Desconto nos Serviços</td>
                <td class="total-value currency" style="color: #c62828;">- {{ formatMZN($totalDescontoServicos) }}</td>
            </tr>
            @endif
            
            @if($descontoGlobalPercent > 0)
            <tr>
                <td class="total-label">Desconto Global ({{ $descontoGlobalPercent }}%)</td>
                <td class="total-value currency" style="color: #c62828;">- {{ formatMZN($descontoGlobalValor) }}</td>
            </tr>
            @endif
            
            <tr style="border-top: 2px solid #03588C;">
                <td class="total-label text-bold">Subtotal com Desconto</td>
                <td class="total-value currency text-bold">{{ formatMZN($subtotalComDesconto) }}</td>
            </tr>
            
            <tr>
                <td class="total-label">IVA (17%)</td>
                <td class="total-value currency">{{ formatMZN($iva) }}</td>
            </tr>
            
            <tr class="total-row">
                <td class="total-label">TOTAL GERAL</td>
                <td class="total-value currency">{{ formatMZN($totalGeral) }}</td>
            </tr>
        </table>
        
        <div class="total-in-words">
            <strong>Em extenso:</strong> {{ $valores['total_extenso'] ?? number_format($totalGeral, 2, ',', '.') }} Meticais
        </div>
    </div>
</div>

<!-- INFORMAÇÕES DE PAGAMENTO -->
<div class="payment-container">
    <div class="payment-header">
        <div class="payment-icon">💳</div>
        <h3 style="margin: 0; font-size: 11pt; color: #D97B29;">Condições de Pagamento</h3>
    </div>
    
    <div class="payment-details">
        <div class="payment-method">
            <div class="payment-label">Prazo</div>
            <div class="payment-value">{{ $valores['prazo_pagamento'] ?? '15 dias' }}</div>
        </div>
        
        <div class="payment-method">
            <div class="payment-label">Banco</div>
            <div class="payment-value">{{ $empresa['banco'] ?? 'BIM' }}</div>
        </div>
        
        <div class="payment-method">
            <div class="payment-label">Conta/NIB</div>
            <div class="payment-value">{{ $empresa['conta'] ?? '0123456789' }} / {{ $empresa['nib'] ?? '000000000' }}</div>
        </div>
    </div>
</div>

<!-- OBSERVAÇÕES -->
<div class="notes-container">
    <h3 style="margin: 0 0 10px 0; font-size: 10pt; color: #03588C;">Observações & Condições</h3>
    <p style="margin: 0 0 15px 0; font-size: 9pt; line-height: 1.5;">
        {{ $observacoes ?? 'Esta cotação é válida até a data indicada. Os preços apresentados incluem IVA à taxa de 17%. Para aprovação, dúvidas ou ajustes, entre em contato com nossa equipa comercial.' }}
    </p>
    
    <div class="notes-grid">
        <div class="note-item">
            <div class="note-label">Validade</div>
            <div class="note-value">{{ $cotacao['validade_dias'] ?? '15' }} dias</div>
        </div>
        <div class="note-item">
            <div class="note-label">Prazo Pagamento</div>
            <div class="note-value">{{ $valores['prazo_pagamento'] ?? '15 dias' }}</div>
        </div>
        <div class="note-item">
            <div class="note-label">IVA Incluído</div>
            <div class="note-value">17%</div>
        </div>
    </div>
</div>

<!-- RODAPÉ COM ASSINATURAS -->
<div class="footer-container">
    <div class="footer-content">
        <div class="footer-item">
            <div class="footer-label">Documento</div>
            <div class="footer-value">Cotação Comercial</div>
        </div>
        <div class="footer-item">
            <div class="footer-label">Versão</div>
            <div class="footer-value">1.0</div>
        </div>
        <div class="footer-item">
            <div class="footer-label">Gerado em</div>
            <div class="footer-value">{{ $data_geracao ?? date('d/m/Y H:i') }}</div>
        </div>
    </div>
    
    <div class="footer-signature">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-name">{{ $empresa['responsavel'] ?? 'Representante YKCS' }}</div>
            <div class="signature-role">Responsável Comercial</div>
            <div class="signature-date">{{ $empresa['nome'] ?? 'Yada Key Consulting and Services' }}</div>
        </div>
        
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-name">{{ $cliente['nome'] ?? '________________________' }}</div>
            <div class="signature-role">Cliente / Responsável</div>
            <div class="signature-date">Para aceitação</div>
        </div>
    </div>
    
    <div class="footer-note">
        Documento gerado eletronicamente • {{ $empresa['nome'] ?? 'Yada Key Consulting and Services' }} • NUIT {{ $empresa['nuit'] ?? '999999999' }} • 
        Para mais informações: {{ $empresa['telefone'] ?? '+258 84 000 0000' }} | {{ $empresa['email'] ?? 'contato@yadakey.com' }}
    </div>
</div>

</body>
</html>