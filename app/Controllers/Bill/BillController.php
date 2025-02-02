<?php
date_default_timezone_set('America/Bogota');

require '../vendor/autoload.php';

use Models\Access\AccessModel;
use Models\Mail\MailModel;
use Models\Template\TemplateModel;
use Models\Types_industry\Types_industryModel;
use Models\User\UserModel;
use Models\Company\CompanyModel;
use Models\Graphics\GraphicsModel;
use Models\Quote\QuoteModel;
use Models\Town\TownModel;

use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

use ThirdParty\ReflexController;

class BillController
{
    public function viewBills() {
        try {
            if (is_null($_SESSION['IdCompany']) || $_SESSION['IdCompany'] == '') {
                throw new \Exception('No se ha encontrado el Company ID');
            
            } else {
                $company_model  = new CompanyModel();
                $company        = $company_model->ConsultCompany($_SESSION['IdCompany']);
                $nitCompany     = str_replace('.', '', $company[0]['c_num_nit']);
                $cardCode       = str_replace('-', '', $nitCompany);
                
                $data   = [
                    'CardCode'      => 'C'.$cardCode,
                    'FechaInicial'  => '20250101',
                    'FechaFinal'    => '20250130',
                ];
                // $data   = [
                //     'CardCode'      => 'C890903471',
                //     'FechaInicial'  => '20250101',
                //     'FechaFinal'    => '20250130',
                // ];
                $encodedData    = json_encode($data);
    
                $reflex         = new ReflexController();
                $encoded_bills  = $reflex->getBills($encodedData);
                $string_decoded = base64_decode($encoded_bills['resultadoData']);
                $bills          = json_decode($string_decoded);

                include_once "../app/Views/bill/index.php";

            }
        
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function viewDetaillBill() {
        return 'EN DESARROLLO';
    }
}