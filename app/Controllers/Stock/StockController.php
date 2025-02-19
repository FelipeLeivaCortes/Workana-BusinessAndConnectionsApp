<?php
require '../vendor/autoload.php';
use Models\Stock\StockModel;
use Models\Articles\ArticlesModel;
use Models\Prices\PricesModel;
use Models\Category\CategoryModel;
use Models\Colors\ColorsModel;
use Models\Customer_discounts\Customer_discountsModel;
use Models\Measurement\MeasurementModel;
use Models\Quote\QuoteModel;
use Models\Subcategory\SubcategoryModel;
use Models\Warehouse\WarehouseModel;
use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

class StockController
{
    public function insertArticleStock(){
        $obj    = new ArticlesModel();

        $stock_Quantity         = $_POST['stock_Quantity'];
        $p_value                = $_POST['p_value'];
        $wh_id                  = $_POST['warehouse'] ?? null;
        $stock_lote             = $_POST['stock_lote'];
        $stock_date_entry       = $_POST['stock_date_entry'];
        $stock_expiration_date  = $_POST['stock_expiration_date'] ?? null;
        $name                   = $_POST['ar_name'];
        $code                   = $_POST['ar_code'];
        $mt_id                  = $_POST['mt_id'];
        $cat_id                 = $_POST['cat_id'] ?? null;
        $sbcat_id               = $_POST['subcategory'] ?? null;
        $ar_measurement_value   = $_POST['ar_measurement_value'];
        $color_id               = $_POST['color_id'] ?? null;
        $ar_desc                = $_POST['ar_desc'];
        $ar_characteristics     = $_POST['ar_characteristics'];
        
        $lastIdArticle          = $obj->getLastId("articles","ar_id");
        $lastIdArticle++;
        
        if (isset($_FILES['ar_img_url'])) {
            $file               = $_FILES['ar_img_url'];
            $filename           = $file['name'];
            $tmpFilePath        = $file['tmp_name'];
            $uploadDirectory    = 'uploads/articles/img/'.$lastIdArticle.'/';
            
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            
            $destinationImg     = $uploadDirectory . $filename;

            move_uploaded_file($tmpFilePath, $destinationImg);
        }
        
        if (isset($_FILES['ar_data_url'])) {
            $file               = $_FILES['ar_data_url'];
            $filename           = $file['name'];
            $tmpFilePath        = $file['tmp_name'];
            $uploadDirectory    = 'uploads/articles/dataSheet/'.$lastIdArticle.'/';

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $destinationData = $uploadDirectory . $filename;
            
            move_uploaded_file($tmpFilePath, $destinationData);
        }

        $obj->insertArticle(
            $lastIdArticle,
            $name,
            $ar_desc,
            $code,
            $ar_characteristics,
            $color_id,
            $ar_measurement_value,
            $destinationImg,
            $destinationData,
            $mt_id,
            $cat_id,
            $sbcat_id
        );

        $obj    = new StockModel();
        $obj->insertStock(
            $stock_Quantity,
            $stock_lote,
            $stock_date_entry,
            $stock_expiration_date,
            $lastIdArticle,
            $wh_id
        );
        
        $obj    = new PricesModel();
        $obj->insertPrice(
            $lastIdArticle,
            $wh_id,
            $p_value
        );
        
        redirect(generateUrl("Stock", "Stock", "ViewCreateStock"));
    }

    public function UpdateArticleOfStockModal()
    {
        $ar_id              = $_POST['ar_id'];
        $objArticle         = new ArticlesModel();
        $objStockArticle    = new StockModel();
        $objPrice           = new PricesModel();
        $article            = $objArticle->consultArticleById($ar_id)[0];
        $objSubcategory     = new SubcategoryModel();
        
        $category_id        = $article[0]['cat_id'] ?? null;
        $subcategories      = $objSubcategory->consultSubcategoriesByCategory($category_id);
        
        $stockArticle   = $objStockArticle->consultStockArticleById($ar_id);
        $priceArticle   = $objPrice->consultPriceById($ar_id)[0] ?? ['p_value' => 0, 'p_id' => 0];

        $objCategory    = new CategoryModel();
        $objcolor       = new ColorsModel();
        $objWarehouse   = new WarehouseModel();
        $objMt          = new MeasurementModel();


        $measurements   = $objMt->consultMeasurements();
        $categories     = $objCategory->consultCategories();
        $warehouses     = $objWarehouse->consultWarehouses();
        $colors         = $objcolor->consultColors();


       include_once "../app/Views/stock/articleUpdateOfStock.php";
    }

    public function ViewCreateStock()
    {
        $objStock   = new StockModel();
        $articles   = $objStock->consultStockArticle();
        
        foreach ($articles as &$art) {
            $quantityImplicated         = $objStock->consultQuantityArticlesImplicated($art['ar_id']);
            $art['quantityImplicated']  = $quantityImplicated !== '' ? $quantityImplicated : 0;
        }

        include_once "../app/Views/stock/StockCreate.php";
    }
    
