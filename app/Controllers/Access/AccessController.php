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

class AccessController
{

    public function EmailCode() {
        $obj = new AccessModel();
        $sendEmail = new MailModel();
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $userExistence = $obj->userExistence($email, $pass);

        if ($userExistence['success']) {
            $template = TemplateModel::TemplateCode($userExistence['data']['code'], $userExistence['data']['name'] . " " . $userExistence['data']['lastname']);
            $sendEmail->DataEmail($template, $email, 'Código de verificación');
            echo $userExistence['success'];
            
        } else {
            // Aquí puedes mostrar una alerta o realizar otra acción en caso de que success sea false
            echo $message = $userExistence['message'];
            // redirect('index.php');
        }
    }
    

    public function UserAccess(){
        $obj = new AccessModel();
        $objGraphic= new GraphicsModel();

        $u_email = $_POST['u_email'];
        $u_pass = $_POST['u_pass'];
        $u_code = $_POST['u_code'];
        $execute = $obj->ValidationUser($u_email, $u_pass, $u_code);
        
        
        if (!$execute) {
            echo "<script>alert('contraseña, correo electronico y/o codigo de verificación erroneo');</script>";
            redirect('login.php');
        } else {
            $_SESSION['StatusUser'] = $execute['StatusUser'];
            $_SESSION['StatusCompany'] = (isset($_SESSION['StatusCompany'])) ? $execute['StatusCompany'] : '';
            if ($_SESSION['StatusUser'] == 1 || $_SESSION['StatusCompany'] == 1) {
                    $_SESSION['nameUser'] = $execute['nameUser'];      
                    $_SESSION['LastNameUser'] = $execute['LastNameUser'];
                    $_SESSION['CompanyName'] = $execute['CompanyName'];
                    $_SESSION['UserNumDocument'] = $execute['UserNumDocument'];
                    $_SESSION['IdCompany'] = $execute['IdCompany'];
                    $_SESSION['EmailUser'] = $execute['EmailUser'];
                    $_SESSION['PhoneUser'] = $execute['PhoneUser'];
                    $_SESSION['StatusUser'] = $execute['StatusUser'];
                    $_SESSION['CountryUser'] = $execute['CountryUser'];
                    $_SESSION['CityUser'] = $execute['CityUser'];
                    $_SESSION['RolUser'] = $execute['RolUser'];
                    $_SESSION['RolName'] = $execute['RolName'];
                    $_SESSION['idUser'] = $execute['idUser'];
                    $_SESSION['auth'] = true;
                    $_SESSION['welcome'] = false;
                    if ($execute['RolUser']=='3' OR $execute['RolUser']=='4') {
                        $_SESSION['LimitCredit']=$objGraphic->ConsultLimitCredit($execute['IdCompany']);
                        $_SESSION['GraphicsQuotes']=$objGraphic->ConsultQuotes($execute['IdCompany']);
                        $_SESSION['GraphicsOrders']=$objGraphic->ConsultOrders($execute['IdCompany']);
                    }elseif ($execute['RolUser']=='2') {
                        $_SESSION['GraphicsQuotes']=$objGraphic->ConsultQuotesClients();
                        $_SESSION['GraphicsOrders']=$objGraphic->ConsultOrdersClients();
                    }
                    
                    $folderPath = "uploads/UserImg/".$_SESSION['idUser']."/";
                    $defaultImage = "img/default.png";
                    $destination = $folderPath . "default.png";
            
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0755, true);
                        copy($defaultImage, $destination);
                        // Establecer permisos de lectura y escritura para la imagen
                        chmod($destination, 0644);
                    }
            }
            redirect(generateUrl("Access","Access","HomeView"));
        }
    }
    
    public function CompanyRequestRegister(){
      //  dd($_POST);
      // validation
      $objUser= new UserModel();
      $email=$_POST['email'];
      if (!$objUser->checkEmailExists($email)) {
            $company_name   = $_POST['company_name'];
            $company_desc   = $_POST['c_desc'] ?? 0;
            $nit            = str_replace('.', '', $_POST['NIT']);
            $numVerNIT      = $_POST['numVerNIT'];
            $industry       = $_POST['industry'];
            $department     = $_POST['department'];
            $country        = $_POST['country'];
            $city           = $_POST['city'];
            $objCompany     = new CompanyModel();

            $objCompany->RegisterCompaniesClients($company_name,$company_desc,$nit,$numVerNIT,$industry,'2',$country,$department,$city);

            $c_id=$objCompany->getLastId('company','c_id'); //id company updloads
            if (isset($_FILES['rut'], $_FILES['chamber_of_commerce'], $_FILES['representative_cedula'],$_FILES['form_inscription'],$_FILES['certificate_bank'])) {
                $uploadDir = 'uploads/companies/company_' . $c_id . '/';
                
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
                $objCompany->updateCompanyFields($c_id, $filePaths['rut'], $filePaths['chamber_of_commerce'], $filePaths['representative_cedula'], $filePaths['form_inscription'], $filePaths['certificate_bank']);
            }
            
            
            $name=$_POST['representative_name'];
            $lastname=$_POST['representative_lastname'];
            $document=$_POST['representative_document'];
            $type_document=$_POST['representative_document_type'];
            
            $phone= $_POST['phone'];
            error_log("Respuesta servidor:");
            error_log(print_r($phone, true));
            error_log(gettype($phone));
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $objUser->insertUser($email,$password,null,$c_id,3,2,$name,$lastname,$phone,$document,$type_document,$country,$city);
            //   SEND EMAILS OF NOTIFICATION
            //TEMPLATES EMAILS
            $templateUserCompany=TemplateModel::TemplateRegisterCompany($name.' '.$lastname);
            $templateNotificacionPortal=TemplateModel::TemplateNotification($name.' '.$lastname, $company_name );
            //SEND EMAILS
            //SEND EMAIL USER
            $mail= new MailModel();
            $mail->DataEmail($templateUserCompany,$email,'Notificación petición registro');
            //SEND EMAIL COMPANY PORTAL
            //FIND ROL COMPANY = PORTAL ADMIN USER EMAIL
            $email  = $objUser->emailRolCompany();
            $mail->DataEmail($templateNotificacionPortal,$email[0]['u_email'],'Notificación petición registro');

            echo "<script>alert('Ya se envió el registro para ser validado.')</script>";
        }else {
            echo "<script>alert('Este correo ya esta registrado en la base de datos, porfavor utiliza otro.')</script>";
        }   
            
            redirect(generateUrl("Access","Access","UserDestroy"));
    }

    //views
    public function RegisterView(){
        $obj= new Types_industryModel();
        $objTown= new TownModel();
        $deptos=$objTown->consultDeptos();
        $industries=$obj->consultTypes_industry(); 
        include_once '../app/Views/Register/Register.php';
    }

    public function TownsWithDepto(){
        $objTown= new TownModel();
        $depto=$_POST['depto'];
        $town=$objTown->consultTowns($depto);
        $html='<label>Ciudad:</label>
        <div class="form-group">
                     <select class="form-select form-control" name="city">';
        foreach ($town as $t) {
            $html.="<option value='".$t['NOMBRE_MPIO']."'>".$t['NOMBRE_MPIO']."</option>";
        }
        $html.="</select>
        </div>";
        echo $html;
    }
    

    public function HomeView(){
        $objGraphics= new GraphicsModel();
       //ROL CLIENT PORTAL
        if ($_SESSION['RolUser'] == '2' OR $_SESSION['RolUser'] == '1') {
            $_SESSION['GraphicsOrders'] = $objGraphics->ConsultOrdersClients($_SESSION['IdCompany']);
            $_SESSION['GraphicsQuotes'] = $objGraphics->ConsultQuotesClients($_SESSION['IdCompany']);
            echo "<input type='hidden' id='LimitCredit' name='limitCredit' value='0'>";
            // Inicializar el array de contadores
            $quoteCountByMonthYear = [];

            foreach ($_SESSION['GraphicsQuotes'] as $quo) {
                // Obtener el mes y el año de la cotización
                $quoteDate = date_create($quo['quo_date']);
                $year = date_format($quoteDate, 'Y'); // Año
                $month = date_format($quoteDate, 'm'); // Mes
                $monthYearKey = "$year-$month"; // Formato 'YYYY-MM'

                // Incrementar el contador para ese mes y año
                if (isset($quoteCountByMonthYear[$monthYearKey])) {
                    $quoteCountByMonthYear[$monthYearKey]++;
                } else {
                    $quoteCountByMonthYear[$monthYearKey] = 1;
                }
            }

            // Ahora $quoteCountByMonthYear contiene la cantidad de cotizaciones por mes y año
            // Crear un input para cada mes y año
            foreach ($quoteCountByMonthYear as $monthYear => $count) {
                list($year, $month) = explode('-', $monthYear);
                echo "<input type='hidden' class='quote-value' name='GraphicsQuotes[$year][$month]' value='$count'>";
            }


             // Inicializar el array de contadores para órdenes
             $orderCountByMonthYear = [];

             foreach ($_SESSION['GraphicsOrders'] as $order) {
                 // Obtener el mes y el año de la orden
                 $orderDate = date_create($order['order_date']);
                 $year = date_format($orderDate, 'Y'); // Año
                 $month = date_format($orderDate, 'm'); // Mes
                 $monthYearKey = "$year-$month"; // Formato 'YYYY-MM'
 
                 // Incrementar el contador para ese mes y año
                 if (isset($orderCountByMonthYear[$monthYearKey])) {
                     $orderCountByMonthYear[$monthYearKey]++;
                 } else {
                     $orderCountByMonthYear[$monthYearKey] = 1;
                 }
             }
 
             // Crear inputs ocultos para órdenes por mes y año
             foreach ($orderCountByMonthYear as $monthYear => $count) {
                 list($year, $month) = explode('-', $monthYear);
                 echo "<input type='hidden' class='order-value' name='GraphicsOrders[$year][$month]' value='$count'>";
             }
        }

        // ROL ADMIN Y USER
        if ($_SESSION['RolUser'] =='3' OR $_SESSION['RolUser']=='4') {
            $_SESSION['GraphicsOrders']=$objGraphics->ConsultOrders($_SESSION['IdCompany']);
            $_SESSION['GraphicsQuotes']=$objGraphics->ConsultQuotes($_SESSION['IdCompany']);
            $_SESSION['LimitCredit']=$objGraphics->ConsultLimitCredit($_SESSION['IdCompany']);
            if (!empty($_SESSION['LimitCredit'])) {
                // Si hay un límite de crédito asignado, mostrarlo
                echo "<input type='hidden' id='LimitCredit' name='limitCredit' value='".$_SESSION['LimitCredit']['credit_limit']."'>";
            } else {
                // Si no hay un límite de crédito asignado, mostrar un mensaje
                echo "<input type='hidden' id='LimitCredit' name='limitCredit' value='0'>";
            }

           // Inicializar el array de contadores
           $quoteCountByMonthYear = [];

           foreach ($_SESSION['GraphicsQuotes'] as $quo) {
               // Obtener el mes y el año de la cotización
               $quoteDate = date_create($quo['quo_date']);
               $year = date_format($quoteDate, 'Y'); // Año
               $month = date_format($quoteDate, 'm'); // Mes
               $monthYearKey = "$year-$month"; // Formato 'YYYY-MM'

               // Incrementar el contador para ese mes y año
               if (isset($quoteCountByMonthYear[$monthYearKey])) {
                   $quoteCountByMonthYear[$monthYearKey]++;
               } else {
                   $quoteCountByMonthYear[$monthYearKey] = 1;
               }
           }

           // Ahora $quoteCountByMonthYear contiene la cantidad de cotizaciones por mes y año
           // Crear un input para cada mes y año
           foreach ($quoteCountByMonthYear as $monthYear => $count) {
               list($year, $month) = explode('-', $monthYear);
               echo "<input type='hidden' class='quote-value' name='GraphicsQuotes[$year][$month]' value='$count'>";
           }

           // Inicializar el array de contadores para órdenes
            $orderCountByMonthYear = [];

            foreach ($_SESSION['GraphicsOrders'] as $order) {
                // Obtener el mes y el año de la orden
                $orderDate = date_create($order['order_date']);
                $year = date_format($orderDate, 'Y'); // Año
                $month = date_format($orderDate, 'm'); // Mes
                $monthYearKey = "$year-$month"; // Formato 'YYYY-MM'

                // Incrementar el contador para ese mes y año
                if (isset($orderCountByMonthYear[$monthYearKey])) {
                    $orderCountByMonthYear[$monthYearKey]++;
                } else {
                    $orderCountByMonthYear[$monthYearKey] = 1;
                }
            }

            // Crear inputs ocultos para órdenes por mes y año
            foreach ($orderCountByMonthYear as $monthYear => $count) {
                list($year, $month) = explode('-', $monthYear);
                echo "<input type='hidden' class='order-value' name='GraphicsOrders[$year][$month]' value='$count'>";
            }
        }
        include_once '../app/Views/partials/home.php';
    }
    
    public function UserDestroy()
    {
        session_unset();
        session_destroy();
        redirect('login.php');
    }
}

