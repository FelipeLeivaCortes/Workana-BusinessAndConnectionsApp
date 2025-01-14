
<?php
require '../vendor/autoload.php';

use Models\Clients\ClientsModel;
use Models\Types_industry\Types_industryModel;
use Models\User\UserModel;
use Models\Company\CompanyModel;
use Models\CreditLimit\CreditLimitModel;
use Models\Mail\MailModel;
use Models\Messages\MessagesModel;
use Models\Sellers\SellersModel;
use Models\Subscription\SubscriptionModel;
use Models\Template\TemplateModel;
use Models\Customer_payment_method\Customer_payment_methodModel;
use Models\MethodsPay\MethodsPayModel;
use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;
use function Helpers\showAlert;
use function Helpers\showAlertredirect;

class ClientsController
{

    public function addInputsFormAjax()
    {
        $quantityInput = $_POST['quantity'];
        $typeInput = $_POST['typeInput'];

        for ($i = 0; $i < $quantityInput; $i++) {
            echo "<div class='col-md-6' style='border:1px solid #ced4da;'>
                    <div class='form-group'>";

            if ($typeInput === "file") {
                echo "<label ><br></label>";
                echo "<label '>Adjunta el archivo:</label>";
                echo "<input type='file' name='fieldValue[]' class='form-control'>";
            } else {
                echo "Campo: <input class='form-control' placeholder='Escribe el nombre del campo' name='fieldName[]' type='text'>";
                echo "Valor: <input type='text' name='fieldValue[]' class='form-control'>";
            }

            echo "</div>
                  <button type='button' class='mt-2 mb-2 btn btn-danger btn-sm delete-btn'>Eliminar</button>
                </div>";
        }
    }

    public function updateStatusCompanyAndUser()
    {
        $c_id = $_POST['id'];

        include_once '../app/Views/clients/ModalupdateStatusCompanyAndUser.php';
    }
    public function UpdateStatusOfClient()
    {
        $status_company = $_POST['status_company'];
        $c_id = $_POST['c_id'];
        $objCompany = new CompanyModel();
        $objCompany->updateStatusCompany($status_company, $c_id);
        redirect(generateUrl("Company", "Company", "consultCompanies"));
    }

    public function insertExtraAttrsCompany()
    {
        $c_id = $_POST['c_id'];
        $fieldValue = $_POST['fieldValue'];
        $fieldName = $_POST['fieldName'];

        $objCompany = new CompanyModel();

        if ($fieldName !== null) {
            // Inserta los atributos extra
            foreach ($fieldName as $index => $currentFieldName) {
                $currentFieldValue = $fieldValue[$index];
                $objCompany->insertExtraAttribute($c_id, $currentFieldName, $currentFieldValue);
            }
        }

        // Verifica si se han subido archivos
        if (isset($_FILES['fieldValue'])) {
            $uploadedFiles = $_FILES['fieldValue'];

            foreach ($uploadedFiles['tmp_name'] as $index => $uploadedFile) {
                // Verifica si el archivo se subió correctamente
                if ($uploadedFiles['error'][$index] === UPLOAD_ERR_OK) {
                    // Especifica la carpeta donde deseas guardar los archivos
                    $uploadDirectory = 'uploads/companies/company_' . $c_id . '/extra_docs';

                    // Verifica si la carpeta de destino existe; si no, créala
                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }

                    // Mueve el archivo a la carpeta de destino manteniendo el nombre original
                    $destinationPath = $uploadDirectory . '/' . $uploadedFiles['name'][$index];
                    if (move_uploaded_file($uploadedFile, $destinationPath)) {
                        // Inserta la ruta del archivo en la base de datos con el nombre original
                        $objCompany->insertExtraAttribute($c_id, $uploadedFiles['name'][$index], $destinationPath);
                    } else {
                        // Manejo de errores si la subida del archivo falla
                        echo "Error al mover el archivo '{$uploadedFile}' a '{$destinationPath}'.";
                    }
                } else {
                    // Manejo de errores si la subida del archivo falla
                    echo "Error en la subida del archivo '{$uploadedFiles['name'][$index]}'. Código de error: {$uploadedFiles['error'][$index]}.";
                }
            }
        }