    public function ViewModalCreateArticle(){
        $objCategory= new CategoryModel();
        $objcolor= new ColorsModel();
        $objWarehouse= new WarehouseModel();
        $objMt= new MeasurementModel();

        //consults
        $measurements=$objMt->consultMeasurements();
        $categories=$objCategory->consultCategories();
        $warehouses=$objWarehouse->consultWarehouses();
        $colors= $objcolor->consultColors();
        include_once "../app/Views/stock/stockModalCreateArticle.php";
    }

    public function UpdateArticleStock(){
        $objArticle             = new ArticlesModel();
        $stock_id               = $_POST['stock_id'];
        $stock_Quantity         = $_POST['stock_Quantity'];
        $stock_lote             = $_POST['stock_lote'];
        $stock_date_entry       = $_POST['stock_date_entry'];
        $stock_expiration_date  = isset($_POST['stock_expiration_date']) ? $_POST['stock_expiration_date'] : null;
        $ar_id                  = $_POST['ar_id'];
        $ar_name                = $_POST['ar_name'];
        $ar_desc                = $_POST['ar_desc'];
        $ar_code                = $_POST['ar_code'];
        $ar_measurement_value   = isset($_POST['ar_measurement_value']) ? $_POST['ar_measurement_value'] : null;
        $ar_characteristics     = $_POST['ar_characteristics'];
        $wh_id                  = $_POST['warehouse'];
        $color_id               = $_POST['color'] ?? null;
        $cat_id                 = $_POST['category'] ?? null;
        $sbcat_id               = $_POST['subcategory'] ?? null;
        $mt_id                  = $_POST['mt_id'];
        $p_value                = $_POST['p_value'];
        $p_id                   = $_POST['p_id'];


        $existingUrls       = $objArticle->getArticleUrls($ar_id);
        $existing_img_url   = !empty($existingUrls) ? $existingUrls['ar_img_url'] : null;
        $existing_data_url  = !empty($existingUrls) ? $existingUrls['ar_data_url'] : null;

        if (isset($_FILES['ar_img_url']) && !empty($_FILES['ar_img_url']['tmp_name'])) {
            $file               = $_FILES['ar_img_url'];
            $filename           = $file['name'];
            $tmpFilePath        = $file['tmp_name'];
            $uploadDirectory    = 'uploads/articles/img/'.$ar_id.'/';

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $destinationImg = $uploadDirectory . $filename;
            move_uploaded_file($tmpFilePath, $destinationImg);

            $img_url    = $destinationImg;

        } else {
            $img_url    = $existing_img_url;

        }
    

        if (isset($_FILES['ar_data_url']) && !empty($_FILES['ar_data_url']['tmp_name'])) {
            $file               = $_FILES['ar_data_url'];
            $filename           = $file['name'];
            $tmpFilePath        = $file['tmp_name'];
            $uploadDirectory    = 'uploads/articles/dataSheet/'.$ar_id.'/';

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $destinationData    = $uploadDirectory . $filename;
            move_uploaded_file($tmpFilePath, $destinationData);

            $data_url   = $destinationData;

        } else {
            $data_url   = $existing_data_url;

        }


        $objStock   = new StockModel();
        $objStock->updateStock($stock_id, $stock_Quantity, $stock_lote, $stock_date_entry, $stock_expiration_date, $wh_id);
        $objArticle->updateArticle($ar_id, $ar_name, $ar_desc, $color_id, $ar_measurement_value, $img_url, $cat_id, $sbcat_id, $mt_id, $ar_characteristics, $data_url);
        
        $objPrice   = new PricesModel();
        $price      = $objPrice->consultPriceById($ar_id);

        if (empty($price)) {
            $objPrice->insertPrice($ar_id, $wh_id, $p_value);
        } else {
            $objPrice->updatePrice($ar_id, $wh_id, $p_value, $p_id);
        }

        redirect(generateUrl("Stock", "Stock", "ViewCreateStock"));
    }

    public function viewArticleDesc(){
        $id_article = $_POST['id'];
        $objArticle = new ArticlesModel();
        $objprice   = new PricesModel();
        $objStock   = new StockModel();

        $discount   = new Customer_discountsModel();
        $discount->consultDiscountsByColumn('c_id',$_SESSION['IdCompany']);

        $article        = $objArticle->consultArticleById($id_article);
        $priceArticle   = sizeof($objprice->consultPriceById($id_article)) == 0 ? 0 : $objprice->consultPriceById($id_article)[0]['p_value'];
        $stockArticle   = sizeof($objStock->consultStockArticleById($id_article)) == 0 ? 0 : $objStock->consultStockArticleById($id_article)[0]['stock_Quantity'];


        include_once "../app/Views/stock/ViewArticleDesc.php";
    }

    public function subcategoriesAjax(){
        $cat_id=$_POST['id'];
        $objSubcategory= new SubcategoryModel();
        $subcategories=$objSubcategory->consultSubcategoryById($cat_id);
        ?>
        <select name="subcategory" id="subcategory" class="form form-select">
            <option disabled="true" selected="true">Seleccione</option>
            <?php foreach ($subcategories as $sbc) {
                echo ' <option value="'.$sbc["sbcat_id"].'">'.$sbc["sbcat_name"].'</option>';
                }
                ?>
        </select>
        <?php
    }
}
