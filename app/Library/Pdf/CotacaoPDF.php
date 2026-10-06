<?php

    namespace App\Library\PDF;

    use TCPDF;

    class CotacaoPDF extends TCPDF
    {
        protected $empresa;
        protected $cotacao;
        protected $cliente;
        protected $servicos;
        protected $valores;
        
        public function __construct($cotacaoData, $empresaData)
        {
            parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
            
            $this->empresa = $empresaData;
            $this->cotacao = $cotacaoData['cotacao'];
            $this->cliente = $cotacaoData['cliente'];
            $this->servicos = $cotacaoData['servicos'];
            $this->valores = $cotacaoData['valores'];
            
            $this->setupDocument();
        }
        
        protected function setupDocument()
        {
            // Configurações do documento
            $this->SetCreator('Yada Key Consulting and Services');
            $this->SetAuthor('Yada Key Consulting and Services');
            $this->SetTitle('Cotação #' . $this->cotacao['numero']);
            $this->SetSubject('Cotação de Serviços');
            $this->SetKeywords('cotação, serviços, PDF');
            
            // Configurar margens otimizadas
            $this->SetMargins(15, 35, 15);
            $this->SetHeaderMargin(5);
            $this->SetFooterMargin(15);
            
            // Configurar quebra de página automática
            $this->SetAutoPageBreak(true, 25);
            
            // Configurar fonte padrão
            $this->SetFont('helvetica', '', 9);
            
            // Adicionar página
            $this->AddPage();
        }
        
        // Header profissional com logo no canto superior
        public function Header()
        {
            // Logo no canto superior esquerdo
            // if (file_exists('public/img/YADA_noBG.png')) {
            //     $this->Image('public/img/YADA_noBG.png', 15, 8, 35, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // }

            if (!empty($this->empresa['logo_path']) && file_exists($this->empresa['logo_path'])) {
                $this->Image($this->empresa['logo_path'], 15, 8, 35, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }

            
            
            // Informações da empresa no lado direito
            $this->SetY(10);
            $this->SetFont('helvetica', 'B', 14);
            $this->SetTextColor(44, 82, 130);
            $this->Cell(0, 6, $this->empresa['nome'], 0, 1, 'R');
            
            $this->SetFont('helvetica', '', 8);
            $this->SetTextColor(80, 80, 80);
            $this->Cell(0, 4, 'NUIT: ' . $this->empresa['nuit'] . ' | Tel: ' . $this->empresa['telefone'], 0, 1, 'R');
            $this->Cell(0, 4, $this->empresa['endereco'], 0, 1, 'R');
            $this->Cell(0, 4, 'Email: ' . $this->empresa['email'] . ' | ' . $this->empresa['website'], 0, 1, 'R');
            
            // Linha decorativa
            $this->SetY(28);
            $this->SetDrawColor(44, 82, 130);
            $this->SetLineWidth(0.5);
            $this->Line(15, $this->GetY(), 195, $this->GetY());
            
            // Segunda linha mais fina
            $this->SetLineWidth(0.2);
            $this->SetDrawColor(200, 200, 200);
            $this->Line(15, $this->GetY() + 1, 195, $this->GetY() + 1);
            
            $this->SetY($this->GetY() + 5);
        }
        
        // Fundo com marca d'água profissional
        public function setWatermarkBackground()
        {
            if (file_exists('public/img/yada.png')) {
                // Posição central com opacidade reduzida
                $this->SetAlpha(0.08);
                $this->Image('public/img/yada.png', 40, 100, 130, 150, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
                $this->SetAlpha(1);
            }
        }
        
        // Footer profissional
        public function Footer()
        {
            $this->SetY(-30);
            
            // Linha dupla decorativa
            $this->SetDrawColor(200, 200, 200);
            $this->SetLineWidth(0.2);
            $this->Line(15, $this->GetY(), 195, $this->GetY());
            
            $this->SetDrawColor(44, 82, 130);
            $this->SetLineWidth(0.5);
            $this->Line(15, $this->GetY() + 1, 195, $this->GetY() + 1);
            
            $this->SetY($this->GetY() + 5);
            
            // Informações de rodapé
            $this->SetFont('helvetica', '', 7);
            $this->SetTextColor(120, 120, 120);
            $this->Cell(0, 3, 'Documento gerado em: ' . date('d/m/Y H:i:s'), 0, 0, 'L');
            $this->Cell(0, 3, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
        }
        
        // Gerar o PDF completo
        public function gerarCotacao()
        {
            // Adicionar marca d'água de fundo
            $this->setWatermarkBackground();
            
            $this->cabecalhoCotacao();
            $this->informacoesCliente();
            $this->tabelaServicos();
            $this->resumoValores();
            $this->dadosBancarios();
            $this->condicoesPagamento();
            $this->assinaturas();
            
            return $this;
        }
        
        protected function cabecalhoCotacao()
        {
            $this->SetY(35);
            
            // Título com caixa alta e destaque
            $this->SetFont('helvetica', 'B', 22);
            $this->SetTextColor(44, 82, 130);
            $this->Cell(0, 10, 'COTAÇÃO DE SERVIÇOS', 0, 1, 'C');
            
            // Número da cotação em destaque
            $this->SetFont('helvetica', 'B', 14);
            $this->SetTextColor(80, 80, 80);
            $this->Cell(0, 8, 'Nº ' . $this->cotacao['numero'], 0, 1, 'C');
            
            $this->Ln(5);
            
            // Box de informações da cotação
            $this->SetFillColor(245, 247, 250);
            $this->SetDrawColor(44, 82, 130);
            $this->SetLineWidth(0.3);
            
            // Retângulo de fundo
            $this->Rect(15, $this->GetY(), 180, 18, 'F');
            
            $this->SetFont('helvetica', '', 9);
            $this->SetTextColor(60, 60, 60);
            
            $this->SetX(20);
            $this->Cell(30, 6, 'Data de Emissão:', 0, 0, 'L');
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(40, 6, $this->cotacao['data_emissao'], 0, 0, 'L');
            
            $this->SetFont('helvetica', '', 9);
            $this->Cell(30, 6, 'Data de Validade:', 0, 0, 'L');
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(40, 6, $this->cotacao['data_validade'], 0, 1, 'L');
            
            $this->SetX(20);
            $this->SetFont('helvetica', '', 9);
            $this->Cell(30, 6, 'Validade:', 0, 0, 'L');
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(40, 6, $this->cotacao['validade_dias'] . ' dias', 0, 0, 'L');
            
            $this->SetFont('helvetica', '', 9);
            $this->Cell(30, 6, 'Status:', 0, 0, 'L');
            $this->SetFont('helvetica', 'B', 9);
            
            // Status com cor
            $statusColors = [
                'Pendente' => [255, 193, 7, '#FFC107'],
                'Aprovada' => [40, 167, 69, '#28A745'],
                'Rejeitada' => [220, 53, 69, '#DC3545'],
                'Convertida' => [0, 123, 255, '#007BFF']
            ];
            
            $color = $statusColors[$this->cotacao['status']] ?? [108, 117, 125, '#6C757D'];
            $this->SetTextColor($color[0], $color[1], $color[2]);
            
            // Fundo para o status
            $currentY = $this->GetY();
            $this->SetFillColor($color[0], $color[1], $color[2], 20);
            $this->Rect(110, $currentY - 1, 35, 7, 'F');
            
            $this->Cell(35, 6, $this->cotacao['status'], 0, 1, 'L');
            $this->SetTextColor(0, 0, 0);
            
            $this->Ln(8);
        }
        
        protected function informacoesCliente()
        {
            $this->SetFont('helvetica', 'B', 11);
            $this->SetFillColor(44, 82, 130);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(0, 8, 'DADOS DO CLIENTE', 0, 1, 'L', true);
            
            $this->SetTextColor(40, 40, 40);
            $this->SetFont('helvetica', '', 9);
            
            $this->Ln(2);
            
            $html = '
            <style>
                .cliente-table td { padding: 3px; }
                .cliente-table b { color: #2c5282; }
            </style>
            <table class="cliente-table" cellpadding="4" border="0">
                <tr>
                    <td width="15%"><b>Cliente:</b></td>
                    <td width="35%">' . $this->cliente['nome'] . '</td>
                    <td width="15%"><b>NUIT:</b></td>
                    <td width="35%">' . $this->cliente['nuit'] . '</td>
                </tr>
                <tr>
                    <td><b>Endereço:</b></td>
                    <td>' . $this->cliente['endereco'] . '</td>
                    <td><b>Contacto:</b></td>
                    <td>' . $this->cliente['contacto'] . '</td>
                </tr>
            </table>';
            
            $this->writeHTML($html, true, false, true, false, '');
            $this->Ln(5);
        }
        
        protected function tabelaServicos()
        {
            $this->SetFont('helvetica', 'B', 11);
            $this->SetFillColor(44, 82, 130);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(0, 8, 'SERVIÇOS / PRODUTOS', 0, 1, 'L', true);
            
            $this->SetTextColor(40, 40, 40);
            $this->Ln(2);
            
            // Cabeçalho da tabela
            $this->SetFont('helvetica', 'B', 8);
            $this->SetFillColor(220, 230, 240);
            $this->SetTextColor(44, 82, 130);
            
            $this->Cell(80, 7, 'DESCRIÇÃO', 1, 0, 'C', true);
            $this->Cell(15, 7, 'QTD', 1, 0, 'C', true);
            $this->Cell(28, 7, 'PREÇO UNIT.', 1, 0, 'C', true);
            $this->Cell(15, 7, 'DESC. %', 1, 0, 'C', true);
            $this->Cell(27, 7, 'SUBTOTAL', 1, 1, 'C', true);
            
            // Dados da tabela
            $this->SetFont('helvetica', '', 8);
            $this->SetTextColor(40, 40, 40);
            $fill = false;
            
            foreach ($this->servicos as $servico) {
                $y = $this->GetY();
                
                // Descrição
                $this->MultiCell(80, 5, $servico['nome'], 1, 'L', $fill, 0);
                
                if ($this->GetY() > $y) {
                    $x = $this->GetX() + 80;
                    $this->SetY($y);
                    $this->SetX($x);
                }
                
                // Quantidade
                $this->Cell(15, 5, $servico['quantidade'], 1, 0, 'C', $fill);
                // Preço unitário
                $this->Cell(28, 5, $servico['preco_formatado'], 1, 0, 'R', $fill);
                // Desconto
                $this->Cell(15, 5, $servico['desconto_percent'] . '%', 1, 0, 'C', $fill);
                // Subtotal
                $this->SetFont('helvetica', 'B', 8);
                $this->Cell(27, 5, $servico['subtotal_formatado'], 1, 1, 'R', $fill);
                $this->SetFont('helvetica', '', 8);
                
                $fill = !$fill;
            }
            
            $this->Ln(5);
        }
        
        protected function resumoValores()
        {
            $this->SetFont('helvetica', 'B', 11);
            $this->SetFillColor(44, 82, 130);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(0, 8, 'RESUMO DOS VALORES', 0, 1, 'L', true);
            
            $this->SetTextColor(40, 40, 40);
            $this->Ln(2);
            
            // Posicionar à direita
            $this->SetX(110);
            
            $this->SetFont('helvetica', '', 9);
            $this->Cell(45, 6, 'Subtotal:', 0, 0, 'R');
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(35, 6, $this->valores['subtotal_formatado'], 0, 1, 'R');
            
            $this->SetX(110);
            $this->SetFont('helvetica', '', 9);
            $this->Cell(45, 6, 'Desconto Global (' . $this->valores['desconto_global_percent'] . '%):', 0, 0, 'R');
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(35, 6, '- ' . $this->valores['desconto_global_formatado'], 0, 1, 'R');
            
            $this->SetX(110);
            $this->SetFont('helvetica', '', 9);
            $this->Cell(45, 6, 'Subtotal com Desconto:', 0, 0, 'R');
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(35, 6, $this->valores['subtotal_com_desconto_formatado'], 0, 1, 'R');
            
            $this->SetX(110);
            $this->SetFont('helvetica', '', 9);
            $this->Cell(45, 6, 'IVA (' . $this->valores['iva_percent'] . '%):', 0, 0, 'R');
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(35, 6, $this->valores['iva_formatado'], 0, 1, 'R');
            
            // Linha separadora
            $this->SetX(110);
            $this->SetDrawColor(44, 82, 130);
            $this->SetLineWidth(0.5);
            $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 80, $this->GetY());
            
            $this->SetX(110);
            $this->SetFont('helvetica', 'B', 12);
            $this->SetTextColor(44, 82, 130);
            $this->Cell(45, 8, 'TOTAL:', 0, 0, 'R');
            $this->Cell(35, 8, $this->valores['total_formatado'], 0, 1, 'R');
            
            $this->SetTextColor(40, 40, 40);
            $this->Ln(3);
            
            // Valor por extenso
            $this->SetFont('helvetica', 'I', 7);
            $this->Cell(0, 4, 'Valor por extenso: ' . $this->valores['total_extenso'], 0, 1, 'L');
            
            $this->Ln(2);
        }
        
        protected function dadosBancarios()
        {
            $this->SetFont('helvetica', 'B', 11);
            $this->SetFillColor(44, 82, 130);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(0, 8, 'DADOS BANCÁRIOS PARA PAGAMENTO', 0, 1, 'L', true);
            
            $this->SetTextColor(40, 40, 40);
            $this->SetFont('helvetica', '', 8);
            $this->Ln(2);
            
            $html = '
            <style>
                .bank-table td { 
                    padding: 4px; 
                    border-bottom: 1px solid #eeeeee;
                }
                .bank-table b { 
                    color: #2c5282;
                }
            </style>
            <table class="bank-table" cellpadding="3" border="0" width="100%">
                <tr>
                    <td width="20%"><b>Banco:</b></td>
                    <td width="30%">' . ($this->empresa['banco'] ?? 'Banco Internacional de Moçambique (BIM)') . '</td>
                    <td width="20%"><b>NIB:</b></td>
                    <td width="30%">' . ($this->empresa['nib'] ?? '0007 0000 12345678901 23') . '</td>
                </tr>
                <tr>
                    <td><b>Nº de Conta:</b></td>
                    <td>' . ($this->empresa['conta'] ?? '123456789') . '</td>
                    <td><b>IBAN:</b></td>
                    <td>' . ($this->empresa['iban'] ?? 'MZ59 0007 0000 1234 5678 9012 3') . '</td>
                </tr>
                <tr>
                    <td><b>SWIFT/BIC:</b></td>
                    <td>' . ($this->empresa['swift'] ?? 'BICMMZMX') . '</td>
                    <td><b>Titular:</b></td>
                    <td>' . $this->empresa['nome'] . '</td>
                </tr>
            </table>';
            
            $this->writeHTML($html, true, false, true, false, '');
            $this->Ln(5);
        }
        
        protected function condicoesPagamento()
        {
            if (!empty($this->valores['prazo_pagamento'])) {
                $this->SetFont('helvetica', 'B', 11);
                $this->SetFillColor(44, 82, 130);
                $this->SetTextColor(255, 255, 255);
                $this->Cell(0, 8, 'CONDIÇÕES DE PAGAMENTO', 0, 1, 'L', true);
                
                $this->SetTextColor(40, 40, 40);
                $this->SetFont('helvetica', '', 8);
                $this->Ln(2);
                
                $this->Cell(40, 5, 'Prazo:', 0, 0, 'L');
                $this->SetFont('helvetica', 'B', 8);
                $this->Cell(0, 5, $this->valores['prazo_pagamento'], 0, 1, 'L');
                
                $this->SetFont('helvetica', 'I', 7);
                $this->Cell(0, 4, 'Pagamento deve ser efetuado por transferência bancária para os dados acima.', 0, 1, 'L');
                
                $this->Ln(3);
            }
        }
        
        protected function assinaturas()
        {
            // Ajustar posição para garantir que fique no rodapé
            $currentY = $this->GetY();
            $pageHeight = 277;
            
            if ($currentY > $pageHeight - 45) {
                $this->SetY($pageHeight - 45);
            }
            
            // Linha para assinatura
            $this->SetDrawColor(180, 180, 180);
            $this->SetLineWidth(0.3);
            $this->Line(15, $this->GetY() + 5, 90, $this->GetY() + 5);
            
            $this->SetY($this->GetY() + 7);
            $this->SetFont('helvetica', 'B', 8);
            $this->SetTextColor(44, 82, 130);
            $this->Cell(0, 4, $this->empresa['responsavel'] ?? 'Diretor Comercial', 0, 1, 'L');
            
            $this->SetFont('helvetica', '', 7);
            $this->SetTextColor(100, 100, 100);
            $this->Cell(0, 3, 'Yada Key Consulting and Services - Representante Autorizado', 0, 1, 'L');
            
            // Carimbo/QR Code à direita
            $this->Image('@' . $this->gerarQRCode(), 160, $this->GetY() - 15, 30, 30, 'PNG');
        }
        
        protected function gerarQRCode()
        {
            $qrText = "COTAÇÃO: {$this->cotacao['numero']}\n";
            $qrText .= "CLIENTE: {$this->cliente['nome']}\n";
            $qrText .= "VALOR: {$this->valores['total_formatado']}\n";
            $qrText .= "DATA: {$this->cotacao['data_emissao']}\n";
            $qrText .= "VALIDADE: {$this->cotacao['data_validade']}";
            
            return ''; // Implementar geração real de QR Code
        }
    }

// namespace App\Library\PDF;

// use TCPDF;

// class CotacaoPDF extends TCPDF
// {
//     protected $empresa;
//     protected $cotacao;
//     protected $cliente;
//     protected $servicos;
//     protected $valores;
    
//     public function __construct($cotacaoData, $empresaData)
//     {
//         parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
        
//         $this->empresa = $empresaData;
//         $this->cotacao = $cotacaoData['cotacao'];
//         $this->cliente = $cotacaoData['cliente'];
//         $this->servicos = $cotacaoData['servicos'];
//         $this->valores = $cotacaoData['valores'];
        
//         $this->setupDocument();
//     }
    
//     protected function setupDocument()
//     {
//         // Configurações do documento
//         $this->SetCreator('Yada Key Consulting and Services');
//         $this->SetAuthor('Yada Key Consulting and Services');
//         $this->SetTitle('Cotação #' . $this->cotacao['numero']);
//         $this->SetSubject('Cotação de Serviços');
//         $this->SetKeywords('cotação, serviços, PDF');
        
//         // Configurar margens (reduzidas para aproveitar espaço)
//         $this->SetMargins(12, 25, 12);
//         $this->SetHeaderMargin(5);
//         $this->SetFooterMargin(10);
        
//         // Configurar quebra de página automática (desativar para forçar 1 página)
//         $this->SetAutoPageBreak(false, 10);
        
//         // Configurar fonte padrão (reduzida)
//         $this->SetFont('helvetica', '', 8);
        
//         // Adicionar página
//         $this->AddPage();
//     }
    
//     // Header personalizado (simplificado para economizar espaço)
//     public function Header()
//     {
//         // Informações da empresa (lado direito)
//         $this->SetY(8);
//         $this->SetFont('helvetica', 'B', 12);
//         $this->Cell(0, 5, $this->empresa['nome'], 0, 1, 'R');
        
//         $this->SetFont('helvetica', '', 7);
//         $this->Cell(0, 4, 'NUIT: ' . $this->empresa['nuit'] . ' | Tel: ' . $this->empresa['telefone'], 0, 1, 'R');
//         $this->Cell(0, 4, $this->empresa['endereco'], 0, 1, 'R');
//         $this->Cell(0, 4, 'Email: ' . $this->empresa['email'] . ' | ' . $this->empresa['website'], 0, 1, 'R');
        
//         // Linha separadora
//         $this->SetY(22);
//         $this->SetDrawColor(44, 82, 130);
//         $this->SetLineWidth(0.3);
//         $this->Line(12, $this->GetY(), 198, $this->GetY());
        
//         $this->SetY($this->GetY() + 3);
//     }
    
//     // Adicionar imagem de fundo (logotipo)
//     public function setBackgroundImage($imagePath)
//     {
//         $this->Image($imagePath, 50, 80, 110, 150, '', '', '', false, 300, '', false, false, 0, false, false, true);
//     }
    
//     // Footer personalizado
//     public function Footer()
//     {
//         $this->SetY(-25);
//         $this->SetDrawColor(44, 82, 130);
//         $this->SetLineWidth(0.3);
//         $this->Line(12, $this->GetY(), 198, $this->GetY());
        
//         $this->SetY($this->GetY() + 3);
//         $this->SetFont('helvetica', '', 6);
//         $this->Cell(0, 3, 'Documento gerado em: ' . date('d/m/Y H:i:s'), 0, 0, 'L');
//         $this->Cell(0, 3, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
//     }
    
//     // Gerar o PDF completo (otimizado para caber em 1 página)
//     public function gerarCotacao()
//     {
//         // Definir imagem de fundo
//         if (file_exists('public/img/yada.png')) {
//             $this->setBackgroundImage('public/img/yada.png');
//         }
        
//         $this->cabecalhoCotacao();
//         $this->informacoesCliente();
//         $this->tabelaServicos();
//         $this->resumoValores();
//         $this->dadosBancarios(); 
//         $this->rodapeCotacao();
        
//         return $this;
//     }
    
//     protected function cabecalhoCotacao()
//     {
//         $this->SetY(25);
        
//         // Título
//         $this->SetFont('helvetica', 'B', 16);
//         $this->SetTextColor(44, 82, 130);
//         $this->Cell(0, 6, 'COTAÇÃO DE SERVIÇOS', 0, 1, 'C');
//         $this->SetTextColor(0, 0, 0);
        
//         $this->SetFont('helvetica', 'B', 10);
//         $this->Cell(0, 5, 'Nº: ' . $this->cotacao['numero'], 0, 1, 'C');
        
//         $this->Ln(2);
        
//         // Informações da cotação (em linha para economizar espaço)
//         $this->SetFont('helvetica', '', 8);
        
//         $this->SetX(12);
//         $this->Cell(25, 5, 'Emissão:', 0, 0, 'L');
//         $this->SetFont('helvetica', 'B', 8);
//         $this->Cell(30, 5, $this->cotacao['data_emissao'], 0, 0, 'L');
        
//         $this->SetFont('helvetica', '', 8);
//         $this->Cell(25, 5, 'Validade:', 0, 0, 'L');
//         $this->SetFont('helvetica', 'B', 8);
//         $this->Cell(30, 5, $this->cotacao['data_validade'] . ' (' . $this->cotacao['validade_dias'] . ' dias)', 0, 0, 'L');
        
//         $this->SetFont('helvetica', '', 8);
//         $this->Cell(20, 5, 'Status:', 0, 0, 'L');
//         $this->SetFont('helvetica', 'B', 8);
        
//         // Cor do status
//         $statusColors = [
//             'Pendente' => [255, 193, 7],
//             'Aprovada' => [40, 167, 69],
//             'Rejeitada' => [220, 53, 69],
//             'Convertida' => [0, 123, 255]
//         ];
        
//         $color = $statusColors[$this->cotacao['status']] ?? [108, 117, 125];
//         $this->SetTextColor($color[0], $color[1], $color[2]);
//         $this->Cell(30, 5, $this->cotacao['status'], 0, 1, 'L');
//         $this->SetTextColor(0, 0, 0);
        
//         $this->Ln(2);
//     }
    
//     protected function informacoesCliente()
//     {
//         $this->SetFont('helvetica', 'B', 9);
//         $this->SetFillColor(44, 82, 130);
//         $this->SetTextColor(255, 255, 255);
//         $this->Cell(0, 6, 'DADOS DO CLIENTE', 0, 1, 'L', true);
        
//         $this->SetTextColor(0, 0, 0);
//         $this->SetFont('helvetica', '', 7);
        
//         $this->Ln(1);
        
//         $html = '
//         <table cellpadding="3">
//             <tr>
//                 <td width="12%"><b>Cliente:</b></td>
//                 <td width="38%">' . $this->cliente['nome'] . '</td>
//                 <td width="10%"><b>NUIT:</b></td>
//                 <td width="40%">' . $this->cliente['nuit'] . '</td>
//             </tr>
//             <tr>
//                 <td><b>Endereço:</b></td>
//                 <td>' . $this->cliente['endereco'] . '</td>
//                 <td><b>Contacto:</b></td>
//                 <td>' . $this->cliente['contacto'] . '</td>
//             </tr>
//         </table>';
        
//         $this->writeHTML($html, true, false, true, false, '');
//         $this->Ln(2);
//     }
    
//     protected function tabelaServicos()
//     {
//         $this->SetFont('helvetica', 'B', 9);
//         $this->SetFillColor(44, 82, 130);
//         $this->SetTextColor(255, 255, 255);
//         $this->Cell(0, 6, 'SERVIÇOS', 0, 1, 'L', true);
        
//         $this->SetTextColor(0, 0, 0);
//         $this->Ln(1);
        
//         // Cabeçalho da tabela (fonte reduzida)
//         $this->SetFont('helvetica', 'B', 7);
//         $this->SetFillColor(240, 240, 240);
        
//         $this->Cell(85, 6, 'DESCRIÇÃO', 1, 0, 'C', true);
//         $this->Cell(15, 6, 'QTD', 1, 0, 'C', true);
//         $this->Cell(25, 6, 'PREÇO UNIT.', 1, 0, 'C', true);
//         $this->Cell(15, 6, 'DESC. %', 1, 0, 'C', true);
//         $this->Cell(22, 6, 'SUBTOTAL', 1, 1, 'C', true);
        
//         // Dados da tabela (fonte reduzida)
//         $this->SetFont('helvetica', '', 7);
//         $fill = false;
        
//         foreach ($this->servicos as $servico) {
//             $y = $this->GetY();
            
//             // Descrição (limitada para economizar espaço)
//             $descricao = strlen($servico['nome']) > 45 ? substr($servico['nome'], 0, 42) . '...' : $servico['nome'];
//             $this->MultiCell(85, 4, $descricao, 1, 'L', $fill, 0);
            
//             if ($this->GetY() > $y) {
//                 $x = $this->GetX() + 85;
//                 $this->SetY($y);
//                 $this->SetX($x);
//             }
            
//             // Quantidade
//             $this->Cell(15, 4, $servico['quantidade'], 1, 0, 'C', $fill);
//             // Preço unitário
//             $this->Cell(25, 4, $servico['preco_formatado'], 1, 0, 'R', $fill);
//             // Desconto
//             $this->Cell(15, 4, $servico['desconto_percent'] . '%', 1, 0, 'C', $fill);
//             // Subtotal
//             $this->Cell(22, 4, $servico['subtotal_formatado'], 1, 1, 'R', $fill);
            
//             $fill = !$fill;
//         }
        
//         $this->Ln(2);
//     }
    
//     protected function resumoValores()
//     {
//         $this->SetFont('helvetica', 'B', 9);
//         $this->SetFillColor(44, 82, 130);
//         $this->SetTextColor(255, 255, 255);
//         $this->Cell(0, 6, 'RESUMO DOS VALORES', 0, 1, 'L', true);
        
//         $this->SetTextColor(0, 0, 0);
//         $this->Ln(1);
        
//         // Posicionar à direita
//         $this->SetX(120);
        
//         $this->SetFont('helvetica', '', 7);
//         $this->Cell(35, 4, 'Subtotal:', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 7);
//         $this->Cell(30, 4, $this->valores['subtotal_formatado'], 0, 1, 'R');
        
//         $this->SetX(120);
//         $this->SetFont('helvetica', '', 7);
//         $this->Cell(35, 4, 'Desconto Global (' . $this->valores['desconto_global_percent'] . '%):', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 7);
//         $this->Cell(30, 4, '- ' . $this->valores['desconto_global_formatado'], 0, 1, 'R');
        
//         $this->SetX(120);
//         $this->SetFont('helvetica', '', 7);
//         $this->Cell(35, 4, 'Subtotal c/ Desconto:', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 7);
//         $this->Cell(30, 4, $this->valores['subtotal_com_desconto_formatado'], 0, 1, 'R');
        
//         $this->SetX(120);
//         $this->SetFont('helvetica', '', 7);
//         $this->Cell(35, 4, 'IVA (' . $this->valores['iva_percent'] . '%):', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 7);
//         $this->Cell(30, 4, $this->valores['iva_formatado'], 0, 1, 'R');
        
//         $this->SetX(120);
//         $this->SetDrawColor(44, 82, 130);
//         $this->SetLineWidth(0.3);
//         $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 65, $this->GetY());
        
//         $this->SetX(120);
//         $this->SetFont('helvetica', 'B', 9);
//         $this->SetTextColor(44, 82, 130);
//         $this->Cell(35, 5, 'TOTAL:', 0, 0, 'R');
//         $this->Cell(30, 5, $this->valores['total_formatado'], 0, 1, 'R');
        
//         $this->SetTextColor(0, 0, 0);
//         $this->Ln(1);
        
//         // Valor por extenso (fonte reduzida)
//         $this->SetFont('helvetica', 'I', 6);
//         $this->Cell(0, 3, 'Valor por extenso: ' . $this->valores['total_extenso'], 0, 1, 'L');
        
//         $this->Ln(1);
//     }
    
//     /**
//      * NOVO: Dados bancários da empresa
//      */
//     protected function dadosBancarios()
//     {
//         $this->SetFont('helvetica', 'B', 9);
//         $this->SetFillColor(44, 82, 130);
//         $this->SetTextColor(255, 255, 255);
//         $this->Cell(0, 6, 'DADOS BANCÁRIOS', 0, 1, 'L', true);
        
//         $this->SetTextColor(0, 0, 0);
//         $this->SetFont('helvetica', '', 7);
//         $this->Ln(1);
        
//         $html = '
//         <table cellpadding="2" border="0">
//             <tr>
//                 <td width="20%"><b>Banco:</b></td>
//                 <td width="30%">' . ($this->empresa['banco'] ?? 'BIM') . '</td>
//                 <td width="20%"><b>NIB:</b></td>
//                 <td width="30%">' . ($this->empresa['nib'] ?? '000000000000000000000') . '</td>
//             </tr>
//             <tr>
//                 <td><b>Nº de Conta:</b></td>
//                 <td>' . ($this->empresa['conta'] ?? '0123456789') . '</td>
//                 <td><b>IBAN:</b></td>
//                 <td>' . ($this->empresa['iban'] ?? 'MZ59 0000 0000 0000 0000 0000 0') . '</td>
//             </tr>
//             <tr>
//                 <td><b>SWIFT/BIC:</b></td>
//                 <td>' . ($this->empresa['swift'] ?? 'BICMMZMX') . '</td>
//                 <td><b>Titular:</b></td>
//                 <td>' . $this->empresa['nome'] . '</td>
//             </tr>
//         </table>';
        
//         $this->writeHTML($html, true, false, true, false, '');
//         $this->Ln(2);
//     }
    
//     protected function rodapeCotacao()
//     {
//         // Observações
//         if (!empty($this->cotacao['observacoes'])) {
//             $this->SetFont('helvetica', 'B', 9);
//             $this->SetFillColor(44, 82, 130);
//             $this->SetTextColor(255, 255, 255);
//             $this->Cell(0, 6, 'OBSERVAÇÕES', 0, 1, 'L', true);
            
//             $this->SetTextColor(0, 0, 0);
//             $this->SetFont('helvetica', '', 6);
//             $this->Ln(1);
//             $this->MultiCell(0, 3, $this->cotacao['observacoes'], 0, 'L');
//             $this->Ln(2);
//         }
        
//         // Verificar se estamos no final da página
//         $yPosition = $this->GetY();
//         $pageHeight = 277; // Altura total da página A4 em mm
//         $footerMargin = 25;
        
//         // Se estiver muito perto do rodapé, ajustar
//         if ($yPosition > $pageHeight - $footerMargin - 15) {
//             $this->SetY($pageHeight - $footerMargin - 10);
//         }
        
//         // Assinatura
//         $this->SetY(-28);
//         $this->SetDrawColor(200, 200, 200);
//         $this->SetLineWidth(0.3);
//         $this->Line(12, $this->GetY(), 80, $this->GetY());
        
//         $this->SetY($this->GetY() + 2);
//         $this->SetFont('helvetica', '', 7);
//         $this->Cell(0, 3, $this->empresa['nome'] . ' - Representante Autorizado', 0, 0, 'L');
//     }
    
//     protected function gerarQRCode()
//     {
//         // Mantido como estava
//         $qrText = "COTAÇÃO: {$this->cotacao['numero']}\n";
//         $qrText .= "CLIENTE: {$this->cliente['nome']}\n";
//         $qrText .= "VALOR: {$this->valores['total_formatado']}\n";
//         $qrText .= "DATA: {$this->cotacao['data_emissao']}\n";
//         $qrText .= "VALIDADE: {$this->cotacao['validade_dias']} dias";
        
//         return '';
//     }
// }





// namespace App\Library\PDF;

// use TCPDF;

// class CotacaoPDF extends TCPDF
// {
//     protected $empresa;
//     protected $cotacao;
//     protected $cliente;
//     protected $servicos;
//     protected $valores;
    
//     public function __construct($cotacaoData, $empresaData)
//     {
//         parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
        
//         $this->empresa = $empresaData;
//         $this->cotacao = $cotacaoData['cotacao'];
//         $this->cliente = $cotacaoData['cliente'];
//         $this->servicos = $cotacaoData['servicos'];
//         $this->valores = $cotacaoData['valores'];
        
//         $this->setupDocument();
//     }
    
//     protected function setupDocument()
//     {
//         // Configurações do documento
//         $this->SetCreator('Yada Key Consulting and Services');
//         $this->SetAuthor('Yada Key Consulting and Services');
//         $this->SetTitle('Cotação #' . $this->cotacao['numero']);
//         $this->SetSubject('Cotação de Serviços');
//         $this->SetKeywords('cotação, serviços, PDF');
        
//         // Configurar margens
//         $this->SetMargins(15, 35, 15);
//         $this->SetHeaderMargin(10);
//         $this->SetFooterMargin(15);
        
//         // Configurar quebra de página automática
//         $this->SetAutoPageBreak(true, 25);
        
//         // Configurar fonte padrão
//         $this->SetFont('helvetica', '', 10);
        
//         // Adicionar página
//         $this->AddPage();
//     }
    
//     // Header personalizado
//     public function Header()
//     {
//         // Logo (se tiver)
//         $this->Image('public/img/yada.png', 15, 10, 40);
        
//         // Informações da empresa (lado direito)
//         $this->SetY(10);
//         $this->SetFont('helvetica', 'B', 14);
//         $this->Cell(0, 6, $this->empresa['nome'], 0, 1, 'R');
        
//         $this->SetFont('helvetica', '', 9);
//         $this->Cell(0, 5, 'NUIT: ' . $this->empresa['nuit'], 0, 1, 'R');
//         $this->Cell(0, 5, $this->empresa['endereco'], 0, 1, 'R');
//         $this->Cell(0, 5, 'Tel: ' . $this->empresa['telefone'], 0, 1, 'R');
//         $this->Cell(0, 5, 'Email: ' . $this->empresa['email'], 0, 1, 'R');
//         $this->Cell(0, 5, 'Website: ' . $this->empresa['website'], 0, 1, 'R');
        
//         // Linha separadora
//         $this->SetY(33);
//         $this->SetDrawColor(44, 82, 130); // Azul escuro
//         $this->SetLineWidth(0.5);
//         $this->Line(15, $this->GetY(), 195, $this->GetY());
        
//         $this->SetY($this->GetY() + 5);
//     }
    
//     // Footer personalizado
//     public function Footer()
//     {
//         $this->SetY(-20);
//         $this->SetDrawColor(44, 82, 130);
//         $this->SetLineWidth(0.3);
//         $this->Line(15, $this->GetY(), 195, $this->GetY());
        
//         $this->SetY($this->GetY() + 5);
//         $this->SetFont('helvetica', '', 8);
//         $this->Cell(0, 4, 'Documento gerado em: ' . date('d/m/Y H:i:s'), 0, 0, 'L');
//         $this->Cell(0, 4, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
//     }
    
//     // Gerar o PDF completo
//     public function gerarCotacao()
//     {
//         $this->cabecalhoCotacao();
//         $this->informacoesCliente();
//         $this->tabelaServicos();
//         $this->resumoValores();
//         $this->informacoesPagamento();
//         $this->rodapeCotacao();
        
//         return $this;
//     }
    
//     protected function cabecalhoCotacao()
//     {
//         $this->SetY(40);
        
//         // Título
//         $this->SetFont('helvetica', 'B', 20);
//         $this->SetTextColor(44, 82, 130);
//         $this->Cell(0, 10, 'COTAÇÃO DE SERVIÇOS', 0, 1, 'C');
//         $this->SetTextColor(0, 0, 0);
        
//         $this->SetFont('helvetica', 'B', 12);
//         $this->Cell(0, 8, 'Nº: ' . $this->cotacao['numero'], 0, 1, 'C');
        
//         $this->Ln(5);
        
//         // Informações da cotação
//         $this->SetFont('helvetica', '', 10);
        
//         $this->SetFillColor(245, 247, 250);
//         $this->SetX(15);
//         $this->Cell(45, 8, 'Data de Emissão:', 0, 0, 'L');
//         $this->SetFont('helvetica', 'B', 10);
//         $this->Cell(45, 8, $this->cotacao['data_emissao'], 0, 0, 'L');
        
//         $this->SetFont('helvetica', '', 10);
//         $this->Cell(45, 8, 'Validade:', 0, 0, 'L');
//         $this->SetFont('helvetica', 'B', 10);
//         $this->Cell(45, 8, $this->cotacao['data_validade'] . ' (' . $this->cotacao['validade_dias'] . ' dias)', 0, 1, 'L');
        
//         $this->SetFont('helvetica', '', 10);
//         $this->SetX(15);
//         $this->Cell(45, 8, 'Status:', 0, 0, 'L');
//         $this->SetFont('helvetica', 'B', 10);
        
//         // Cor do status
//         $statusColors = [
//             'Pendente' => [255, 193, 7],
//             'Aprovada' => [40, 167, 69],
//             'Rejeitada' => [220, 53, 69],
//             'Convertida' => [0, 123, 255]
//         ];
        
//         $color = $statusColors[$this->cotacao['status']] ?? [108, 117, 125];
//         $this->SetTextColor($color[0], $color[1], $color[2]);
//         $this->Cell(45, 8, $this->cotacao['status'], 0, 1, 'L');
//         $this->SetTextColor(0, 0, 0);
        
//         $this->Ln(5);
//     }
    
//     protected function informacoesCliente()
//     {
//         $this->SetFont('helvetica', 'B', 12);
//         $this->SetFillColor(44, 82, 130);
//         $this->SetTextColor(255, 255, 255);
//         $this->Cell(0, 10, 'DADOS DO CLIENTE', 0, 1, 'L', true);
        
//         $this->SetTextColor(0, 0, 0);
//         $this->SetFont('helvetica', '', 10);
        
//         $this->Ln(3);
        
//         $html = '
//         <table cellpadding="5">
//             <tr>
//                 <td width="15%"><b>Cliente:</b></td>
//                 <td width="35%">' . $this->cliente['nome'] . '</td>
//                 <td width="15%"><b>NUIT:</b></td>
//                 <td width="35%">' . $this->cliente['nuit'] . '</td>
//             </tr>
//             <tr>
//                 <td><b>Endereço:</b></td>
//                 <td>' . $this->cliente['endereco'] . '</td>
//                 <td><b>Contacto:</b></td>
//                 <td>' . $this->cliente['contacto'] . '</td>
//             </tr>
//         </table>';
        
//         $this->writeHTML($html, true, false, true, false, '');
//         $this->Ln(5);
//     }
    
//     protected function tabelaServicos()
//     {
//         $this->SetFont('helvetica', 'B', 12);
//         $this->SetFillColor(44, 82, 130);
//         $this->SetTextColor(255, 255, 255);
//         $this->Cell(0, 10, 'SERVIÇOS', 0, 1, 'L', true);
        
//         $this->SetTextColor(0, 0, 0);
//         $this->Ln(3);
        
//         // Cabeçalho da tabela
//         $this->SetFont('helvetica', 'B', 9);
//         $this->SetFillColor(240, 240, 240);
        
//         $this->Cell(80, 10, 'DESCRIÇÃO', 1, 0, 'C', true);
//         $this->Cell(20, 10, 'QTD', 1, 0, 'C', true);
//         $this->Cell(30, 10, 'PREÇO UNIT.', 1, 0, 'C', true);
//         $this->Cell(20, 10, 'DESC. %', 1, 0, 'C', true);
//         $this->Cell(25, 10, 'SUBTOTAL', 1, 1, 'C', true);
        
//         // Dados da tabela
//         $this->SetFont('helvetica', '', 9);
//         $fill = false;
        
//         foreach ($this->servicos as $servico) {
//             $y = $this->GetY();
            
//             // Descrição
//             $this->MultiCell(80, 6, $servico['nome'], 1, 'L', $fill, 0);
            
//             if ($this->GetY() > $y) {
//                 $x = $this->GetX() + 80;
//                 $this->SetY($y);
//                 $this->SetX($x);
//             }
            
//             // Quantidade
//             $this->Cell(20, 6, $servico['quantidade'], 1, 0, 'C', $fill);
//             // Preço unitário
//             $this->Cell(30, 6, $servico['preco_formatado'], 1, 0, 'R', $fill);
//             // Desconto
//             $this->Cell(20, 6, $servico['desconto_percent'] . '%', 1, 0, 'C', $fill);
//             // Subtotal
//             $this->Cell(25, 6, $servico['subtotal_formatado'], 1, 1, 'R', $fill);
            
//             $fill = !$fill;
//         }
        
//         $this->Ln(5);
//     }
    
//     protected function resumoValores()
//     {
//         $this->SetFont('helvetica', 'B', 11);
//         $this->SetFillColor(44, 82, 130);
//         $this->SetTextColor(255, 255, 255);
//         $this->Cell(0, 8, 'RESUMO DOS VALORES', 0, 1, 'L', true);
        
//         $this->SetTextColor(0, 0, 0);
//         $this->Ln(3);
        
//         // Posicionar à direita
//         $this->SetX(115);
        
//         $this->SetFont('helvetica', '', 10);
//         $this->Cell(40, 8, 'Subtotal:', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 10);
//         $this->Cell(40, 8, $this->valores['subtotal_formatado'], 0, 1, 'R');
        
//         $this->SetX(115);
//         $this->SetFont('helvetica', '', 10);
//         $this->Cell(40, 8, 'Desconto Global (' . $this->valores['desconto_global_percent'] . '%):', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 10);
//         $this->Cell(40, 8, '- ' . $this->valores['desconto_global_formatado'], 0, 1, 'R');
        
//         $this->SetX(115);
//         $this->SetFont('helvetica', '', 10);
//         $this->Cell(40, 8, 'Subtotal c/ Desconto:', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 10);
//         $this->Cell(40, 8, $this->valores['subtotal_com_desconto_formatado'], 0, 1, 'R');
        
//         $this->SetX(115);
//         $this->SetFont('helvetica', '', 10);
//         $this->Cell(40, 8, 'IVA (' . $this->valores['iva_percent'] . '%):', 0, 0, 'R');
//         $this->SetFont('helvetica', 'B', 10);
//         $this->Cell(40, 8, $this->valores['iva_formatado'], 0, 1, 'R');
        
//         $this->SetX(115);
//         $this->SetDrawColor(44, 82, 130);
//         $this->SetLineWidth(0.5);
//         $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 80, $this->GetY());
        
//         $this->SetX(115);
//         $this->SetFont('helvetica', 'B', 12);
//         $this->SetTextColor(44, 82, 130);
//         $this->Cell(40, 10, 'TOTAL:', 0, 0, 'R');
//         $this->Cell(40, 10, $this->valores['total_formatado'], 0, 1, 'R');
        
//         $this->SetTextColor(0, 0, 0);
//         $this->Ln(5);
        
//         // Valor por extenso
//         $this->SetFont('helvetica', 'I', 9);
//         $this->Cell(0, 6, 'Valor por extenso: ' . $this->valores['total_extenso'], 0, 1, 'L');
        
//         $this->Ln(5);
//     }
    
//     protected function informacoesPagamento()
//     {
//         if (!empty($this->valores['prazo_pagamento'])) {
//             $this->SetFont('helvetica', 'B', 11);
//             $this->SetFillColor(44, 82, 130);
//             $this->SetTextColor(255, 255, 255);
//             $this->Cell(0, 8, 'INFORMAÇÕES DE PAGAMENTO', 0, 1, 'L', true);
            
//             $this->SetTextColor(0, 0, 0);
//             $this->SetFont('helvetica', '', 10);
//             $this->Ln(3);
            
//             $this->Cell(40, 6, 'Prazo de Pagamento:', 0, 0, 'L');
//             $this->SetFont('helvetica', 'B', 10);
//             $this->Cell(0, 6, $this->valores['prazo_pagamento'], 0, 1, 'L');
            
//             $this->Ln(3);
//         }
//     }
    
//     protected function rodapeCotacao()
//     {
//         if (!empty($this->cotacao['observacoes'])) {
//             $this->SetFont('helvetica', 'B', 11);
//             $this->SetFillColor(44, 82, 130);
//             $this->SetTextColor(255, 255, 255);
//             $this->Cell(0, 8, 'OBSERVAÇÕES', 0, 1, 'L', true);
            
//             $this->SetTextColor(0, 0, 0);
//             $this->SetFont('helvetica', '', 9);
//             $this->Ln(3);
//             $this->MultiCell(0, 5, $this->cotacao['observacoes'], 0, 'L');
//         }
        
//         $this->Ln(5);
        
//         // Assinatura
//         $this->SetY(-45);
//         $this->SetDrawColor(200, 200, 200);
//         $this->SetLineWidth(0.3);
//         $this->Line(15, $this->GetY(), 100, $this->GetY());
        
//         $this->SetY($this->GetY() + 3);
//         $this->SetFont('helvetica', '', 9);
//         $this->Cell(0, 5, 'Yada Key Consulting and Services - Representante Autorizado', 0, 0, 'L');
        
//         // QR Code
//         $this->Image('@' . $this->gerarQRCode(), 160, $this->GetY() - 15, 35, 35, 'PNG');
//     }
    
//     protected function gerarQRCode()
//     {
//         // Requer: composer require simplesoftwareio/simple-qrcode
//         $qrText = "COTAÇÃO: {$this->cotacao['numero']}\n";
//         $qrText .= "CLIENTE: {$this->cliente['nome']}\n";
//         $qrText .= "VALOR: {$this->valores['total_formatado']}\n";
//         $qrText .= "DATA: {$this->cotacao['data_emissao']}\n";
//         $qrText .= "VALIDADE: {$this->cotacao['validade_dias']} dias";
        
//         // if (class_exists('SimpleSoftwareIO\QrCode\QrCode')) {
//         //     return \QrCode::format('png')
//         //         ->size(300)
//         //         ->margin(1)
//         //         ->color(44, 82, 130)
//         //         ->generate($qrText);
//         // }
        
//         return '';
//     }
// }