        // Redirige después de la inserción y la subida de archivos
        redirect(generateUrl("Company", "Company", "consultCompanies"));
    }


    public function addPaymentMethod()
    {
        // Obtener los datos del formulario
        $c_id = $_POST['c_id'];
        $paymentName = $_POST['newMethod'];

        // Crear instancias de los modelos
        $objPayMethods = new MethodsPayModel();
        $objCompany = new CompanyModel();
        $objCustomerPaymentMethods = new Customer_payment_methodModel();

        // Verificar si el método de pago ya existe
        if (!$objPayMethods->isPaymentMethodExists($paymentName)) {
            // Insertar un nuevo método de pago
            $objPayMethods->InsertPaymentMethods($paymentName);
            // Consultar todos los métodos de pago
            $methodsPay = $objPayMethods->consultMethods();

            // Consultar información de la empresa
            $company = $objCompany->ConsultCompany($c_id);

            // Consultar los métodos de pago de la empresa
            $customerPaymentMethods = $objCustomerPaymentMethods->getPaymentMethodsByCustomerId($c_id);

            // Generar el HTML para los métodos de pago
            $html = '';

            foreach ($methodsPay as $m) {
                $isChecked = false;

                foreach ($customerPaymentMethods as $pm) {
                    if ($pm["payment_method_id"] === $m["payment_method_id"]) {
                        $isChecked = true;
                        break;
                    }
                }

                $html .= "<div class='form-check'>
                        <input type='checkbox' class='form-check-input' id='metodo{$m['payment_method_id']}' name='method_pay[]' value='{$m["payment_method_id"]}'";

                if ($isChecked) {
                    $html .= " checked";
                }

                $html .= ">
                        <label class='form-check-label' for='metodo{$m['payment_method_id']}'>{$m['name']}</label>
                      </div>";
            }

            // Devolver el HTML como respuesta
            echo $html;
        } else {
            echo 'already';
        }
    }





    public function CreateMethodsPayCompanies()
    {
        $c_id = $_POST['id'];
        $objPayMethods = new MethodsPayModel();
        $objCompany = new CompanyModel();
        $objCustomerPaymentMethods = new Customer_payment_methodModel();
        // methods of pay
        $methodsPay = $objPayMethods->consultMethods();

        $company = $objCompany->ConsultCompany($c_id);
        foreach ($company as &$c) {
            $c['payment_methods'] = $objCustomerPaymentMethods->getPaymentMethodsByCustomerId($c['c_id']);
        }

        include_once "../app/Views/clients/methodspayAndCompanies.php";
    }

    public function paymentMethodsCompany()
    {
        $objCustomerPaymentMethods = new Customer_payment_methodModel();

        if (isset($_POST['method_pay']) && is_array($_POST['method_pay']) && count($_POST['method_pay']) > 0) {
            $c_id = $_POST['c_id'];
            $objCustomerPaymentMethods->deletePaymentMethodByCustomerId($c_id);
            $methods = $_POST['method_pay'];
            foreach ($methods as $m) {
                $objCustomerPaymentMethods->insertMethodPayAndCompany($c_id, $m);
            }
        } else {
            echo "<script>alert('Debe seleccionar al menos un método de pago');</script>";
        }
        redirect(generateUrl("Company", "Company", "consultCompanies"));
    }

    public function ModalDocumentsCompany()
    {
        $objCompany = new CompanyModel();
        
        $c_id       = $_POST['c_id'];
        $company    = $objCompany->ConsultCompany($c_id);

        include_once '../app/Views/clients/ModalDocumentsCompany.php';
    }

    public function ViewClientPortal()
    {
        $objUser        = new UserModel();
        $objCompany     = new CompanyModel();
        $objSuscription = new SubscriptionModel();
        
        $users          = $objUser->consultUsersWithRol('2');

        foreach ($users as &$user) {
            $company                = $objCompany->ConsultCompany($user['c_id']);
            $subscription           = $objSuscription->consultPlanSubscription($user['c_id']);
            $user['company']        = $company;
            $user['subscription']   = $subscription;
        }

        include '../app/Views/clients/viewClientPortal.php';
    }

    public function UpdatePlansCompany()
    {
        $c_id = $_POST['c_id'];
        $u_id = $_POST['u_id'];
        $objPlan = new SubscriptionModel();
        $objCompany = new CompanyModel();
        $plan = $objPlan->consultPlanSubscription($c_id);

        $company = $objCompany->ConsultCompany($c_id);

        // Agregar $company al arreglo $plan
        foreach ($plan as $key => $p) {
            $plan[$key]['company'] = $company;
        }
        // dd($plan);
        $user = new UserModel();
        $data = $user->getUserInfoById($u_id);
        include '../app/Views/clients/updateSubscriptionPlans.php';
    }

    public function sendEmailClientsOfClients()
    {
        $Objmessages = new MessagesModel();
        $Messages = $Objmessages->consultMessages();
        include_once '../app/Views/clients/ContMessage.php';
    }

    public function sendEmails() {
        $subject        = $_POST['subject'];
        $messages       = $_POST['message'];
        $addressee      = $_POST['addressee'];
        $addresseeArray = explode(", ", $addressee);
        $mail           = new MailModel();
        
        foreach ($addresseeArray as $a) {
            $template = TemplateModel::TemplateRegistrationLink($a, $messages);
            $mail->DataEmail($template, $a, $subject);
        }

        $Objmessages = new MessagesModel();
        $Objmessages->insertMessage($addressee, date('Y-m-d H:i:s'), $subject, $messages);
        
        redirect(generateUrl("Clients", "Clients", "sendEmailClientsOfClients"));
    }


    public function UpdateStatusCompanyActive()
    {
        $c_id = $_POST['c_id'];
        $u_id = $_POST['u_id'];
        // dd($_POST);
        $objCompany = new CompanyModel();
        $company = $objCompany->ConsultCompany($c_id);
        // dd($company);
        $status_id = $_POST['c_id'];
        include_once '../app/Views/infoCompany/ModalCompanyStatusUser.php';
    }

    public function SellerUpdate()
    {
        $s_id = $_POST['s_id'];
        $s_name = $_POST['s_name'];
        $s_email = $_POST['s_email'];
        $s_phone = $_POST['s_phone'];
        $s_code = $_POST['s_code'];
        $objSeller = new SellersModel();
        $objSeller->updateSeller($s_id, $s_name, $s_email, $s_phone, $s_code);
        redirect(generateUrl("Clients", "Clients", "CreateSellers"));
    }

    public function SellerUpdateModal()
    {
        $s_id = $_POST['id'];
        $objSeller = new SellersModel();
        $seller = $objSeller->ConsultSellerById($s_id);
        include_once '../app/Views/clients/modalSellerUpdate.php';
    }

    public function SalesBudgetModal()
    {
        $s_id = $_POST['id'];
        include_once '../app/Views/clients/modalSalesBudget.php';
    }

    public function ConsultSalesBudgetSeller()
    {
        $seller_id = $_POST['seller_id'];
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];
        $objSalesBudget = new SellersModel();
        $arrayData = $objSalesBudget->ConsultSalesBudgerSeller($seller_id, $date_start, $date_end);

        if (empty($arrayData)) {
            $arrResponse = array('status' => false, 'msg' => 'El venderdor no tiene ventas en ese rango de fechas');
        } else {
            // Variables para almacenar la suma total de total_order y los nuevos datos
            $sumaTotalOrder = 0;
            $newArray = [];
            $porcentajeDecimal = 0;
            $cumplioMeta = "";

            // Iterar sobre los datos
            foreach ($arrayData as $dato) {
                // Calcular el porcentaje como un número decimal
                $porcentajeDecimal += $dato['total_order'] / $dato['b_budget']; 

                // Incrementar la suma total de total_order
                $sumaTotalOrder += $dato['total_order'];

                //Variables de la consulta
                $b_budget = $dato['b_budget'];
                $id_budget_seller = $dato['b_id'];
            }

            // Formatear el porcentaje como una cadena en el formato "0.71"
            $porcentajeFormateado = number_format($porcentajeDecimal * 100, 2) . '%';

             // Determinar si se cumplió la meta de b_budget
             $cumplioMeta = ($sumaTotalOrder >=  $b_budget) ? 'Cumplió' : 'No ha cumplido';

            //Guardar en BBDD el estado de la meta cumplida
            $objSalesBudget->updateStateButdgetSeller($id_budget_seller, $cumplioMeta);

            // Construir el nuevo array para este elemento
            $newArray[] = array(
                'b_budget' =>  '$' . number_format($b_budget, 0, ',', '.') . ' COP',
                'total_order' => '$' . number_format($sumaTotalOrder, 0, ',', '.') . ' COP',
                'porcentaje' => $porcentajeFormateado, // Redondear el porcentaje a 2 decimales
                'b_state' => $cumplioMeta
            );

            $arrResponse = array('status' => true, 'data' => $newArray);
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    public function updatePlan()
    {
        // dd($_POST);
        $date_init = $_POST['date_init'];
        $date_end = $_POST['date_end'];
        $u_email = $_POST['u_email'];
        $template = TemplateModel::SubscriptionUpdatedTemplate($date_end, 'Señor/a Usuario');
        $id_subs = $_POST['id_subs'];
        $obj = new SubscriptionModel();
        $obj->updateSubscription($id_subs, $date_init, $date_end);
        $mail = new MailModel();
        $mail->DataEmail($template, $u_email, 'Actualizacion de suscripcion');
        redirect(generateUrl("Clients", "Clients", "viewClientPortal"));
    }
    public function CreateSellers()
    {
        $objS = new SellersModel();
        $sellers = $objS->ConsultSellers();
        include_once '../app/Views/clients/consultSellersview.php';
    }
    public function CreateSeller()
    {
        include_once '../app/Views/clients/modalSellersview.php';
    }
    public function CreateAsignButgetSeller()
    {
        $objS = new SellersModel();
        $sellers = $objS->ConsultSellers();
        //dd($sellers);
        include_once '../app/Views/clients/modalCreateButgetSeller.php';
    }
    public function insertSeller()
    {
        $objS = new SellersModel();
        $s_name = $_POST['s_name'];
        $s_email = $_POST['s_email'];
        $s_phone = $_POST['s_phone'];
        $s_code = $_POST['s_code'];
        $objS->insertSeller($s_name, $s_email, $s_phone, $s_code);
        redirect(generateUrl("Clients", "Clients", "CreateSellers"));
    }
    public function insertBudgetSeller()
    {
        $objBudgetSeller = new SellersModel();
        $id_seller = $_POST['id_seller'];
        $budgetGoal = $_POST['budgetGoal'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $formattedDateStart = date('Y-m-d H:i:s', strtotime($startDate));
        $formattedDateEnd = date('Y-m-d H:i:s', strtotime($endDate));
        $url_redirect = generateUrl("Clients", "Clients", "CreateSellers");

        //Consultar que el vendedor no tenga un presupuesto ya asignado en el rango de fecha y bloquearlo
        $ConsultIdSeller = $objBudgetSeller->consultSeller($id_seller, $startDate, $endDate);

        if (empty($ConsultIdSeller)) {
            $objBudgetSeller->insertBudgetSeller($id_seller, $budgetGoal, $formattedDateStart, $formattedDateEnd);
            showAlertredirect('Éxito!!!', 'Se creó satisfactoriamente el presupuesto asignado', 'success', $url_redirect);
            return false;
        } else {
            showAlertredirect('Atención!!!', 'El vendedor ya tiene asignado su presupuesto objetivo en el rango de fecha ingresado', 'error', $url_redirect);
            return false;
        }
    }
    public function SellerAndCompanyModal()
    {
        $s_id = $_POST['id'];
        $objS = new SellersModel();
        $companies = $objS->consultCompaniesOfSellerById($s_id);
        $objCompany = new CompanyModel();
        // Obtener el rol y la empresa del usuario
        foreach ($companies as &$company) {
            $rol_id = '3';
            $c_id = $company['c_id'];
            $rolAndCompany = $objCompany->RolAndCompany($c_id, $rol_id);
            $company['rol'] = $rolAndCompany; // Asumiendo que el campo de rol se llama 'rol'
        }

        include_once '../app/Views/clients/modalSellerAndCompany.php';
    }

    public function DeleteSellerOfCompany()
    {
        $objSeller = new SellersModel();
        $s_id = $_GET['s_id'];
        $c_id = $_GET['c_id'];
        $objSeller->DeleteSellerOfCompany($s_id, $c_id);
    }

    public function addCompanyToSeller()
    {
        $objCompany = new CompanyModel();
        $s_id = $_POST['id'];
        $companies = $objCompany->ConsultCompaniesUnselected();
        include_once '../app/Views/clients/modalSelectCompanies.php';
    }
    public function MethodsPayClients()
    {
        $objMethods = new MethodsPayModel();
        $methods = $objMethods->consultMethods();
        include_once '../app/Views/clients/modalmethodsPay.php';
    }

    public function UpdateLimitCredit()
    {

        $c_id = $_POST['c_id'];
        $credit_limit_new = isset($_POST['credit_limit_new']) ? str_replace(',', '', $_POST['credit_limit_new']) : null;
        $objCredit = new CreditLimitModel();

        // Consultar el límite de crédito actual
        $creditLimit = $objCredit->ConsultCreditLimitByIdCompany($c_id);

        if ($creditLimit) {
            // Si el límite de crédito existe, realizar una actualización
            $objCredit->UpdateCreditLimitByIdCompany($c_id, $credit_limit_new);
        } else {
            // Si el límite de crédito no existe, realizar una inserción
            $objCredit->InsertCreditLimitByIdCompany($c_id, $credit_limit_new); // Asume que existe un método InsertCreditLimitByIdCompany para insertar el nuevo límite de crédito
        }

        redirect(generateUrl("Company", "Company", "consultCompanies"));
    }


    public function updateCreditLimitModal()
    {
        $c_id = $_POST['id'];
        $objCompany = new CompanyModel();
        $company = $objCompany->ConsultCompany($c_id);
        $objCredit = new CreditLimitModel();
        foreach ($company as &$c) {
            $c['LimitCredit'] = $objCredit->ConsultCreditLimitByIdCompany($c_id);
        }
        include "../app/Views/clients/consultAndUpdateCreditLimit.php";
    }

    public function RegisterCompaniesOnSeller()
    {
        $selectedCompanyIds = $_POST['selectedCompanyIds'];
        $s_id               = $_POST['s_id'];
        $objCompany         = new CompanyModel();
        $objS               = new SellersModel();

        // $companies = explode(',', $selectedCompanyIds);
        $companies = $objCompany->ConsultAllCompany();

        foreach ($companies as $c) {
            $objCompany->updateSellerCompany($s_id, $c);
        }

        $updatedCompanies = $objS->consultCompaniesOfSellerById($s_id);
        $rows = "";

        foreach ($updatedCompanies as $c) {
            $rows .=  '<tr>
            <td>' . $c['c_name'] . '</td>
            <td>' . $c['u_email'] . '</td>
            <td>' . $c['u_phone'] . '</td>
            <td class="text-center">
            <button class="btn btn-outline-success"><i class="fa-solid fa-eye"></i></button>
            </td>
            </tr>';
        }
        
        echo $rows;
    }
}
