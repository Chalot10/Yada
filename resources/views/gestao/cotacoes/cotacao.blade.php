<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotacao_{{ $dados['cotacao']['numero'] ?? '' }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c5282;
        }
        
        .header h1 {
            color: #2c5282;
            font-size: 24px;
            margin: 0;
        }
        
        .header .subtitle {
            color: #4a5568;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .info-section {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f7fafc;
            border-radius: 5px;
        }
        
        .info-section h2 {
            color: #2d3748;
            font-size: 16px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #cbd5e0;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .info-item {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            color: #4a5568;
        }
        
        .info-value {
            color: #2d3748;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .table th {
            background-color: #2c5282;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        .table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table tr:nth-child(even) {
            background-color: #f7fafc;
        }
        
        .table tr:hover {
            background-color: #edf2f7;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totais {
            margin-top: 30px;
            padding: 15px;
            background-color: #f0fff4;
            border-radius: 5px;
            border-left: 4px solid #38a169;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #cbd5e0;
        }
        
        .total-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 16px;
            color: #2c5282;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #cbd5e0;
            font-size: 10px;
            color: #718096;
            text-align: center;
        }
        
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .status-pendente {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-aprovada {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .empresa-info {
            background-color: #ebf8ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4299e1;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>COTAÇÃO DE SERVIÇOS</h1>
        <div class="subtitle">
            Nº: <strong>{{ $dados['cotacao']['numero'] ?? 'N/A' }}</strong>
            <span class="status-badge status-{{ strtolower($dados['cotacao']['status'] ?? 'pendente') }}">
                {{ $dados['cotacao']['status'] ?? 'Pendente' }}
            </span>
        </div>
    </div>
    
    <!-- Informações da Empresa -->
    <div class="empresa-info">
        <h2>{{ $dados['empresa']['nome'] ?? 'Yada Key Consulting and Services' }}</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">NUIT:</span>
                <span class="info-value">{{ $dados['empresa']['nuit'] ?? '999999999' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Endereço:</span>
                <span class="info-value">{{ $dados['empresa']['endereco'] ?? 'Maputo, Moçambique' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Telefone:</span>
                <span class="info-value">{{ $dados['empresa']['telefone'] ?? '+258 84 913 0222' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $dados['empresa']['email'] ?? 'yada@fbn.com' }}</span>
            </div>
        </div>
    </div>
    
    <!-- Informações do Cliente -->
    <div class="info-section">
        <h2>DADOS DO CLIENTE</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nome:</span>
                <span class="info-value">{{ $dados['cliente']['nome'] ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">NUIT:</span>
                <span class="info-value">{{ $dados['cliente']['nuit'] ?? 'Não informado' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Endereço:</span>
                <span class="info-value">{{ $dados['cliente']['endereco'] ?? 'Não informado' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Contacto:</span>
                <span class="info-value">{{ $dados['cliente']['contacto'] ?? 'N/A' }}</span>
            </div>
        </div>
    </div>
    
    <!-- Informações da Cotação -->
    <div class="info-section">
        <h2>DETALHES DA COTAÇÃO</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Data de Emissão:</span>
                <span class="info-value">{{ $dados['cotacao']['data_emissao'] ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Validade:</span>
                <span class="info-value">{{ $dados['cotacao']['data_validade'] ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Prazo de Pagamento:</span>
                <span class="info-value">{{ $dados['pagamento']['prazo_dias'] ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ $dados['cotacao']['status'] ?? 'Pendente' }}</span>
            </div>
        </div>
    </div>
    
    <!-- Tabela de Serviços -->
    <h2>SERVIÇOS SOLICITADOS</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Descrição do Serviço</th>
                <th class="text-center">Qtd.</th>
                <th class="text-right">Preço Unitário</th>
                <th class="text-center">Desc. %</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados['servicos'] as $servico)
            <tr>
                <td>{{ $servico['nome'] }}</td>
                <td class="text-center">{{ $servico['quantidade'] }}</td>
                <td class="text-right">MZN {{ $servico['preco_formatado'] }}</td>
                <td class="text-center">{{ $servico['desconto_percent'] }}%</td>
                <td class="text-right">MZN {{ $servico['subtotal_formatado'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Totais -->
    <div class="totais">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>MZN {{ $dados['valores']['subtotal_formatado'] ?? '0.00' }}</span>
        </div>
        <div class="total-row">
            <span>Desconto Global ({{ $dados['valores']['desconto_global_percent'] ?? '0' }}%):</span>
            <span>- MZN {{ $dados['valores']['desconto_global_formatado'] ?? '0.00' }}</span>
        </div>
        <div class="total-row">
            <span>Subtotal com Desconto:</span>
            <span>MZN {{ $dados['valores']['subtotal_com_desconto_formatado'] ?? '0.00' }}</span>
        </div>
        <div class="total-row">
            <span>IVA (17%):</span>
            <span>MZN {{ $dados['valores']['iva_formatado'] ?? '0.00' }}</span>
        </div>
        <div class="total-row">
            <span><strong>TOTAL:</strong></span>
            <span><strong>MZN {{ $dados['valores']['total_formatado'] ?? '0.00' }}</strong></span>
        </div>
    </div>
    
    <!-- Observações -->
    <div class="info-section">
        <h2>OBSERVAÇÕES</h2>
        <p>{{ $dados['observacoes'] ?? 'Esta cotação é válida até a data indicada acima. Para dúvidas, contacte-nos.' }}</p>
        
        <!-- QR Code (opcional) -->
        @if(isset($dados['cotacao']['numero']))
        <div class="qr-code">
            <!-- Você pode gerar QR code aqui usando uma biblioteca -->
            <p style="color: #718096; font-size: 10px;">
                Código: {{ $dados['cotacao']['numero'] }}<br>
                Validade: {{ $dados['cotacao']['data_validade'] ?? 'N/A' }}
            </p>
        </div>
        @endif
    </div>
    
    <!-- Rodapé -->
    <div class="footer">
        <p>Documento gerado automaticamente pelo sistema em {{ date('d/m/Y H:i:s') }}</p>
        <p>{{ $dados['empresa']['nome'] ?? 'Yada Key Consulting and Services' }} • NUIT: {{ $dados['empresa']['nuit'] ?? '999999999' }}</p>
        <p>Página 1 de 1</p>
    </div>
</body>
</html>