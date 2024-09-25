<?php
require '../vendor/autoload.php';

use Models\Articles\ArticlesModel;
use Models\Town\TownModel;
use Models\Warehouse\WarehouseModel;
use Models\Colors\ColorsModel;
use Models\Measurement\MeasurementModel;
use Models\Prices\PricesModel;
use Models\Stock\StockModel;

use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

class WarehouseController
{
 
    public function ViewCreateWarehouse(){
        $objWarehouse= new WarehouseModel();
        $warehouse=$objWarehouse->consultWarehouses();
        $ObjCity= new TownModel();
        $deptos=$ObjCity->consultDeptos();
        include_once '../app/Views/warehouse/warehouseViewCreate.php';
    }
    public function ViewModalWarehouse(){
        $objWarehouse=new WarehouseModel();
        $ObjCity= new TownModel();
        $wh_id=$_POST['id'];
        $warehouse=$objWarehouse->consultWarehouseById($wh_id); 

        $deptos=$ObjCity->consultDeptos();  
        $townsSelected=$ObjCity->consultTowns($warehouse[0]['wh_departament']);
 
        include '../app/Views/warehouse/warehouseModalUpdate.php';
    }
    public function InsertWarehouse(){
        $objWarehouse= new WarehouseModel();
        
        $wh_name=$_POST['name'];
        $wh_responsible=$_POST['responsible'];
        $wh_depto=$_POST['depto'];
        $wh_city=$_POST['city'];
        $wh_phone=$_POST['phone'];
        $wh_address=$_POST['Address'];
        $wh_desc=$_POST['desc'];
        $wh_code=$_POST['code'];

        $objWarehouse->insertWarehouse($wh_name,$wh_desc,$wh_code,$wh_address,$wh_depto,$wh_city,$wh_responsible,$wh_phone,$_SESSION['IdCompany']); 
        redirect(generateUrl("Warehouse","Warehouse","ViewCreateWarehouse"));
    }

    public function ViewWarehouseArticles(){
        $obj= new WarehouseModel();
        $objColor= new ColorsModel();
        $objStock= new StockModel();
        $objPrice= new PricesModel();
        $objMeauserement= new MeasurementModel();

        $wh_id=$_GET['wh_id'];
        $articles=$obj->consultArticles($wh_id);
        foreach ($articles as &$arti) {
            $color=$objColor->consultColorByID($arti['color_id']);
            $stock=$objStock->consultStockArticleById($arti['ar_id']);
            $price=$objPrice->consultPriceById($arti['ar_id']);
            $meauserement=$objMeauserement->consultMeasurementById($arti['mt_id']);
            $arti['price'] = $price;
            $arti['stock'] = $stock;
            $arti['color'] = $color;
            $arti['meauserement'] = $meauserement;
         }
        //  dd($articles);
        include_once '../app/Views/articles/consultTable.php';
    }

    public function updateWarehouse(){
        // dd($_POST);
        $objWarehouse= new WarehouseModel();
        $wh_id=$_POST['id'];
        $wh_name=$_POST['name'];
        $wh_code=$_POST['code'];
        $wh_responsible=$_POST['responsible'];
        $wh_depto=$_POST['depto'];
        $wh_city=$_POST['city'];
        $wh_phone=$_POST['phone'];
        $wh_address=$_POST['Address'];
        $wh_desc=$_POST['desc'];
        $objWarehouse->updateWarehouse($wh_id,$wh_name,$wh_desc,$wh_code,$wh_address,$wh_depto,$wh_city,$wh_responsible,$wh_phone);
        redirect(generateUrl("Warehouse","Warehouse","ViewCreateWarehouse"));
    }

    public function deleteWarehouse(){
        $wh_id = $_POST['id'];
        $objWarehouse = new WarehouseModel();
        $objStock = new StockModel();
    
        // Verificar si hay stock en la bodega
        $warehouseHasStock = $objStock->checkStockInWarehouse($wh_id);
    
        if ($warehouseHasStock) {
            // Si hay stock en la bodega, mostrar un mensaje de alerta en JavaScript
            echo '0';
        } else {
            // Si no hay stock en la bodega, eliminarla
            $objWarehouse->deleteWarehouse($wh_id, $_SESSION['IdCompany']);
        }
    
    }
    
    
}






?>