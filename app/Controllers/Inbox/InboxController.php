<?php
require '../vendor/autoload.php';

use Models\Company\CompanyModel;
use Models\Inbox\InboxModel;
use Models\Mail\MailModel;
use Models\Template\TemplateModel;
use Models\Types_industry\Types_industryModel;
use Models\User\UserModel;
use Models\Customer_payment_method\Customer_payment_methodModel;
use Models\CreditLimit\CreditLimitModel;
use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;

use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;
use function Helpers\showAlert;

use ThirdParty\ReflexController;

class InboxController
{

    public function viewInbox()
    {
        $objUser = new UserModel();
        $objCompany = new CompanyModel();
        // status inactive  
        $companies = $objCompany->selectById('company', 'status_id', 2);
        // status inactive  
        foreach ($companies as $c => $value) {
            $users = $objUser->getUsersByRoleCompanyAndStatus('3', $value['c_id'], '2');
            $companies[$c]['representant'] = $users; // Almacenar los usuarios en la posición correspondiente de la compañía
        }

        //status pending
        $companiesPendig = $objCompany->selectById('company', 'status_id', 3);
        //status pending
        foreach ($companiesPendig as $key => $value) {
            $users = $objUser->getUsersByRoleCompanyAndStatus('3', $value['c_id'], '3');
            $companiesPendig[$key]['representant'] = $users; // Almacenar los usuarios en la posición correspondiente de la compañía
        }

        include_once '../app/Views/inbox/viewInboxClients.php';
    }

    public function viewRequestRegister()
    {
        $id_company = $_POST['id'];
        $objCompany = new CompanyModel();
        $objUser = new UserModel();
        $objIndustry = new Types_industryModel();

        $company = $objCompany->consultCompany($id_company);
        foreach ($company as $c => $value) {
            $user = $objUser->getUsersByRoleCompanyAndStatus('3', $value['c_id'], '2');
            $company[$c]['representant'] = $user; // Almacenar los usuarios en la posición correspondiente de la compañía
            $company[$c]['Industry'] = $objIndustry->consultTypes_industryById($value['tpi_id']);
        }
        // dd($company);  
        include_once '../app/Views/inbox/modalViewRequest.php';
    }

    public function processRegistrationRequest()
    {
        $c_id = $_POST['c_id'];
        $u_id = $_POST['u_id'];
        $rejectOrAccept = $_POST['rejectOrAccept'];

        if ($rejectOrAccept == 'accept') {
            /*  lógica para bloquear con mensaje si un cliente todavía no tiene cupo de crédito, 
            vendedor quien lo atienda y forma de pago */

            //Validar si el cliente tiene creado cupo de crédito limite
            $objCompanyCreditLimit = new CreditLimitModel;
            $companyCreditLimit = $objCompanyCreditLimit->ConsultCreditLimitByIdCompany($c_id);
           
            //Validar si el cliente tiene vendedor asignado
            $objCompanySellerAsign = new CompanyModel();
            $companySellerAsign = $objCompanySellerAsign->getCompanySellerAsignId($c_id) ;            

            // Validar si el cliente tiene ya tipo de pago
            $objCustomerPaymentMethod = new Customer_payment_methodModel;
            $companyAddPaymentMethod = $objCustomerPaymentMethod->getPaymentMethodsByCustomerId($c_id);


            if (empty($companyCreditLimit) || empty($companySellerAsign) || empty($companyAddPaymentMethod)) {
                echo '<script>alert("La compañia no tiene ningún cupo asignado o vendedor o método de pago, Llenarlos por favor!!");</script>';
                redirect(generateUrl("Inbox", "Inbox", "viewInbox"));
                return false;
            }else {
                $objCompany = new CompanyModel();
                $objCompany->updateStatusCompany('1', $c_id);

                $objUser    = new UserModel();
                $objUser->updateStatusUser('1', $u_id);
                
                $mail       = new MailModel();
                $user       = $objUser->getUserInfoById($u_id);
                
                $template   = TemplateModel::TemplateRegister($user['u_name'] . ' ' . $user['u_lastname'], $user['u_email'], 'Utilizada en el registro');
                $mail->DataEmail($template, $user['u_email'], 'Notificacion de registro');


                $companyData = $objCompany->ConsultCompany($c_id);

                /**
                 * INTEGRACIÓN COMUNICACIÓN API REFLEX
                 */
                $data = [
                    'CardCode'      => 'C'.$companyData[0]['c_num_nit'],
                    'CardName'      => $companyData[0]['c_name'],
                    'CardType'      => 'C',
                    'EmailAddress'  => $user['u_email'],
                    'FederalTaxID'  => $companyData[0]['c_num_nit'] . '-' . $companyData[0]['c_num_ver_nit'],
                    'U_ACS_PCID'    => $c_id
                ];

                $encodedData = json_encode($data);

                $reflex = new ReflexController();
                $reflex->createClient($encodedData);
            }

        } elseif ($rejectOrAccept == 'reject') {
            $objUser = new UserModel();
            $user = $objUser->getUserInfoById($u_id);
            $template = TemplateModel::TemplateRejectRegistration($user['u_name'] . ' ' . $user['u_lastname'], 'Lo sentimos, pero no hemos podido procesar su solicitud de registro debido a que Los documentos proporcionados no están completos o contienen información errónea.');
            $objUser->deleteUser($u_id);
            $objCompany = new CompanyModel();
            $objCompany->deleteCompany($c_id);
            $mail = new MailModel();
            $mail->DataEmail($template, $user['u_email'], 'Notificacion de registro');
        }

        redirect(generateUrl("Inbox", "Inbox", "viewInbox"));
    }
    
}
