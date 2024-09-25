<?php
require '../vendor/autoload.php';

use Models\Api\ApiModel;
use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

class ApiController{


    public function consult() {

        $Api= new ApiModel();  
        $articles=$Api->getProducts();
        // dd($articles);
        include_once '../app/Views/articles/Api/consultTable.php';

    }

    public function ViewCreateArticle(){
        include_once '../app/Views/articles/Api/CreateArticles.php';
    }

    public function createArticle(){
        $Api= new ApiModel();


        $name=$_POST['name'];
        $regular_price=$_POST['regular_price'];
        $description=$_POST['description'];
        $status=$_POST['status'];
        $sku=$_POST['sku'];
        $short_desc=$_POST['short_desc'];
        $stock_quantity=$_POST['stock_quantity'];

        $data = [
            'name' => $name,
            'type' => 'simple',
            'sku'=>$sku,
            'regular_price' => $regular_price,
            'description' => $description,
            'date_created' => date("Y-m-d H:i:s"),
            'status'=>$status,
            'short_description' => $short_desc,
            'manage_stock' => 1,
            'stock_quantity' => $stock_quantity,
            'categories' => [
                [
                    'id' => 9
                ],
                [
                    'id' => 14
                ]
            ],
            'images' => [
                [
                    'src' =>'https://i.postimg.cc/FzdD7LXD/almacen-alternativo.png'
                ],
                [
                    'src' =>'https://i.postimg.cc/FzdD7LXD/almacen-alternativo.png'
                ]
            ]
        ];
        


     $lastIdArticle=$Api->createProduct($data);
     

        if (isset($_FILES['ar_img_url'])) {
            // Obtener información del archivo
            $file = $_FILES['ar_img_url'];
            // Obtener nombre y ubicación temporal del archivo
            $filename = $file['name'];
            $tmpFilePath = $file['tmp_name'];
            //Carpeta principal
            $folderPrincipal = 'uploads/articles/img/';
            // Ruta donde se guardarán las imágenes
            $uploadDirectory = 'uploads/articles/img/'.$lastIdArticle.'/';   
            // Crear las carpetas si no existen
            if (!is_dir($uploadDirectory)) {
                chmod($folderPrincipal, 0777);
                mkdir($uploadDirectory, 0777, true);
            }
            // Mover el archivo a la ubicación deseada
            $destinationImg = $uploadDirectory . $filename;
            move_uploaded_file($tmpFilePath, $destinationImg);   
            // Aquí puedes realizar cualquier operación adicional con la imagen, como guardar el nombre de archivo en la base de datos, etc.
        }
        // if (isset($_FILES['ar_data_url'])) {
        //     // Obtener información del archivo
        //     $file = $_FILES['ar_data_url'];
        //     // Obtener nombre y ubicación temporal del archivo
        //     $filename = $file['name'];
        //     $tmpFilePath = $file['tmp_name'];
        //     // Ruta donde se guardarán las imágenes
        //     $uploadDirectory = 'uploads/articles/dataSheet/'.$lastIdArticle.'/';   
        //     // Crear las carpetas si no existen
        //     if (!is_dir($uploadDirectory)) {
        //         mkdir($uploadDirectory, 0755, true);
        //     }
        //     // Mover el archivo a la ubicación deseada
        //     $destinationData = $uploadDirectory . $filename;
        //     move_uploaded_file($tmpFilePath, $destinationData);   
        //     // Aquí puedes realizar cualquier operación adicional con la imagen, como guardar el nombre de archivo en la base de datos, etc.
        // }


       
        $data = [
            'images' => [
                [
                    'src' => 'https://' . $_SERVER['HTTP_HOST'] . '/PortalUsuarios/public/' . $destinationImg


                ],
                [
                    'src' => 'https://' . $_SERVER['HTTP_HOST'] . '/PortalUsuarios/public/' . $destinationImg


                ]
            ]
        ];
       
        $Api->updateProduct($lastIdArticle, $data);
        
        redirect(generateUrl("Api","Api","consult"));


    }

    public function viewArticleDesc(){
        $Api= new ApiModel();
        $id_article=$_POST['id'];
        $article=$Api->getProduct($id_article);
        // dd($article);
        include_once "../app/Views/articles/Api/ViewArticleDesc.php";
    }
    
    public function consultGridArticles(){
        $Api= new ApiModel();
        $articles=$Api->getProducts();
        $articlesForRows=$_GET['order'];
        $count=0;
        if ($articlesForRows=='table') {
            redirect(generateUrl("Api","Api","consult"));
        }else {
            foreach ($articles as $art) {
                if ($count % $articlesForRows == 0) {
                    echo '<div class="row mt-3">';
                }
                ?>
        <div class="col-md-<?php echo 12 / $articlesForRows ?> roll-in-blurred-left cardsDiv">
            <div class="card">
                <img src="<?= $art->images[0]->src ?>" class="card-img-top img-fluid viewArticle" value="<?= $art->id?>" data-url="<?= Helpers\generateUrl("Api", "Api", "viewArticleDesc", [], "ajax") ?>" data-value="<?= $art->id?>" style="height: 200px; object-fit: cover;"
                    alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=  $art->name ?></h5>
                    <p class="card-text"><b>Codigo: </b><?= $art->sku ?></p>
                    <p class="card-text"><b>Descripción: </b><?= $art->short_description  ?></p>
                    <p class="card-text"><b>Precio: </b><?= $art->price_html ?></p>
                    <p class="card-text"><b>Cantidad en stock: </b><?= $art->purchasable ?></p>
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