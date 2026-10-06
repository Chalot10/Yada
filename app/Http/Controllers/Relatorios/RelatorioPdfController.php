<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TCPDF;


class RelatorioPdfController extends Controller
{
    public function gerar()
    {
        // Criar PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Info do documento
        $pdf->SetCreator('Laravel');
        $pdf->SetAuthor('Sistema SIGEYADA');
        $pdf->SetTitle('Relatório de Candidatos');

        // Remover header/footer padrão
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Margens
        $pdf->SetMargins(15, 15, 15);

        // Fonte (UTF-8)
        $pdf->SetFont('dejavusans', '', 10);

        // Página
        $pdf->AddPage();

        // Conteúdo HTML
        $html = '
            <h2 style="text-align:center;">Relatório de Candidatos</h2>
            <hr>
            <p>Este relatório foi gerado em '.date('d/m/Y').'</p>

            <table border="1" cellpadding="5">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>João Manuel</td>
                        <td>Informática</td>
                    </tr>
                </tbody>
            </table>
        ';

        // Escrever HTML
        $pdf->writeHTML($html, true, false, true, false, '');

        // Mostrar no browser
        return response($pdf->Output('relatorio.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
