<?php
require '../vendor/autoload.php';

use Models\Company\CompanyModel;
use Models\Customer_payment_method\Customer_payment_methodModel;
use Models\Template\TemplateModel;
use Models\Mail\MailModel;
use Models\MethodsPay\MethodsPayModel;
use Models\Subcategory\SubcategoryModel;
use Models\Subscription\SubscriptionModel;
use Models\User\UserModel;
use Models\Town\TownModel;
use Models\Types_industry\Types_industryModel;
use Models\CreditLimit\CreditLimitModel;

use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

use ThirdParty\ReflexController;

class CompanyController
{
    public function RegisterUpdateView(){
        $obj= new Types_industryModel();
        $objTown= new TownModel();
        $deptos=$objTown->consultDeptos();
        $industries=$obj->consultTypes_industry(); 
        include '../app/Views/infoCompany/registerUpdateview.php';
    }

    public function updateStatusClientPortal(){
        // dd($_POST);

        $c_id=$_POST['c_id'];
        $u_id=$_POST['u_id'];
        $status_id=$_POST['status_id'];

        $objUser= new UserModel();
        $objCompany= new CompanyModel();
        $mail=new MailModel();

        if ($status_id=='1') {
            $objUser->updateStatusUser($status_id,$u_id);
            $objCompany->updateStatusCompany($status_id,$c_id);
            $user=$objUser->getUserInfoById($u_id);
            $template=TemplateModel::TemplateNotificationActivation($user['u_name'].' '.$user['u_lastname']);
            $mail->DataEmail($template,$user['u_email'],'Notificación de activación!');
        }elseif ($status_id=='2') {
             $objUser->updateStatusUser($status_id,$u_id);
            $objCompany->updateStatusCompany($status_id,$c_id);
            $user=$objUser->getUserInfoById($u_id);
            $template=TemplateModel::TemplateNotificationInactivationUser($user['u_name'].' '.$user['u_lastname']);
            $mail->DataEmail($template,$user['u_email'],'Notificación de Inactivación!');
        }

        redirect(generateUrl("Clients","Clients","ViewClientPortal"));

    }

