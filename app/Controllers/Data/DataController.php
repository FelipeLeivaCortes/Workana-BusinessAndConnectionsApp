<?php
require '../vendor/autoload.php';

use Models\Articles\ArticlesModel;
use Models\Category\CategoryModel;
use Models\Colors\ColorsModel;
use Models\Company\CompanyModel;
use Models\Excel\ExcelModel;
use Models\Data\DataModel;
use Models\Mail\MailModel;
use Models\Measurement\MeasurementModel;
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
        $objArticle = new ArticlesModel();
        $objData    = new DataModel();
        $objStock   = new StockModel();
        $objPrice   = new PricesModel();
        $objWh      = new WarehouseModel();
        $objCat     = new CategoryModel();
        $objSb      = new SubcategoryModel();
        $objMt      = new MeasurementModel();
        $objClr     = new ColorsModel();

        if (isset($_FILES['excel_file'])) {
            $excelFileTmpPath   = $_FILES['excel_file']['tmp_name'];
            $spreadsheet        = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFileTmpPath);
            $sheet              = $spreadsheet->getActiveSheet();
            $data               = $sheet->toArray();

            array_shift($data);

            foreach ($data as $row) {
                $row    = array_map(function ($value) {
                    return $value !== null ? strtoupper($value) : null;
                }, $row);

                if (!empty(array_filter($row))) {
                    $lastIdArticle  = $objData->getLastId("articles", "ar_id");
                    $lastIdArticle++;

                    $category = $objCat->consultCategoryForName($row['7']);

                    if (empty($category)) {
                        $objCat->InsertCategory($row['7']);
                        $lastInsertCategory = $objData->getLastId("category", "cat_id");

                    } else {
                        $lastInsertCategory = $category[0]['cat_id'];

                    }

                    $Subcategory = $objSb->consultSubcategoryForName($row['8']);

                    if (empty($Subcategory)) {
                        $objSb->insertSubcategroy($row['8'], null, $lastInsertCategory);
                        $lastInsertSubcategory  = $objData->getLastId("subcategory", "sbcat_id");

                    } else {
                        $lastInsertSubcategory = $Subcategory[0]['sbcat_id'];

                    }

                    $mt_data    = $objMt->getMeasurementByName($row[5]);
                    $color_data = $objClr->getColorByName($row[6]);

                    if (empty($mt_data)) {
                        echo '<script>alert("La unidad de medida no se ha encontrado.");</script>';
                        exit;
                    }
                    
                    $mt_id      = $mt_data[0]['mt_id'];
                    $color_id   = empty($color_data) ? null : $color_data[0]['color_id'];
                    $state_id   = $row[9] == 'Activo' ? 1 : 2;

                    $objArticle->insertArticle(
                        $lastIdArticle,
                        $row[2],
                        $row[3],
                        $row[1],
                        $row[4],
                        $color_id,
                        $row[5],
                        null,
                        null,
                        $mt_id,
                        $lastInsertCategory,
                        $lastInsertSubcategory,
                        $state_id
                    );

                    /**
                     * Se comenta porque no viene almacen en el Excel
                     */
                    // $warehouse = $objWh->consultWarehouseWithCode($row['16']);

                    // if (!empty($warehouse)) {
                    //     foreach ($warehouse as $wh) {
                    //         $objStock->insertStock($row[12], $row[13], $row[14], $row[15], $lastIdArticle, $wh['wh_id']);
                    //         $objPrice->insertPrice($lastIdArticle, $wh['wh_id'], $row[17]);
                    //     }

                    // } else {
                    //     $objWh->insertWarehouse(null, null, $row['16'], null, null, null, null, null, $_SESSION['IdCompany']);
                    //     $wh_id = $objWh->getLastId('warehouse', 'wh_id');
                    //     $objStock->insertStock($row[12], $row[13], $row[14], $row[15], $lastIdArticle, $wh_id);
                    //     $objPrice->insertPrice($lastIdArticle, $wh_id, $row[17]);
                    // }

                } else {
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
            $excelFileTmpPath   = $_FILES['excel_file']['tmp_name'];
            $spreadsheet        = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFileTmpPath);
            $sheet              = $spreadsheet->getActiveSheet();
            $data               = $sheet->toArray();

            array_shift($data);
            
            $objCompany = new CompanyModel();
            $objUser    = new UserModel();
            $mail       = new MailModel();

            foreach ($data as $row) {
                if (!empty(array_filter($row))) {
                    $row = array_map(function ($value) {
                        return $value !== null ? strtoupper($value) : null;
                    }, $row);

                    $objCompany->RegisterCompaniesClients($row[0], $row[1], $row[2], $row[3], '3', $row[4], $row[5], $row[6]);
                    
                    $lastIdCompany      = $objCompany->getLastId('company', 'c_id');
                    $characters         = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $passwordGenerate   = substr(str_shuffle($characters), 0, 12);
                    $password           = password_hash($passwordGenerate, PASSWORD_BCRYPT);

                    $objUser->insertUser($row[10], $password, null, $lastIdCompany, 3, 3, $row[7], $row[8], $row[9], $row[12], $row[11], $row[4], $row[6]);
                    $templateEmail      = TemplateModel::TemplateNotificationDocumentRequest($row[7], $row[10], $passwordGenerate);
                    $mail->DataEmail($templateEmail, $row[10], 'REGISTRO PORTAL CLIENTES');

                } else {
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
                $export     = new ArticlesModel();
                $excel      = new ExcelModel();
                $dataExport = $export->consultAllArticles();

                $filename = 'Exportar_Artículos';
                $filePath = $excel->genereateExcelExportArticles($dataExport, $filename, 'uploads/exports/Exportar_Artículos.xlsx');

                ob_clean();

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $filename . '.xlsx' . '"');
                header('Content-Length: ' . filesize($filePath));

                readfile($filePath);

                exit;
            } catch (Exception $e) {
                showAlertredirect('Atención!!!', 'Se ha producido un error', 'error', $url_redirect);
                error_log("error");
                error_log(print_r($e->getMessage(), true));

                return false;
            }

        } else {
            showAlertredirect('Atención!!!', 'Datos vacíos, reporte al administrador del sitio', 'error', $url_redirect);
            return false;
        }
    }

    public function ExportClientsExe()
    {
        $url_redirect   = generateUrl("Data", "Data", "ExportView");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            try {
                $export     = new CompanyModel();
                $excel      = new ExcelModel();
                $dataExport = $export->consultAllClients();

                $filename = 'Exportar_Clientes';
                $filePath = $excel->genereateExcelExportClients($dataExport, $filename, 'uploads/exports/Exportar_Clientes.xlsx');

                ob_clean();

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $filename . '.xlsx' . '"');
                header('Content-Length: ' . filesize($filePath));

                readfile($filePath);

                exit;

            } catch (Exception $e) {
                showAlertredirect('Atención!!!', 'Se ha producido un error', 'error', $url_redirect);
                error_log("error");
                error_log(print_r($e->getMessage(), true));

                return false;
            }

        } else {
            showAlertredirect('Atención!!!', 'Datos vacíos, reporte al administrador del sitio', 'error', $url_redirect);
            
            return false;
        }
    }
}
