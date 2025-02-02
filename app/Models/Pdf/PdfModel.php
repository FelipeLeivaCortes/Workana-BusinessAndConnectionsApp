<?php

namespace Models\Pdf;

require '../vendor/autoload.php';
use Models\MasterModel;
include __DIR__ . "/../../../config/conf.php";

use function Helpers\dd;

Class PdfModel extends MasterModel
{
    private $mpdf;
    
    public function __construct()
    {
        $this->mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
            'font-size' => 11,
            'curlAllowUnsafeSslRequests' => true
        ]);
    }
    public function generatePdf(string $template, int $id, string $folderType)
    {
        $html = $template;
        $this->mpdf->WriteHTML($html);
    
        $folderName = ($folderType === 'quotes') ? 'quotes' : 'orders';
        $folderPath = 'uploads/' . $folderName . '/' . $id . '/';
    
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }
    
        $fileName = 'Document_'.$folderType.'_' . $id . '_' . date('YmdHis') . '.pdf';
        $filePath = $folderPath . $fileName;
    
        $this->mpdf->Output($filePath, 'F');
    
        return $filePath;
    }
    
    public static function templateQuotePdf(array $data) {
        require_once '../config/global.php';

        $quotePdf   = '<!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Cotización</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 12px;
                            margin: 20px;
                        }
                        .header {
                            width: 100%;
                            margin-bottom: 20px;
                            display: table;
                            height: 40px;
                        }
                        .logo-container {
                            display: table-cell;
                            vertical-align: top;
                            width: 25%;
                        }
                        .header img {
                            height: 35px;
                            width: auto;
                        }
                        .company-info {
                            display: table-cell;
                            vertical-align: top;
                            width: 50%;
                            text-align: center;
                        }
                        .company-info h2 {
                            margin: 0;
                            font-size: 14px;
                            font-weight: bold;
                        }
                        .company-info p {
                            margin: 0;
                            font-size: 10px;
                            line-height: 1;
                        }
                        .quote-info {
                            display: table-cell;
                            vertical-align: top;
                            width: 25%;
                            text-align: right;
                        }
                        .quote-info h2 {
                            margin: 0;
                            font-size: 14px;
                            font-weight: bold;
                        }
                        .quote-info p {
                            margin: 0;
                            font-size: 11px;
                            line-height: 1.1;
                        }
                        .products-table-container {
                            border: 1px solid #000;
                            border-radius: 8px;
                            overflow: hidden;
                            margin-bottom: 20px;
                            height: 300px; /* Altura fija para el contenedor */
                        }
                        .products-table {
                            width: 100%;
                            border-collapse: separate;
                            border-spacing: 0;
                            border: none;
                            height: 100%; /* Para que ocupe todo el alto del contenedor */
                        }
                        .products-table tbody {
                            height: calc(100% - 40px); /* Resta el espacio del encabezado */
                            display: block;
                            overflow-y: hidden; /* Oculta el scroll vertical */
                        }
                        .products-table thead {
                            display: table;
                            width: 100%;
                            table-layout: fixed;
                        }
                        .products-table tbody tr {
                            display: table;
                            width: 100%;
                            table-layout: fixed;
                        }
                        .products-table td:nth-child(1), /* CODIGO */
                        .products-table td:nth-child(2), /* CODIGO 2 */
                        .products-table td:nth-child(4), /* CANT */
                        .products-table td:nth-child(5), /* UM */
                        .products-table td:nth-child(6), /* VR UNITARIO */
                        .products-table td:nth-child(7) { /* VR TOTAL */
                            text-align: center;
                        }
                        .table-container {
                            border: 1px solid #000;
                            border-radius: 8px;
                            overflow: hidden;
                            margin-bottom: 20px;
                        }
                        .client-table {
                            width: 100%;
                            border-collapse: collapse;
                            background-color: white;
                        }
                        .client-table td {
                            border: 1px solid #000;
                            padding: 5px;
                            height: 35px; /* Altura fija para todas las celdas */
                            vertical-align: middle; /* Para centrar el contenido verticalmente */
                        }
                        .client-header {
                            background-color: #f0f0f0;
                            text-align: center;
                            font-weight: bold;
                            padding: 5px;
                            border-bottom: 1px solid #000;
                        }
                        .totals-container {
                            width: 100%;
                            margin-bottom: 20px;
                        }
                        .comments {
                            width: 50%;
                            float: left;
                        }
                        .comments table {
                            width: 100%;
                            border: 1px solid #000;
                            border-collapse: collapse;
                        }
                        .comments td {
                            padding: 5px;
                            vertical-align: top;
                            height: 90px;
                        }
                        .totals {
                            width: 50%;
                            float: right;
                        }
                        .totals table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        .totals td {
                            padding: 5px;
                            border: 1px solid #000;
                            height: 30px;
                        }
                        .totals td:last-child {
                            text-align: right;
                        }
                        .signature {
                            margin-top: 30px;
                            width: 100%;
                        }
                        .signature-content {
                            width: 200px;
                            float: right;
                            margin-right: 50px;
                            text-align: center;
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 10px;
                            width: 100%;
                        }
                        .footer hr {
                            width: 100%;
                            border-top: 1px solid black;
                            margin-bottom: 5px;
                        }
                        .footer-content {
                            width: 100%;
                        }
                        .footer-content .left {
                            float: left;
                        }
                        .footer-content .right {
                            float: right;
                        }
                    </style>
                </head>

                <body>
                    <div class="header">
                        <div class="logo-container" style="float: left;">
                            <img src="'.LOGO_SOLMAQ.'">
                        </div>
                        <div class="company-info" style="float: left;">
                            <h2>IMPORTADORES EXPORTADORES SOLMAQ SAS</h2>
                            <p><b>NIT: 860054854-5</b></p>
                            <p>Cra 30 NO. 15-30 <b>BOGOTÁ</b></p>
                            <p><b>PBX: (1) 3647474</b></p>
                            <p><b>e-mail: servicioalcliente@solmaq.com</b></p>
                        </div>
                        <div class="quote-info">
                            <h2><b>COTIZACIÓN</b></h2>
                            <p><b>No. '.$data['quote']['id'].'</b></p>
                        </div>
                    </div>

                    <p style="text-align: right; margin-bottom: 10px;"><b>Fecha: ' . date('d/m/Y') . '</b></p>

                    <div class="table-container">
                        <div class="client-header">DATOS CLIENTE</div>
                        <table class="client-table">
                            <tr>
                                <td style="width: 15%;"><b>CLIENTE:</b></td>
                                <td style="width: 35%;">'.$data['customer']['name'].'</td>
                                <td style="width: 15%;"><b>NIT:</b></td>
                                <td style="width: 35%;">'.$data['customer']['nit'].'</td>
                            </tr>
                            <tr>
                                <td><b>CONTACTO:</b></td>
                                <td>'.$data['contact']['name'].'</td>
                                <td><b>ASESOR<br>COMERCIAL:</b></td>
                                <td>'.$data['quote']['seller'].'</td>
                            </tr>
                            <tr>
                                <td><b>DIRECCIÓN:</b></td>
                                <td>'.$data['customer']['address'].'</td>
                                <td><b>CONDICIÓN DE<br>PAGO:</b></td>
                                <td>'.$data['quote']['payment_method'].'</td>
                            </tr>
                            <tr>
                                <td><b>CIUDAD:</b></td>
                                <td>'.$data['customer']['city'].'</td>
                                <td><b>VALIDEZ<br>HASTA:</b></td>
                                <td>'.$data['quote']['date_expired'].'</td>
                            </tr>
                            <tr>
                                <td><b>TELÉFONO:</b></td>
                                <td>'.$data['contact']['phone'].'</td>
                                <td><b>REFERENCIA:</b></td>
                                <td>'.$data['contact']['reference'].'</td>
                            </tr>
                        </table>
                    </div>

                    <div class="products-table-container">
                        <table class="products-table">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>CÓDIGO 2</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>CANT</th>
                                    <th>UM</th>
                                    <th>VR UNITARIO</th>
                                    <th>VR TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

                            $total_article  = 0;

                            foreach ($data['articles'] as $articles) {
                                $article            = $articles[0];
                                $quantity           = $articles['quantity'];
                                $price              = $articles['price'];
                                $subtotalArticle    = $quantity * $price;
                                $total_article      += $subtotalArticle;

                                $quotePdf .= "<tr>
                                    <td>" . $article['ar_id'] . "</td>
                                    <td>" . $article['ar_code'] . "</td>
                                    <td>" . $article['ar_desc'] . "</td>
                                    <td>" . $quantity . "</td>
                                    <td>UN</td>
                                    <td>$ " . number_format($price, 2, ',', '.') . "</td>
                                    <td>$ " . number_format($subtotalArticle, 2, ',', '.') . "</td>
                                </tr>";
                            }

                            $iva        = $total_article * 0.19;
                            $total      = $total_article + $iva;
                            $quotePdf   .= '</tbody>
                        </table>
                    </div>

                    <p>Favor verificar cantidades y referencias; luego de emitida la orden de compra y factura no aceptamos cambios ni devoluciones de mercancía.</p>
                   
                    <div class="totals-container">
                        <div class="comments">
                            <table>
                                <tr>
                                    <td><b>COMENTARIOS:</b><br>'.$data['quote']['comments'].'</td>
                                </tr>
                            </table>
                        </div>
                        <div class="totals">
                            <table>
                                <tr>
                                    <td><b>SUBTOTAL</b></td>
                                    <td>$ ' . number_format($total_article, 2, ',', '.') . '</td>
                                </tr>
                                <tr>
                                    <td><b>IVA</b></td>
                                    <td>$ ' . number_format($iva, 2, ',', '.') . '</td>
                                </tr>
                                <tr>
                                    <td><b>TOTAL</b></td>
                                    <td>$ ' . number_format($total, 2, ',', '.') . '</td>
                                </tr>
                            </table>
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                    <div class="signature">
                        <div class="signature-content">
                            <p style="margin-bottom: 5px;">'.$data['quote']['name_employee'].' -- bloqueado</p>
                            <hr style="width: 100%; border-top: 1px solid black; margin: 0;">
                            <p style="margin-top: 5px;"><b>ELABORÓ</b></p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                    <div class="footer">
                        <hr>
                        <div class="footer-content">
                            <span class="left">Pag. 1 de 1</span>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </body>
            </html>';
        
        return $quotePdf;
    }

    public static function templateOrderPdf(array $data, array $fieldName= NULL,array $fieldValue= NULL, $orderDiscountTotal, $orderAdditionCost){
        require_once '../config/global.php';

        $orderPdf   = '<!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Órden de Venta</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 12px;
                            margin: 20px;
                        }
                        .header {
                            width: 100%;
                            margin-bottom: 20px;
                            display: table;
                            height: 40px;
                        }
                        .logo-container {
                            display: table-cell;
                            vertical-align: top;
                            width: 25%;
                        }
                        .header img {
                            height: 35px;
                            width: auto;
                        }
                        .company-info {
                            display: table-cell;
                            vertical-align: top;
                            width: 50%;
                            text-align: center;
                        }
                        .company-info h2 {
                            margin: 0;
                            font-size: 14px;
                            font-weight: bold;
                        }
                        .company-info p {
                            margin: 0;
                            font-size: 10px;
                            line-height: 1;
                        }
                        .quote-info {
                            display: table-cell;
                            vertical-align: top;
                            width: 25%;
                            text-align: right;
                        }
                        .quote-info h2 {
                            margin: 0;
                            font-size: 14px;
                            font-weight: bold;
                        }
                        .quote-info p {
                            margin: 0;
                            font-size: 11px;
                            line-height: 1.1;
                        }
                        .products-table-container {
                            border: 1px solid #000;
                            border-radius: 8px;
                            overflow: hidden;
                            margin-bottom: 20px;
                            height: 300px; /* Altura fija para el contenedor */
                        }
                        .products-table {
                            width: 100%;
                            border-collapse: separate;
                            border-spacing: 0;
                            border: none;
                            height: 100%; /* Para que ocupe todo el alto del contenedor */
                        }
                        .products-table tbody {
                            height: calc(100% - 40px); /* Resta el espacio del encabezado */
                            display: block;
                            overflow-y: hidden; /* Oculta el scroll vertical */
                        }
                        .products-table thead {
                            display: table;
                            width: 100%;
                            table-layout: fixed;
                        }
                        .products-table tbody tr {
                            display: table;
                            width: 100%;
                            table-layout: fixed;
                        }
                        .products-table td:nth-child(1), /* CODIGO */
                        .products-table td:nth-child(2), /* CODIGO 2 */
                        .products-table td:nth-child(4), /* CANT */
                        .products-table td:nth-child(5), /* UM */
                        .products-table td:nth-child(6), /* VR UNITARIO */
                        .products-table td:nth-child(7) { /* VR TOTAL */
                            text-align: center;
                        }
                        .table-container {
                            border: 1px solid #000;
                            border-radius: 8px;
                            overflow: hidden;
                            margin-bottom: 20px;
                        }
                        .client-table {
                            width: 100%;
                            border-collapse: collapse;
                            background-color: white;
                        }
                        .client-table td {
                            border: 1px solid #000;
                            padding: 5px;
                            height: 35px; /* Altura fija para todas las celdas */
                            vertical-align: middle; /* Para centrar el contenido verticalmente */
                        }
                        .client-header {
                            background-color: #f0f0f0;
                            text-align: center;
                            font-weight: bold;
                            padding: 5px;
                            border-bottom: 1px solid #000;
                        }
                        .totals-container {
                            width: 100%;
                            margin-bottom: 20px;
                        }
                        .comments {
                            width: 50%;
                            float: left;
                        }
                        .comments table {
                            width: 100%;
                            border: 1px solid #000;
                            border-collapse: collapse;
                        }
                        .comments td {
                            padding: 5px;
                            vertical-align: top;
                            height: 90px;
                        }
                        .totals {
                            width: 50%;
                            float: right;
                        }
                        .totals table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        .totals td {
                            padding: 5px;
                            border: 1px solid #000;
                            height: 30px;
                        }
                        .totals td:last-child {
                            text-align: right;
                        }
                        .signature {
                            margin-top: 30px;
                            width: 100%;
                        }
                        .signature-content {
                            width: 200px;
                            float: right;
                            margin-right: 50px;
                            text-align: center;
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 10px;
                            width: 100%;
                        }
                        .footer hr {
                            width: 100%;
                            border-top: 1px solid black;
                            margin-bottom: 5px;
                        }
                        .footer-content {
                            width: 100%;
                        }
                        .footer-content .left {
                            float: left;
                        }
                        .footer-content .right {
                            float: right;
                        }
                    </style>
                </head>

                <body>
                    <div class="header">
                        <div class="logo-container" style="float: left;">
                            <img src="'.LOGO_SOLMAQ.'">
                        </div>
                        <div class="company-info" style="float: left;">
                            <h2>IMPORTADORES EXPORTADORES SOLMAQ SAS</h2>
                            <p><b>NIT: 860054854-5</b></p>
                            <p>Cra 30 NO. 15-30 <b>BOGOTÁ</b></p>
                            <p><b>PBX: (1) 3647474</b></p>
                            <p><b>e-mail: servicioalcliente@solmaq.com</b></p>
                        </div>
                        <div class="quote-info">
                            <h2><b>ÓRDEN DE VENTA</b></h2>
                            <p><b>No. '.$data['order']['id'].'</b></p>
                        </div>
                    </div>

                    <p style="text-align: right; margin-bottom: 10px;"><b>Fecha: ' . date('d/m/Y') . '</b></p>

                    <div class="table-container">
                        <div class="client-header">DATOS CLIENTE</div>
                        <table class="client-table">
                            <tr>
                                <td style="width: 15%;"><b>CLIENTE:</b></td>
                                <td style="width: 35%;">'.$data['customer']['name'].'</td>
                                <td style="width: 15%;"><b>NIT:</b></td>
                                <td style="width: 35%;">'.$data['customer']['nit'].'</td>
                            </tr>
                            <tr>
                                <td><b>CONTACTO:</b></td>
                                <td>'.$data['contact']['name'].'</td>
                                <td><b>ASESOR<br>COMERCIAL:</b></td>
                                <td>'.$data['order']['seller'].'</td>
                            </tr>
                            <tr>
                                <td><b>DIRECCIÓN:</b></td>
                                <td>'.$data['customer']['address'].'</td>
                                <td><b>CONDICIÓN DE<br>PAGO:</b></td>
                                <td>'.$data['order']['payment_method'].'</td>
                            </tr>
                            <tr>
                                <td><b>CIUDAD:</b></td>
                                <td>'.$data['customer']['city'].'</td>
                                <td><b>VALIDEZ<br>HASTA:</b></td>
                                <td>'.$data['order']['date_expired'].'</td>
                            </tr>
                            <tr>
                                <td><b>TELÉFONO:</b></td>
                                <td>'.$data['contact']['phone'].'</td>
                                <td><b>REFERENCIA:</b></td>
                                <td>'.$data['contact']['reference'].'</td>
                            </tr>
                        </table>
                    </div>

                    <div class="products-table-container">
                        <table class="products-table">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>CÓDIGO 2</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>CANT</th>
                                    <th>UM</th>
                                    <th>VR UNITARIO</th>
                                    <th>VR TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

                            $total_article  = 0;

                            foreach ($data['articles'] as $articles) {
                                $article            = $articles[0];
                                $quantity           = $articles['quantity'];
                                $price              = $articles['price'];
                                $subtotalArticle    = $quantity * $price;
                                $total_article      += $subtotalArticle;

                                $orderPdf .= "<tr>
                                    <td>" . $article['ar_id'] . "</td>
                                    <td>" . $article['ar_code'] . "</td>
                                    <td>" . $article['ar_desc'] . "</td>
                                    <td>" . $quantity . "</td>
                                    <td>UN</td>
                                    <td>$ " . number_format($price, 2, ',', '.') . "</td>
                                    <td>$ " . number_format($subtotalArticle, 2, ',', '.') . "</td>
                                </tr>";
                            }

                            $iva        = $total_article * 0.19;
                            $total      = $total_article + $iva;
                            $orderPdf   .= '</tbody>
                        </table>
                    </div>

                    <p>Favor verificar cantidades y referencias; luego de emitida la orden de compra y factura no aceptamos cambios ni devoluciones de mercancía.</p>
                   
                    <div class="totals-container">
                        <div class="comments">
                            <table>
                                <tr>
                                    <td><b>COMENTARIOS:</b><br>'.$data['order']['comments'].'</td>
                                </tr>
                            </table>
                        </div>
                        <div class="totals">
                            <table>
                                <tr>
                                    <td><b>SUBTOTAL</b></td>
                                    <td>$ ' . number_format($total_article, 2, ',', '.') . '</td>
                                </tr>
                                <tr>
                                    <td><b>IVA</b></td>
                                    <td>$ ' . number_format($iva, 2, ',', '.') . '</td>
                                </tr>
                                <tr>
                                    <td><b>TOTAL</b></td>
                                    <td>$ ' . number_format($total, 2, ',', '.') . '</td>
                                </tr>
                            </table>
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                    <div class="signature">
                        <div class="signature-content">
                            <p style="margin-bottom: 5px;">'.$data['order']['name_employee'].' -- bloqueado</p>
                            <hr style="width: 100%; border-top: 1px solid black; margin: 0;">
                            <p style="margin-top: 5px;"><b>ELABORÓ</b></p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                    <div class="footer">
                        <hr>
                        <div class="footer-content">
                            <span class="left">Pag. 1 de 1</span>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </body>
            </html>';

        return $orderPdf;
    }
}
