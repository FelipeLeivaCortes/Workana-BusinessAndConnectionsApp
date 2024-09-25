<?php
require '../vendor/autoload.php';

use Models\Articles\ArticlesModel;
use Models\Category\CategoryModel;
use Models\Company\CompanyModel;
use Models\Excel\ExcelModel;
use Models\Data\DataModel;
use Models\Mail\MailModel;
use Models\Prices\PricesModel;
use Models\Stock\StockModel;
use Models\Subcategory\SubcategoryModel;
use Models\Template\TemplateModel;
use Models\User\UserModel;
use Models\Warehouse\WarehouseModel;
use function Helpers\dd;
use function Helpers\showAlertredirect;
use function Helpers\generateUrl;
use function Helpers\redirect;

class DataController
{

    public function ImportView()
    {

        include_once '../app/Views/data/viewImport.php';
    }
    public function ExportView()
    {

        include_once '../app/Views/data/viewExport.php';
    }
    public function ImportArticlesExe()
    {
        // article
        $objArticle = new ArticlesModel();
        // data
        $objData = new DataModel();
        // stock
        $objStock = new StockModel();
        // price
        $objPrice = new PricesModel();
        //warehouse
        $objWh = new WarehouseModel();
        //category
        $objCat = new CategoryModel();
        //subcategory
        $objSb = new SubcategoryModel();


        $excelModel = new ExcelModel();

        if (isset($_FILES['excel_file'])) {
            // Ruta temporal del archivo subido
            $excelFileTmpPath = $_FILES['excel_file']['tmp_name'];
            // Obtener los datos del archivo Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            // Eliminar la primera fila (encabezados de columna)
            array_shift($data);
            // Iterar sobre los datos y realizar la inserción en la base de datos
            // dd($data);
            foreach ($data as $row) {
                // dd($row);
                // Convertir todos los elementos del array a mayúsculas
                $row = array_map(function ($value) {
                    return $value !== null ? strtoupper($value) : null;
                }, $row);
                // Verificar si al menos un valor en el array no está vacío
                if (!empty(array_filter($row))) {
                    $lastIdArticle = $objData->getLastId("articles", "ar_id");
                    $lastIdArticle++;


                    // consult category exists
                    $category = $objCat->consultCategoryForName($row['9']);

                    // INSERT CATEGORY if it doesn't exist
                    if (empty($category)) {
                        $objCat->InsertCategory($row['9']);
                        $lastInsertCategory = $objData->getLastId("category", "cat_id");
                    } else {
                        $lastInsertCategory = $category[0]['cat_id'];
                    }

                    // consult subcategory exists
                    $Subcategory = $objSb->consultSubcategoryForName($row['10']);

                    if (empty($Subcategory)) {
                        // INSERT SUBCATEGORY
                        $objSb->insertSubcategroy($row['10'], null, $lastInsertCategory);
                        $lastInsertSubcategory = $objData->getLastId("subcategory", "sbcat_id");
                    } else {
                        $lastInsertSubcategory = $Subcategory[0]['sbcat_id'];
                    }

                    $objArticle->insertArticle($lastIdArticle, $row[2], $row[1], $row[0], $row[3], $row[8], $row[4], $row[5], $row[6], $row[7], $lastInsertCategory, $lastInsertSubcategory, $row[11]);
                    $warehouse = $objWh->consultWarehouseWithCode($row['16']);

                    if (!empty($warehouse)) {
                        foreach ($warehouse as $wh) {
                            $objStock->insertStock($row[12], $row[13], $row[14], $row[15], $lastIdArticle, $wh['wh_id']);
                            $objPrice->insertPrice($lastIdArticle, $wh['wh_id'], $row[17]);
                        }
                    } else {
                        $objWh->insertWarehouse(null, null, $row['16'], null, null, null, null, null, $_SESSION['IdCompany']);
                        $wh_id = $objWh->getLastId('warehouse', 'wh_id');
                        $objStock->insertStock($row[12], $row[13], $row[14], $row[15], $lastIdArticle, $wh_id);
                        $objPrice->insertPrice($lastIdArticle, $wh_id, $row[17]);
                    }
                } else {
                    // Detener el bucle cuando todos los elementos del array están vacíos
                    break;
                }
            }
            echo '<script>alert("Los datos se han importado exitosamente.");</script>';
        } else {
            echo '<script>alert("No se ha seleccionado ningún archivo.");</script>';
        }

        redirect(generateUrl("Stock", "Stock", "ViewCreateStock"));
    }

