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
                $company_model      = new CompanyModel();
                $company_initial    = $company_model->ConsultCompany($_SESSION['IdCompany']);

                /**
                 * Entra si es SuperAdmin o Admin.
                 */
                if ($_SESSION['RolUser'] == 1 || $_SESSION['RolUser'] == 2) {
                    $companies  = $company_model->ConsultAllCompany();
                } else {
                    $companies  = $company_initial;
                }

                $reflex = new ReflexController();
                $bills  = [];

                foreach ($companies as $company) {
                    $nitCompany = isset($company['c_num_nit']) ? str_replace('.', '', $company['c_num_nit']) : '';

                    if (strpos($nitCompany, '-') !== false) {
                        $cardCode   = explode('-', $nitCompany)[0];
                    } else {
                        $cardCode   = $nitCompany;
                    }
                    
                    $data   = [
                        'CardCode'      => 'C'.$cardCode,
                        'FechaInicial'  => '20150101',
                        'FechaFinal'    => '20251231',
                    ];

                    $payload        = json_encode($data);
                    $encoded_bills  = $reflex->getBills($payload);

                    if (isset($encoded_bills['resultadoData'])) {
                        $string_decoded = base64_decode($encoded_bills['resultadoData']);
                        $decoded_bills  = json_decode($string_decoded);
    
                        if (is_array($decoded_bills)) {
                            $bills = array_merge($bills, $decoded_bills);
                        }
                    }
                }

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