    public function updateRegisterPreview(){
        // dd($_FILES);
        // Obtener los valores del array $_POST
        $companyName = $_POST['company_name'];
        $NIT = $_POST['NIT'];
        $industry = $_POST['industry'];
        $country = $_POST['country'];
        $department = $_POST['department'];
        $city = $_POST['city'];
        $representativeName = $_POST['representative_name'];
        $representativeLastname = $_POST['representative_lastname'];
        $representativeDocument = $_POST['representative_document'];
        $representativeDocumentType = $_POST['representative_document_type'];
        $phone = $_POST['phone'];
        $cDesc = $_POST['c_desc'];
        $cId = $_POST['c_id'];
        $uId = $_POST['u_id'];
        $objUser= new UserModel();
        $objUser->updateUser($uId,$representativeName,$representativeLastname,$phone,$representativeDocument,$representativeDocumentType,$country,$city);
        $objCompany= new CompanyModel();
        $objCompany->updateCompanyClients($cId,$companyName,$cDesc,$NIT,$industry,2,null,null,null,null,null,$country,$city,$department);
        if (isset($_FILES['rut'], $_FILES['chamber_of_commerce'], $_FILES['representative_cedula'],$_FILES['form_inscription'],$_FILES['certificate_bank'])) {
            $uploadDir = 'uploads/companies/company_' . $cId . '/';

            // Create main directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $filesToUpload = [
                'rut' => $_FILES['rut'],
                'chamber_of_commerce' => $_FILES['chamber_of_commerce'],
                'representative_cedula' => $_FILES['representative_cedula'],
                'form_inscription' => $_FILES['form_inscription'],
                'certificate_bank' => $_FILES['certificate_bank']
            ];

            $filePaths = []; // Array to store the file paths

            foreach ($filesToUpload as $fileKey => $fileData) {
                // Create corresponding folder inside the main directory
                $folderPath = $uploadDir . $fileKey . '/';
                if (!is_dir($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                $filePath = $folderPath . $fileData['name'];

                if (move_uploaded_file($fileData['tmp_name'], $filePath)) {
                    // echo 'File "' . $fileKey . '" uploaded and saved successfully.<br>';

                    $filePaths[$fileKey] = $filePath; // Store the file path
                }
            }


            // Update the fields in the database
            $objCompany->updateCompanyFields($cId, $filePaths['rut'], $filePaths['chamber_of_commerce'], $filePaths['representative_cedula'], $filePaths['form_inscription'], $filePaths['certificate_bank']);
        }
        $template=TemplateModel::TemplateNotificationComplete($representativeName.' '.$representativeLastname,$companyName);
        $templateNotifcationRegister=TemplateModel::TemplateNotificationPendingValidation($representativeName.' '.$representativeLastname);

        $mail= new MailModel();
        $Programmers=$objUser->consultUsersWithRolAndStatus('1','1');

        foreach ($Programmers as $p) {
            $mail->DataEmail($template,$p['u_email'],'Registro completado - Acción requerida por parte del administrador');
        }
            $mail->DataEmail($templateNotifcationRegister,$_SESSION['EmailUser'],'Acción requerida por parte del administrador');
         echo "<script>alert('Se ha registrado exitosamente su empresa, se le enviara un correo de confirmacion cuando sus documentos hayan sido validados.');</script>";   
        redirect(generateUrl("Access","Access","HomeView"));
    }

    public function ViewUserCompany(){
        $user_id=$_POST['id'];
        $obj= new UserModel();
        $user=$obj->getUserInfoById($user_id);
        include_once "../app/Views/infoCompany/usersCompanyEdit.php";
    }

    public function ViewAddressCompany(){
        $obj= new CompanyModel();
        $billingAddress= $obj->ConsultCompany($_SESSION['IdCompany']);
        include_once "../app/Views/infoCompany/addressCompany.php";
    }

    public function consultCompanies(){
        $obj        = new CompanyModel();
        $objUser    = new UserModel();
        $objCredit  = new CreditLimitModel();
        
        /**
         * Los status son:
         *  1 = Active
         *  2 = Inactive
         */
        $users      = $objUser->consultUsersWithRol('3');

        foreach ($users as $u => $value) {
            $companies              = $obj->consultCompany($value['c_id']);
            $credit                 = $objCredit->ConsultCreditLimitByIdCompany($value['c_id']);
            $users[$u]['user']      = $companies;
            $users[$u]['credit']    = $credit;
        }
        
        include_once "../app/Views/clients/consultClients.php";
    }

    public function ViewProfilesUsers(){
        $obj=new CompanyModel();
        $users=$obj->UsersOfCompany($_SESSION['IdCompany'],$_SESSION['RolUser']);
        include_once "../app/Views/infoCompany/infoCompany.php";
    }

    public function updateStatusUserOfCompany(){
        // dd($_POST);
        $u_id=$_POST['u_id'];
        $u_name=$_POST['u_name'];
        $status_id=$_POST['estado'];
        $u_email=$_POST['u_email'];
        if ($status_id=='2') {
            $subject="Notificacion de Inactivacion";
            $template=TemplateModel::TemplateNotificationInactivationUser($u_name);
        }else{
            $subject="Notificacion de Activacion";
            $template=TemplateModel::TemplateNotificationActivationUser($u_name);
        }
        $obj= new UserModel();
        $obj->updateStatusUser($status_id,$u_id);
        $mail= new MailModel();
        $mail->DataEmail($template, $u_email,$subject);
    }

    public function insertUsersCompany(){
        // dd($_POST);
        $obj= new CompanyModel();
        $name=$_POST['u_name'];
        $lastname=$_POST['u_lastname'];
        $phone=$_POST['u_phone'];
        $email=$_POST['u_email'];
        $type_document=$_POST['u_type_document'];
        $u_document=$_POST['u_document'];
        // Generate pass
        $password = bin2hex(random_bytes(5));
        // password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $templateRegisterUser = TemplateModel::TemplateRegister($name." ".$lastname, $email, $password);
        $obj->insertUsersCompany($name, $lastname, $phone, $email,$u_document, $type_document, $hashed_password,$_SESSION['IdCompany'],$_SESSION['RolUser']);
        $objMail= new MailModel();
        $objMail->DataEmail($templateRegisterUser,$email,'Credenciales de Sesión');

        // UPDATE TABLE VIEW 
        $users=$obj->UsersOfCompany($_SESSION['IdCompany'],$_SESSION['RolUser']);
         foreach ($users as $u) {
                echo '<tr>
                        <td>'.$u['u_id'].'</td>
                        <td>'.$u['u_name'].'</td>
                        <td>'.$u['u_email'].'</td>
                        <td>'.$u['c_name'].'</td> 
                        <td>'.$u['rol_name'].'</td> 
                        <td>'.$u['status_name'].'</td> 
                        <td>
                            <div class="col-md-12 justify-content-start d-inline-flex">
                                <button data-id="'.$u['u_id'].'" data-url="'.Helpers\generateUrl("Company","Company","ViewUserCompany",[],"ajax").'" class="btn btn-outline-info editUserProfile"><i class="fa-solid fa-pencil"></i></button>
                                <button data-id="'.$u['u_id'].'" data-url="'.Helpers\generateUrl("Company","Company","viewchangePassword",[],"ajax").'" class="btn btn-outline-warning passwordUser"><i class="fa-solid fa-key"></i></button>
                                <button data-id="'.$u['u_id'].'" data-url="'.Helpers\generateUrl("Company","Company","disableUser",[],"ajax").'" class="btn btn-outline-danger disableUser"><i class="fa-solid fa-ban"></i></button>
                            </div>
                        </td>
                    </tr>';
         }
    }

    public function disableUser(){
        // 1: active status
        // 2: inactive status
        $id=$_POST['id'];
        $Objuser= new UserModel();
        $user= $Objuser->getUserInfoById($id);

        include_once "../app/Views/infoCompany/viewStatusUser.php";
    }

    public function CompanyRequestRegister(){
        $objSubscription    = new SubscriptionModel();
        $date_init          = $_POST['date_init'];
        $date_end           = $_POST['date_end'];

        $objSubscription->insertSubscription($date_init, $date_end);
        $id_subs      = $objSubscription->getLastId('subscription','id_subs');

        $objCompany   = new CompanyModel();
        $objCompany->RegisterCompaniesClients();
        $c_id         = $objCompany->getLastId('company','c_id');

        $objCompany->updateCompanySubscription($c_id, $id_subs);

        $email              = $_POST['email'];
        $characters         = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $passwordGenerate   = substr(str_shuffle($characters), 0, 12);
        $password           = password_hash($passwordGenerate, PASSWORD_BCRYPT);
        
        $objUser            = new UserModel();
        $objUser->insertUser($email, $password, null, $c_id, 2);

        $templateUserCompany    = TemplateModel::TemplateRegister('Señor/a Cliente', $email, $passwordGenerate);
        $mail   = new MailModel();
        $mail->DataEmail($templateUserCompany, $email, '¡Tu suscripción esta a punto de terminar, porfavor llena tus datos como empresa!');
    }

    // USERS OF COMPANIES
    public function UpdateInfoCompany(){
        $c_id           = $_POST['id'];

        $objUser        = new UserModel();
        $objCompany     = new CompanyModel();
        $objIndustry    = new Types_industryModel();
        
        $company        = $objCompany->ConsultCompany($c_id);
        $industries     = $objIndustry->consultTypes_industry();

        foreach ($company as $c => $value) {
            $user = $objUser->getUsersByRoleCompanyAndStatus('2', $value['c_id'], '2');
            $company[$c]['representant'] = $user;
        }

        include_once "../app/Views/clients/updateClients.php";
    }
    
    // USERS OF CLIENTS
    public function UpdateInfoCompanyClients(){
        $c_id=$_POST['id'];
        $objUser = new UserModel();
        $objCompany= new CompanyModel();
        $objIndustry= new Types_industryModel();
        $industries=$objIndustry->consultTypes_industry();
        // dd($industries);
        $company=$objCompany->ConsultCompany($c_id);
        // Clients ADMIN
        foreach ($company as $c => $value) {
            $user = $objUser->getUsersByRoleCompanyAndStatus('3', $value['c_id'], '1');
            $company[$c]['representant'] = $user; // Almacenar los usuarios en la posición correspondiente de la compañía
        }
        // dd($company);
        $extraAttrsCompany=$objCompany->getAttributesByCompanyId($c_id);
        
        include_once "../app/Views/clients/updateClients.php";
    }


    public function UpdateDataCompany() {
        $c_id                   = $_POST['c_id'];
        $c_name                 = $_POST['c_name'];
        $c_desc                 = $_POST['c_desc'];

        /**
         * SE ELIMINAN TODOS LOS PUNTOS QUE PUEDA INCLUIR EL NIT
         */
        $c_num_nit              = str_replace('.', '', $_POST['NIT']);

        $numVerNIT              = $_POST['numVerNIT'];
        $c_street               = $_POST['c_street'];
        $c_apartament           = $_POST['c_apartament'];
        $c_country              = $_POST['c_country'];
        $c_city                 = $_POST['c_city'];
        $c_state                = $_POST['c_state'];
        $c_postal_code          = $_POST['c_postal_code'];
        $c_shippingStreet       = $_POST['c_shippingStreet'];
        $c_shippingApartament   = $_POST['c_shippingApartament'];
        $c_shippingCountry      = $_POST['c_shippingCountry'];
        $c_shippingState        = $_POST['c_shippingState'];
        $c_shippingCity         = $_POST['c_shippingCity'];
        $c_shippingPostalcode   = $_POST['c_shippingPostalcode'];
        $industry               = $_POST['industry'];
        $cardCode               = 'C'.$c_num_nit;

        /**
         * Datos del representante de la empresa
         */
        $representative_name            = $_POST['representative_name'];
        $representative_lastname        = $_POST['representative_lastname'];
        $u_id                           = $_POST['u_id'];
        $representative_document        = $_POST['representative_document'];
        $representative_email           = $_POST['representative_email'];
        $representative_document_type   = $_POST['representative_document_type'];

        $objCompany = new CompanyModel();
        $objCompany->UpdateInfoCompanyRolCompanyAndProgrammer(
            $c_id,
            $c_name,
            $c_desc,
            $c_num_nit,
            $numVerNIT,
            $c_street,
            $c_apartament,
            $c_country,
            $c_city,
            $c_state,
            $c_postal_code,
            $c_shippingStreet,
            $c_shippingApartament,
            $c_shippingCountry,
            $c_shippingState,
            $c_shippingCity,
            $c_shippingPostalcode,
            $industry,
            $cardCode
        );

        $objUser    = new UserModel();
        $objUser->UpdateRepresentantCompanyRolCompanyAndProgrammer(
            $u_id,
            $representative_name,
            $representative_lastname,
            $representative_document,
            $representative_email,
            $representative_document_type
        );
        

        /**
         * ENVIANDO DATOS A LA API REFLEX
         */
        $data = [
            'CardCode'      => $cardCode,
            'CardName'      => $c_name,
            'CardType'      => 'C',
            'EmailAddress'  => $representative_email,
            'FederalTaxID'  => $c_num_nit.'-'.$numVerNIT
            // 'U_ACS_PCID'    => null
        ];

        $encodedData = json_encode($data);

        $reflex = new ReflexController();
        $reflex->updateClient($encodedData);
        
        redirect(generateUrl("Company", "Company", "consultCompanies"));
    }


    public function updateAddressShippingToAddressBilling() {
        $obj = new CompanyModel();
        $obj->updateAddressShippingToAddressBilling($_SESSION['IdCompany']);
        $shippingAddresses = $obj->ConsultCompany($_SESSION['IdCompany']);
        // Imprimir formulario de dirección de facturación para cada dirección existente
        foreach ($shippingAddresses as $key) {
            echo '
            <!-- start -->
            <form class="slide-in-top" action="' . Helpers\generateUrl("Company", "Company", "updateAddressShipping", [], "ajax") . '" method="POST">
                <div class="mb-3">
                    <label for="billing-address1" class="form-label">Calle y número</label>
                    <input type="text" name="streetShipping" value="' . $key['c_shippingStreet'] . '" class="form-control addressShipping" id="billing-address1">
                </div>
                <div class="mb-3">
                    <label for="billing-address2" class="form-label">Apartamento</label>
                    <input type="text" name="apartamentShipping" class="form-control addressShipping" value="' . $key['c_shippingApartament'] . '" id="billing-address2">
                </div>
                <div class="mb-3">
                    <label for="billing-city" class="form-label">País</label>
                    <input type="text" name="countryShipping" value="' . $key['c_shippingCountry'] . '" class="form-control addressShipping" id="billing-city">
                </div>
                <div class="mb-3">
                    <label for="billing-city" class="form-label">Ciudad</label>
                    <input type="text" name="cityShipping" class="form-control addressShipping" value="' . $key['c_shippingCity'] . '" id="billing-city">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="billing-state" class="form-label">Estado/Provincia/Región/Departamento</label>
                        <input type="text" name="stateShipping" class="form-control addressShipping" value="' . $key['c_shippingState'] . '" id="billing-state">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="billing-zip" class="form-label">Código postal</label>
                        <input type="text" name="postalcodeShipping" class="form-control addressShipping" value="' . $key['c_shippingPostalcode'] . '" id="billing-zip">
                    </div>
                </div>
            </form>';
        }
    }
    

    public function viewchangePassword(){
        $u_id=$_POST['id'];
        include_once '../app/Views/infoCompany/changePasswordUserCompany.php';

    }

    public function UpdatePasswordUser(){
        $new_password = $_POST['new-password'];
        $confirm_password = $_POST['confirm-password'];
        $user_id = $_POST['u_id'];
        // var_dump($user_id);
        if ($new_password === $confirm_password) {
            $user= new UserModel();
            $infoUser=$user->getUserInfoById($user_id);
            $template=TemplateModel::TemplateChangePassword($infoUser['u_name']. " ".$infoUser['u_lastname'],$new_password);
            $mail= new MailModel();
            $mail->DataEmail($template,$infoUser['u_email'],'Nueva contraseña');
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Genera el hash de la nueva contraseña
            $obj = new CompanyModel();
            $obj->updatePasswordUser($user_id, $hashed_password);
            echo 'Contraseña  actualizada correctamente';
        } else {
            echo 'Las contraseñas no coinciden.';
        }
    }

    public function updateAddressBilling(){
        $obj= new CompanyModel();
        $street= $_POST['street'];
        $apartament= $_POST['apartament'];
        $country= $_POST['country'];
        $city= $_POST['city'];
        $state= $_POST['state'];
        $postalcode= $_POST['postalcode'];
        $obj->updateAddressBilling( $street,$apartament,$country,$city,$state,$postalcode,$_SESSION['IdCompany']);
    }

    public function updateAddressShipping(){
        $obj= new CompanyModel();
        $street= $_POST['streetShipping'];
        $apartament= $_POST['apartamentShipping'];
        $country= $_POST['countryShipping'];
        $city= $_POST['cityShipping'];
        $state= $_POST['stateShipping'];
        $postalcode= $_POST['postalcodeShipping'];
        $obj->updateAddressShipping($street,$apartament,$country,$city,$state,$postalcode,$_SESSION['IdCompany']);

    }

    public function updateInfoUser(){
        $obj= new CompanyModel();
        $user_id=$_POST['id'];
        $name=$_POST['name'];
        $lastname=$_POST['lastname'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $type_document=$_POST['type_document'];
        $num_document=$_POST['num_document'];
        $obj->updateUserInfoById($user_id,$name,$lastname,$phone,$email,$type_document,$num_document,$_SESSION['IdCompany']);
    }
}

?>