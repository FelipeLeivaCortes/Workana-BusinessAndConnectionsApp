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

class BillController
{

    public function ViewBills(){

        return 'OK';
        // $obj        = new CompanyModel();
        // $objUser    = new UserModel();
        // $objCredit  = new CreditLimitModel();
        
        // /**
        //  * Los status son:
        //  *  1 = Active
        //  *  2 = Inactive
        //  */
        // $users      = $objUser->consultUsersWithRol('3');

        // foreach ($users as $u => $value) {
        //     $companies              = $obj->consultCompany($value['c_id']);
        //     $credit                 = $objCredit->ConsultCreditLimitByIdCompany($value['c_id']);
        //     $users[$u]['user']      = $companies;
        //     $users[$u]['credit']    = $credit;
        // }
        
        // include_once "../app/Views/clients/consultClients.php";
    }
}