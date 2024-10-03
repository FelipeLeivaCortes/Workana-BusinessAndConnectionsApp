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


    public function UpdateArticleOfStockModal(){

        
        // consult of article
        $ar_id=$_POST['ar_id'];

        $objArticle= new ArticlesModel();
        $objStockArticle= new StockModel();
        $objPrice= new PricesModel();
        // info  article
        $article=$objArticle->consultArticleById($ar_id);
        $objSubcategory= new SubcategoryModel();
        
        // subcatgories
        $subcategories=$objSubcategory->consultSubcategoriesByCategory($article[0]['cat_id']);
        //subcategory selected
        
        //info stock
        $stockArticle=$objStockArticle->consultStockArticleById($ar_id);
        // dd($article);
        // info price article
        $priceArticle=$objPrice->consultPriceById($ar_id);
        


        $objCategory= new CategoryModel();
        $objcolor= new ColorsModel();
        $objWarehouse= new WarehouseModel();
        $objMt= new MeasurementModel();

        //consults for insert
        $measurements=$objMt->consultMeasurements();
        $categories=$objCategory->consultCategories();
        $warehouses=$objWarehouse->consultWarehouses();
        $colors= $objcolor->consultColors();


        



        include_once "../app/Views/stock/articleUpdateOfStock.php";
    }

    public function ViewCreateStock()
    {
        $objStock = new StockModel();
        $articles = $objStock->consultStockArticle();
        
        //dd($articles);
    
        foreach ($articles as &$art) {
            $quantityImplicated = $objStock->consultQuantityArticlesImplicated($art['ar_id']);
            $art['quantityImplicated'] = $quantityImplicated !== '' ? $quantityImplicated : 0;
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
        // dd($_FILES);
        $objArticle= new ArticlesModel();
        $stock_id=$_POST['stock_id'];
        $stock_Quantity=$_POST['stock_Quantity'];
        $stock_lote=$_POST['stock_lote'];
        $stock_date_entry=$_POST['stock_date_entry'];
        $stock_expiration_date = isset($_POST['stock_expiration_date']) ? $_POST['stock_expiration_date'] : null;
        $ar_id=$_POST['ar_id'];
        $ar_name=$_POST['ar_name'];
        $ar_desc=$_POST['ar_desc'];
        $ar_measurement_value = isset($_POST['ar_measurement_value']) ? $_POST['ar_measurement_value'] : null;
        $ar_characteristics=$_POST['ar_characteristics'];
        $wh_id=$_POST['warehouse'];
        $color_id=$_POST['color'];
        $cat_id=$_POST['category'];
        $sbcat_id=$_POST['subcategory'];
        $mt_id=$_POST['mt_id'];
        $p_value=$_POST['p_value'];
        $p_id=$_POST['p_id'];
        // Obtener las rutas existentes
        $existingUrls = $objArticle->getArticleUrls($ar_id);
        $existing_img_url = !empty($existingUrls) ? $existingUrls['ar_img_url'] : null;
        $existing_data_url = !empty($existingUrls) ? $existingUrls['ar_data_url'] : null;
        if (isset($_FILES['ar_img_url']) && !empty($_FILES['ar_img_url']['tmp_name'])) {
            // Obtener información del archivo
            $file = $_FILES['ar_img_url'];
            // Obtener nombre y ubicación temporal del archivo
            $filename = $file['name'];
            $tmpFilePath = $file['tmp_name'];
            // Ruta donde se guardarán las imágenes
            $uploadDirectory = 'uploads/articles/img/'.$ar_id.'/';
            // Crear las carpetas si no existen
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            // Mover el archivo a la ubicación deseada
            $destinationImg = $uploadDirectory . $filename;
            move_uploaded_file($tmpFilePath, $destinationImg);
            // Asignar la ruta del nuevo archivo o la ruta existente si no se envió un nuevo archivo
            $img_url = $destinationImg;
        } else {
            // Asignar la ruta existente o null si no hay una ruta existente
            $img_url = $existing_img_url;
        }
    
        if (isset($_FILES['ar_data_url']) && !empty($_FILES['ar_data_url']['tmp_name'])) {
            // Obtener información del archivo
            $file = $_FILES['ar_data_url'];
            // Obtener nombre y ubicación temporal del archivo
            $filename = $file['name'];
            $tmpFilePath = $file['tmp_name'];
            // Ruta donde se guardarán las imágenes
            $uploadDirectory = 'uploads/articles/dataSheet/'.$ar_id.'/';
            // Crear las carpetas si no existen
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            // Mover el archivo a la ubicación deseada
            $destinationData = $uploadDirectory . $filename;
            move_uploaded_file($tmpFilePath, $destinationData);
            // Asignar la ruta del nuevo archivo o la ruta existente si no se envió un nuevo archivo
            $data_url = $destinationData;
        } else {
            // Asignar la ruta existente o null si no hay una ruta existente
            $data_url = $existing_data_url;
        }

        $objStock= new StockModel();
        $objStock->updateStock($stock_id,$stock_Quantity,$stock_lote,$stock_date_entry,$stock_expiration_date,$wh_id);
        $objArticle->updateArticle($ar_id,$ar_name,$ar_desc,$color_id, $ar_measurement_value,$img_url,$cat_id,$sbcat_id,$mt_id, $ar_characteristics,$data_url);
        $objPrice= new PricesModel();
        $objPrice->updatePrice($ar_id,$wh_id,$p_value,$p_id);
        redirect(generateUrl("Stock","Stock","ViewCreateStock"));
    }

    public function viewArticleDesc(){
        $id_article=$_POST['id'];
        $objArticle=new ArticlesModel();
        $objprice=new PricesModel();
        $objStock= new StockModel();

        $discount= new Customer_discountsModel();
        $discount->consultDiscountsByColumn('c_id',$_SESSION['IdCompany']);

        $article=$objArticle->consultArticleById($id_article);
        $priceArticle=$objprice->consultPriceById($id_article);
        $stockArticle=$objStock->consultStockArticleById($id_article);
        // dd($priceArticle);
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






?>