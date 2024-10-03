<?php
require '../vendor/autoload.php';
use Models\Articles\ArticlesModel;
use Models\Colors\ColorsModel;
use Models\Permission\PermissionModel;
use Models\Prices\PricesModel;
use Models\Stock\StockModel;
use Models\Measurement\MeasurementModel;
use function Helpers\dd;
use function Helpers\redirect;
use function Helpers\generateUrl;
// ID on the table modules of la bd
// 1: Dashboard
// 2: Quotes
// 3: Order
// 4: List prices
// 5: warehouse
// 6: stock
// 7: reports

class ArticlesController{


    public function consult() {
        // $obj = new PermissionModel();
        // if (!$obj->checkPermission(self::MODULE_ID)) {
        //     die('Acceso denegado');
        // } else {
            $obj = new ArticlesModel();
            $objColor = new ColorsModel();
            $objStock= new StockModel();
            $objPrice= new PricesModel();
            $objMeauserement= new MeasurementModel();


            $articles = $obj->consultArticles();
            foreach ($articles as &$arti) {
              //  $color = $objColor->consultColorByID($arti['color_id']) ?? 'No Aplica';
                $color = null;
                $stock=$objStock->consultStockArticleById($arti['ar_id']);
                $price=$objPrice->consultPriceById($arti['ar_id']);
                $meauserement=$objMeauserement->consultMeasurementById($arti['mt_id']);
                $arti['meauserement'] = $meauserement;
                $arti['price'] = $price;
                $arti['stock'] = $stock;
                $arti['color'] = $color;
            }
            include_once '../app/Views/articles/consultTable.php';
    }


    public function consultGridArticles(){
        $obj= new ArticlesModel();
        $objColor= new ColorsModel();
        $objStock= new StockModel();
        $objPrice= new PricesModel();
        $objMeauserement= new MeasurementModel();

        $articles=$obj->consultArticles();


        foreach ($articles as &$arti) {
           $color=$objColor->consultColorByID($arti['color_id']);
           $stock=$objStock->consultStockArticleById($arti['ar_id']);
           $price=$objPrice->consultPriceById($arti['ar_id']);
           $meauserement=$objMeauserement->consultMeasurementById($arti['mt_id']);

           $arti['price'] = $price;
           $arti['color'] = $color;
           $arti['stock'] = $stock;
           $arti['meauserement'] = $meauserement;

        }

        // dd($articles);

        $articlesForRows=$_GET['order'];
        $count=0;
        if ($articlesForRows=='table') {
           redirect(generateUrl("Articles","Articles","consult"));
        }else {
            foreach ($articles as $art) {
                if ($count % $articlesForRows == 0) {
                    echo '<div class="row mt-3">';
                }
                ?>
        <div class="col-md-<?php echo 12 / $articlesForRows ?> roll-in-blurred-left cardsDiv">
            <div class="card h-100">
                <img data-url="<?= Helpers\generateUrl("Stock", "Stock", "viewArticleDesc", [], "ajax") ?>"
                    data-value="<?= $art['ar_id'] ?>" src="<?= $art['ar_img_url'] ?>"
                    class="card-img-top img-fluid rounded viewArticle" style="height: 200px; object-fit: cover;" alt="...">
                <div class="card-body" style="overflow: hidden;">
                    <h5 class="card-title"><?= $art['ar_name'] ?></h5>
                    <p class="card-text"><b>Descripción: </b><?=substr($art['ar_desc'], 0, 100) . '...' ?></p>
                    <p class="card-text"><b>Unidad de medida: </b><?= $art['ar_measurement_value'] ?>
                        <?php foreach ($art['meauserement'] as $m) {
                            echo $m['mt_meas'];
                        ?>
                        <?php  } ?></p>
                    <?php foreach ($art['color'] as $color): ?>
                    <p class="card-text"><b>Color: </b><?= $color['color_name'] ?></p>
                    <?php endforeach; ?>
                    <?php foreach ($art['price'] as $price): ?>
                    <p class="card-text"><b>Precio: </b><?= $price['p_value'] ?></p>
                    <?php endforeach; ?>
                    <?php if (!empty($art['stock'])): ?>
                    <?php foreach ($art['stock'] as $stock): ?>
                    <p class="card-text"><b>Cantidad en stock: </b><?= $stock['stock_Quantity'] ?></p>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="card-text"><b>Cantidad en stock: </b>Sin existencias</p>
                    <?php endif; ?>
                    <button id="pdf-btn" data-pdf-url="<?= $art['ar_data_url']?>" class="btn btn-outline-primary">Ficha
                        técnica</button>
                </div>
            </div>
        </div>

<?php
                        $count++;
                        if ($count % $articlesForRows == 0) {
                            echo '</div>';
                        }
                    }

                    if ($count % $articlesForRows!= 0) {
                        echo '</div>';
                    }
                }
    }

}
?>