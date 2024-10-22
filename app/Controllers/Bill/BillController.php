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

    public function viewBills() {

        $bills  = [
            [
                'id'        => 101,
                'date'      => date('Y-m-d H:i:s'),
                'client'    => 'Cliente',
                'amount'    => 1000,
                'url_doc'   => 'document_url'
            ]
        ];

        include_once "../app/Views/bill/index.php";
    }

    public function viewDetaillBill() {
        return 'EN DESARROLLO';
    }
}