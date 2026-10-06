<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotacao de Serviços</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2c5282;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f7fafc;
            padding: 20px;
            border: 1px solid #e2e8f0;
        }
        .info-box {
            background-color: white;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
        .total-box {
            background-color: #c6f6d5;
            border: 2px solid #38a169;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            background-color: #edf2f7;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 12px;
            color: #718096;
        }
        .btn {
            display: inline-block;
            background-color: #38a169;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn-whatsapp {
            background-color: #25D366;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>COTAÇÃO DE SERVIÇOS</h1>
        <p>Yada Key Consulting and Services</p>
    </div>
    
    <div class="content">
        <p>Prezado(a) <strong>{{ $cliente_nome }}</strong>,</p>
        
        <p>Segue em anexo a sua cotação de serviços detalhada.</p>
        
        <div class="info-box">
            <h3>📋 Informações da Cotação</h3>
            <p><strong>Número:</strong> {{ $numero_cotacao }}</p>
            <p><strong>Validade:</strong> {{ $data_validade }}</p>
            <p><strong>Valor Total:</strong> {{ $valor_total }}</p>
        </div>
        
        <div class="total-box">
            <h3>💰 Resumo Financeiro</h3>
            <p>A cotação completa está disponível no PDF anexado.</p>
        </div>
        
        <p>{{ $mensagem }}</p>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="https://wa.me/?text=Olá,%20recebi%20a%20cotação%20{{ $numero_cotacao }}" 
               class="btn btn-whatsapp" target="_blank">
                📱 Falar no WhatsApp
            </a>
        </div>
        
        <p>Para aprovar esta cotação, dúvidas ou ajustes, entre em contato conosco.</p>
    </div>
    
    <div class="footer">
        <p><strong>{{ $empresa_nome }}</strong></p>
        <p>📞 {{ $empresa_telefone }}</p>
        <p>📧 {{ $empresa_email ?? 'yada@fbn.com' }}</p>
        <p style="font-size: 11px; margin-top: 15px;">
            Este email foi gerado automaticamente. Por favor, não responda a este email.
        </p>
    </div>
</body>
</html>