    public function ImportClientsExe()
    {

        if (isset($_FILES['excel_file'])) {
            // Ruta temporal del archivo subido
            $excelFileTmpPath = $_FILES['excel_file']['tmp_name'];
            // Obtener los datos del archivo Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            // Eliminar la primera fila (encabezados de columna)
            array_shift($data);
            // Iterar sobre los datos y realizar la inserción en la base de datos
            // dd($data);

            // company
            $objCompany = new CompanyModel();
            // user
            $objUser = new UserModel();
            //email
            $mail = new MailModel();

            foreach ($data as $row) {
                if (!empty(array_filter($row))) {
                    // Convertir todos los elementos del array a mayúsculas
                    $row = array_map(function ($value) {
                        return $value !== null ? strtoupper($value) : null;
                    }, $row);

                    $objCompany->RegisterCompaniesClients($row[0], $row[1], $row[2], $row[3], '3', $row[4], $row[5], $row[6]);
                    $lastIdCompany = $objCompany->getLastId('company', 'c_id');
                    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $passwordGenerate = substr(str_shuffle($characters), 0, 12);
                    $password = password_hash($passwordGenerate, PASSWORD_BCRYPT);

                    $objUser->insertUser($row[10], $password, null, $lastIdCompany, 3, 3, $row[7], $row[8], $row[9], $row[12], $row[11], $row[4], $row[6]);

                    $templateEmail = TemplateModel::TemplateNotificationDocumentRequest($row[7], $row[10], $passwordGenerate);
                    $mail->DataEmail($templateEmail, $row[10], 'REGISTRO PORTAL CLIENTES');
                } else {
                    // Detener el bucle cuando todos los elementos del array están vacíos
                    break;
                }
            }
            echo '<script>alert("Los datos se han importado exitosamente.");</script>';
        } else {
            echo '<script>alert("No se ha seleccionado ningún archivo.");</script>';
        }
        redirect(generateUrl("Company", "Company", "consultCompanies"));
    }


    public function ExportArticlesExe()
    {
        $url_redirect = generateUrl("Data", "Data", "ExportView");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

            try {

                $export = new ArticlesModel();
                $excel = new ExcelModel();
                $dataExport = $export->consultAllArticles();
                //dd($dataExport);exit;

                $filename = 'Exportar_Artículos';
                $filePath = $excel->genereateExcelExportArticles($dataExport, $filename, 'uploads/exports/Exportar_Artículos.xlsx');

                // Limpiar el búfer de salida
                ob_clean();

                // Establecer encabezados para indicar que es un archivo de Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $filename . '.xlsx' . '"');
                header('Content-Length: ' . filesize($filePath));

                // Leer y mostrar el archivo
                readfile($filePath);

                // Salir para evitar cualquier salida adicional
                exit;
            } catch (Exception $e) {
                // Manejar errores de PhpSpreadsheet
                showAlertredirect('Atención!!!', 'Se ha producido un error', 'error', $url_redirect);
                error_log("error");
                error_log(print_r($e->getMessage(), true));
                return false;
            }
        } else {
            // Manejar errores de PhpSpreadsheet
            showAlertredirect('Atención!!!', 'Datos vacíos, reporte al administrador del sitio', 'error', $url_redirect);
            return false;
        }
    }

    public function ExportClientsExe()
    {
        $url_redirect = generateUrl("Data", "Data", "ExportView");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

            try {

                $export = new CompanyModel();
                $excel = new ExcelModel();
                $dataExport = $export->consultAllClients();
                //dd($dataExport);exit;

                $filename = 'Exportar_Clientes';
                $filePath = $excel->genereateExcelExportClients($dataExport, $filename, 'uploads/exports/Exportar_Clientes.xlsx');

                // Limpiar el búfer de salida
                ob_clean();

                // Establecer encabezados para indicar que es un archivo de Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $filename . '.xlsx' . '"');
                header('Content-Length: ' . filesize($filePath));

                // Leer y mostrar el archivo
                readfile($filePath);

                // Salir para evitar cualquier salida adicional
                exit;
            } catch (Exception $e) {
                // Manejar errores de PhpSpreadsheet
                showAlertredirect('Atención!!!', 'Se ha producido un error', 'error', $url_redirect);
                error_log("error");
                error_log(print_r($e->getMessage(), true));
                return false;
            }
        } else {
            // Manejar errores de PhpSpreadsheet
            showAlertredirect('Atención!!!', 'Datos vacíos, reporte al administrador del sitio', 'error', $url_redirect);
            return false;
        }
    }
}
