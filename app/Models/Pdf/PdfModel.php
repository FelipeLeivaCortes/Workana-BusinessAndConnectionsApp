<?php

namespace Models\Pdf;

require '../vendor/autoload.php';
use Models\MasterModel;

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
    

    public static function templateQuotePdf(array $articleArray,array $fieldName= NULL,array $fieldValue= NULL, $quoDiscountTotal, $quoAdditionCost){
        // VARS CONST GLOBAL
        require_once '../config/global.php';
        $quotePdf='<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Cotización</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    padding: 5px;
                    border: 1px solid #ccc;
                    text-align: left;
                }
                th {
                    background-color: #eee;
                }
                h1 {
                    font-size: 24px;
                    margin-top: 0;
                    margin-bottom: 20px;
                }
                .header {
                 
                    text-align: left;
                    margin-bottom: 20px;
                }
                .header img {
                    height: 80px;
                    width: 80px;
                    left:0;
                }
                .contact-info {
                    margin-bottom: 20px;
                }
                .contact-info p {
                    margin: 0;
                }
                .footer {
                    text-align: right;
                    font-size: 10px;
                    margin-top: 20px;
                }

            </style>
        </head>
        <body>
        
            <div class="header">
                <img src="'.LOGOBLACK.'">
                <p>'.TITLE_PAGE.'</p>
                <p>'.SMTP_USERNAME.'</p>
                <p>Teléfono de ejemplo</p>
                <p>Correo electrónico de ejemplo</p>
            </div>
        
            <h1>Cotización</h1>
        
            <div class="contact-info">
                <p>Cliente: <b>'.$_SESSION['CompanyName'].'</b></p>
                <p>Nombre del cliente: <b>'.$_SESSION['nameUser'].' '.$_SESSION['nameUser'].' </b></p>
                <p>Dirección del cliente : <b> '.$_SESSION['CompanyName'].'</b></p>
                <p>Teléfono del cliente: <b> '.$_SESSION['PhoneUser'].'</b></p>
                <p>Correo electrónico del cliente:<b> '.$_SESSION['EmailUser'].'</b></p>';
                if($fieldName<>NULL OR $fieldValue<>NULL ){
                for ($i=0; $i <count($fieldName) ; $i++) { 
                    $quotePdf.='<p>'.$fieldName[$i].':<b>'.$fieldValue[$i].'</b></p>';
                }
            }
                $quotePdf.='
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Descuento</th>
                        <th>Precio tras el descuento</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
                $TotalArticle = 0;
                $total=0;
                foreach ($articleArray as $articles) {
                    $article = $articles[0];//accedo al primera posicion info articulo
                    $quantity =$articles['quantity']; // acceder a la cantidad
                    $price =$articles['price']; // acceder a al precio 
                    $subtotalArticle = $quantity * $price;  
                    $TotalArticle+=$subtotalArticle; 
                    $TotalArticle_formatted = number_format($TotalArticle, 2, '.', ',');
                    $quotePdf .= 
                        "<tr>
                            <td>".$article['ar_id']."</td>
                            <td>".$article['ar_name']."</td>
                            <td>".$article['ar_desc']."</td>           
                            <td>".$quantity."</td>       
                            <td>$ ".$articles['pricePre']."</td>                            
                            <td> ".$articles['discountPercentajeOrPrice']."</td>                            
                            <td>$ ".$price."</td>                            
                            <td>$".$subtotalArticle."</td>                            
                        </tr>"; 
                        
                }
                $iva=$TotalArticle* 0.19;
                $total += $TotalArticle+$iva+$quoAdditionCost;    
                $total_formatted = number_format($total, 2, '.', ',');
                $iva_formatted = number_format($iva, 2, '.', ',');
                $total_discount_formatted = number_format($quoDiscountTotal, 2, '.', ',');
                $addition_cost_formatted = number_format($quoAdditionCost, 2, '.', ',');

                // TOTAL,SUBTOTAL,TAXES
                $quotePdf.='</tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;">Subtotal:</td>
                        <td>$'.  $TotalArticle_formatted .'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Descuento Total:</td>
                        <td>$'.  $total_discount_formatted .'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Impuestos:</td>
                        <td>$'. $iva_formatted.'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Gastos Adicionales:</td>
                        <td>$'.  $addition_cost_formatted . '</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Total:</td>
                        <td>$'.  $total_formatted . '</td>
                    </tr>
                </tfoot>
            </table>    
            <div class="footer">
                <p>Gracias por su cotizacion.</p>
            </div>
        </body>
        </html>';
        return $quotePdf;
    }


    public static function templateOrderPdf(array $articleArray,array $fieldName= NULL,array $fieldValue= NULL, $orderDiscountTotal, $orderAdditionCost){
        // VARS CONST GLOBAL
        require_once '../config/global.php';     
            
        $orderPdf='<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Cotización</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    padding: 5px;
                    border: 1px solid #ccc;
                    text-align: left;
                }
                th {
                    background-color: #eee;
                }
                h1 {
                    font-size: 24px;
                    margin-top: 0;
                    margin-bottom: 20px;
                }
                .header {
                 
                    text-align: left;
                    margin-bottom: 20px;
                }
                .header img {
                    height: 80px;
                    width: 80px;
                    left:0;
                }
                .contact-info {
                    margin-bottom: 20px;
                }
                .contact-info p {
                    margin: 0;
                }
                .footer {
                    text-align: right;
                    font-size: 10px;
                    margin-top: 20px;
                }

            </style>
        </head>
        <body>
        
            <div class="header">
                <img src="'.LOGOBLACK.'">
                <p>'.TITLE_PAGE.'</p>
                <p>'.SMTP_USERNAME.'</p>
                <p>Teléfono de ejemplo</p>
                <p>Correo electrónico de ejemplo</p>
            </div>
        
            <h1>Pedido</h1>
        
            <div class="contact-info">
                <p>Cliente: <b>'.$_SESSION['CompanyName'].'</b></p>
                <p>Nombre del cliente: <b>'.$_SESSION['nameUser'].' '.$_SESSION['nameUser'].' </b></p>
                <p>Dirección del cliente : <b> '.$_SESSION['CompanyName'].'</b></p>
                <p>Teléfono del cliente: <b> '.$_SESSION['PhoneUser'].'</b></p>
                <p>Correo electrónico del cliente:<b> '.$_SESSION['EmailUser'].'</b></p>';
                if($fieldName<>NULL OR $fieldValue<>NULL ){
                for ($i=0; $i <count($fieldName) ; $i++) { 
                    $orderPdf.='<p>'.$fieldName[$i].':<b>'.$fieldValue[$i].'</b></p>';
                }
            }
                $orderPdf.='
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Descuento</th>
                        <th>Precio tras el descuento</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
                $TotalArticle = 0;
                $total=0;
                foreach ($articleArray as $articles) {
                    $article    = $articles[0];
                    $quantity   = $articles['quantity'];
                    $price      = $articles['price'];
                    $subtotalArticle = $quantity * $price;
                    $TotalArticle+=$subtotalArticle; 
                    $TotalArticle_formatted = number_format($TotalArticle, 2, '.', ',');
                    $orderPdf .= 
                        "<tr>
                            <td>".$article['ar_id']."</td>
                            <td>".$article['ar_name']."</td>
                            <td>".$article['ar_desc']."</td>           
                            <td>".$quantity."</td>       
                            <td>$ ".$articles['pricePre']."</td>                            
                            <td> ".$articles['discountPercentajeOrPrice']."</td>                            
                            <td>$ ".$price."</td>                            
                            <td>$".$subtotalArticle."</td>                            
                        </tr>"; 
                        
                }
                $iva=$TotalArticle* 0.19;
                $total += $TotalArticle+$iva+$orderAdditionCost;    
                $total_formatted = number_format($total, 2, '.', ',');
                $iva_formatted = number_format($iva, 2, '.', ',');               
                $total_discount_formatted = number_format($orderDiscountTotal, 2, '.', ',');
                $addition_cost_formatted = number_format($orderAdditionCost, 2, '.', ',');

                // TOTAL,SUBTOTAL,TAXES
                $orderPdf.='</tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;">Subtotal:</td>
                        <td>$'.  $TotalArticle_formatted .'</td>
                    </tr> 
                    <tr>
                        <td colspan="3" style="text-align: right;">Descuento Total:</td>
                        <td>$'.  $total_discount_formatted .'</td>
                    </tr>                   
                    <tr>
                        <td colspan="3" style="text-align: right;">Impuestos:</td>
                        <td>$'. $iva_formatted.'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Gastos Adicionales:</td>
                        <td>$'.  $addition_cost_formatted . '</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Total:</td>
                        <td>$'.  $total_formatted . '</td>
                    </tr>
                </tfoot>
            </table>    
            <div class="footer">
                <p>Gracias por su pedido.</p>
            </div>
        </body>
        </html>';
        return $orderPdf;
    }
} 


?>