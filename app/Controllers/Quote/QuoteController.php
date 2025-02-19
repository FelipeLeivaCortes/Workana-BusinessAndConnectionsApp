<?php
require '../vendor/autoload.php';

use Models\Quote\QuoteModel;
use Models\Articles\ArticlesModel;
use Models\Pdf\PdfModel;
use Models\Category\CategoryModel;
use Models\Prices\PricesModel;
use Models\Colors\ColorsModel;
use Models\Company\CompanyModel;
use Models\Groups\GroupsModel;
use Models\Customer_discounts\Customer_discountsModel;
use Models\Customer_payment_method\Customer_payment_methodModel;
use Models\MethodsPay\MethodsPayModel;
use Models\Sellers\SellersModel;
use Models\User\UserModel;
use Mpdf\Tag\Article;
use Models\Warehouse\WarehouseModel;

use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

use ThirdParty\ReflexController;

class QuoteController
{
    public function viewDetaillsQuote()
    {
        $objQuote   = new QuoteModel();
        $id         = $_GET['quo_id'];
        $quote      = $objQuote->consultQuoteById($id);


        $ObjUser    = new UserModel();
        $user       = $ObjUser->getUserInfoById($quote[0]['u_id']);
        $objCompany = new CompanyModel();
        $company    = $objCompany->ConsultCompany($user['c_id']);

        if ($quote[0]['quote_state_id'] != 1) {
            redirect(generateUrl("Quote", "Quote", "quotesCompanies"));

        } else {
            $obj                        = new CompanyModel();
            $shipping_address           = $obj->ConsultCompany($user['c_id']);


            $objCustomerPaymentMethods  = new Customer_payment_methodModel();
            $payment_methods            = $objCustomerPaymentMethods->getPaymentMethodsByCustomerId($user['c_id']);


            $objMethods = new MethodsPayModel();

            if (!empty($payment_methods)) {
                $methods    = array();

                foreach ($payment_methods as $p) {
                    $methods[]  = $objMethods->consultMethodsById($p['payment_method_id']);
                }

            } else {
                $methods[]  = "No tiene métodos de pago asignados todavía";
            }

            $orderAddress   = '';
            foreach ($shipping_address as $key) {
                $orderAddress .= $key['c_shippingStreet'] . ', ' . $key['c_shippingApartament'] . ', ' . $key['c_shippingCountry'] . ', ' . $key['c_shippingCity'] . ', ' . $key['c_shippingState'] . ', ' . $key['c_shippingPostalcode'];
            }

            foreach ($quote as &$q) {
                $q['quote_articles']    = $objQuote->consultArticlesOfTheQuote($q['quo_id']);
            }

            $obj    = new SellersModel();
            $seller = $obj->ConsultSellerByIdOfCompany($user['c_id']);

            $articlesHmtl   = '';

            foreach ($quote as $quo) {
                foreach ($quo['quote_articles'] as $art) {
                    $article        = $this->articlesOrderSinceQuoteview($art['ar_id'], $art['quoart_quantity'], $user['c_id']);
                    $articlesHmtl .= $article;
                }
            }

            include_once '../app/Views/quote/viewDetaillsQuote.php';
        }
    }

    public function articlesOrderSinceQuoteview($idArticle, $quantity, $c_id)
    {
        $objArticle = new ArticlesModel();
        $article    = $objArticle->consultArticleById($idArticle);
        $idCategory = $article[0]['cat_id'];

        $objCategory    = new CategoryModel();
        $category       = $objCategory->consultCategoryById($idCategory);
        $nameCategory   = $category[0]['cat_name'] ?? 'Sin Categoria';


        $objPrice   = new PricesModel();
        $price      = $objPrice->consultPriceById($idArticle);


        $objDiscount        = new Customer_discountsModel();
        $discountCompany    = $objDiscount->consultDiscountsByColumn('c_id', $c_id);

        $priceDiscount              = null;
        $discountPercentage         = null;
        $arryArticles               = array();
        $arrayCategories            = array();
        $arraySubcategories         = array();
        $discountPercentajeOrPrice  = 'No aplica';

        if (!empty($discountCompany)) {
            $objGroups  = new GroupsModel();
            $group      = $objGroups->consultGroupById($discountCompany[0]['gp_id']);
            
            foreach ($discountCompany as $key) {
                $arryArticles[]         = $key['ar_id'];
                $arrayCategories[]      = $key['cat_id'];
                $arraySubcategories[]   = $key['sbcat_id'];
            }

            $priceDiscount      = $discountCompany[0]['price_discount'];
            $discountPercentage = $group[0]['gp_discount_percentage'];

            if (!empty($discountPercentage)) {
                $discountPercentajeOrPrice = $discountPercentage . '%';
            }

            if (!empty($priceDiscount)) {
                $discountPercentajeOrPrice = $priceDiscount . '$';
            }
        }

        $html = '';

        foreach ($article as $ar) {
            $price              = $price[0]['p_value'] ?? 0;
            $discountedPrice    = $this->verifyDiscount($ar['ar_id'], $ar['cat_id'], $ar['sbcat_id'], $arryArticles, $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $price);
            $subtotal           = $discountedPrice * $quantity;

            $html .= '<tr>
                        <td class="ar_id_'.$ar['ar_id'].' id_product">' . $ar['ar_id'] . '</td>
                        <td></i>' . $ar['ar_name'] . '</td>
                        <td>' . $nameCategory . '</td>
                        <td>
                            <input readonly type="number" class="form-control quantityArt" name="quantity_article[]" min="1" value="' . $quantity . '">
                            <input  readonly type="hidden"  name="art_id[]" value="' . $ar['ar_id'] . '">
                        </td>
                        <td class="price">$' . $price . '<input readonly type="hidden" name="PriceNormal[]" value="' . $price . '"></td>
                        <td>' . $discountPercentajeOrPrice . '<input readonly type="hidden" name="discountPercentajeOrPrice[]" value=' . $discountPercentajeOrPrice . '></td>
                        <td class="discount">$' . $discountedPrice . '<input readonly type="hidden" name="discountPrice[]" value="' . $discountedPrice . '" ></td>
                        <td class="subtotal">$' . $subtotal . '</td>
                    </tr>';
        }

        return $html;
    }

    public function ViewCreateQuote()
    {
        $obj = new CompanyModel();
        $shipping_address = $obj->ConsultCompany($_SESSION['IdCompany']);

        $objCustomerPaymentMethods = new Customer_payment_methodModel();
        $payment_methods = $objCustomerPaymentMethods->getPaymentMethodsByCustomerId($_SESSION['IdCompany']);
        $objMethods = new MethodsPayModel();

        if (!empty($payment_methods)) {
            $methods = array();
            foreach ($payment_methods as $p) {
                $methods[] = $objMethods->consultMethodsById($p['payment_method_id']);
            }
            // Aquí puedes realizar acciones adicionales con los métodos de pago
        } else {
            $methods[] = "No tiene métodos de pago asignados todavía";
        }


        $quoteAddress = '';
        foreach ($shipping_address as $key) {
            $quoteAddress .= $key['c_shippingStreet'] . ', ' . $key['c_shippingApartament'] . ', ' . $key['c_shippingCountry'] . ', ' . $key['c_shippingCity'] . ', ' . $key['c_shippingState'] . ', ' . $key['c_shippingPostalcode'];
        }
        $obj = new SellersModel();
        $seller = $obj->ConsultSellerByIdOfCompany($_SESSION['IdCompany']);

        include_once "../app/Views/quote/quoteCreate.php";
    }

    public function quotesCompanies()
    {
        $obj    = new QuoteModel();
        
        $quotesDB   = $obj->consultQuotesClients();
        $reflex     = new ReflexController();
        $quotesSAP  = $reflex->getQuotes();
        $quotes     = array_merge($quotesDB, $quotesSAP);

        usort($quotes, function($a, $b) {
            return $b['quo_id'] <=> $a['quo_id'];
        });

        include_once '../app/Views/quote/quotesConsultCompanies.php';
    }

    public function viewModalQuoteValidity()
    {
        $objCompany     = new CompanyModel();
        $companies      = $objCompany->consultCompanies();
        include_once '../app/Views/quote/ModalQuoteValidity.php';
    }

    public function updateDateQuoteValiditytoCompany()
    {
        if ($_POST) {
            $arrResponse = [];
            $selectIdCompanies = intval($_POST['selectIdCompanies']);
            $dateQuoteValidity = $_POST['dateQuoteValidity'];
            $formattedDateQuoteValidity = date('Y-m-d H:i:s', strtotime($dateQuoteValidity));
            $objQuotes = new QuoteModel();
            $requestQuoteValidity = $objQuotes->updateDateQuoteValiditytoCompany($selectIdCompanies, $formattedDateQuoteValidity);
          
            if ($requestQuoteValidity) {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            } else {
                $arrResponse = array("status" => false, "msg" => 'No se pudo actualizar la fecha de vigencia de cotización a la empresa');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function ViewQuotes()
    {
        $obj = new QuoteModel();
        $quotes = $obj->consultQuotes($_SESSION['IdCompany']);

        include_once "../app/Views/quote/quoteConsult.php";
    }

    public function CreateQuote()
    {
        $objArticles    = new ArticlesModel();
        $objColor       = new ColorsModel();
        $articles       = $objArticles->consultArticles();

        foreach ($articles as &$arti) {
            $color          = $objColor->consultColorByID($arti['color_id']);
            $arti['color']  = $color;
        }

        include_once "../app/Views/quote/quoteModal.php";
    }

    /**
     * Crea una nueva oferta de venta (Cotización)
     */
    public function pdfQuote()
    {
        $objQuote               = new QuoteModel();
        
        $name                   = $_POST['name'];
        $company                = $_POST['company'];
        $email                  = $_POST['email'];
        $phone                  = $_POST['phone'];
        $payment_method         = $_POST['payment_method'];
        $address_shipping       = $_POST['address_shipping'];
        $comments               = $_POST['comments'];
        $subtotalQuoteInput     = $_POST['subtotalQuoteInput'];
        $taxesQuoteInput        = $_POST['taxesQuoteInput'];
        $totalQuoteInput        = $_POST['totalQuoteInput'];
        $quantity_article       = $_POST['quantity_article'];
        $PriceNormal            = $_POST['PriceNormal'];
        $art_id                 = $_POST['art_id'];
        $PercentajeOrPrice      = $_POST['discountPercentajeOrPrice'];
        $discountPrice          = $_POST['discountPrice'];
        $discountQuoteInput     = $_POST['discountQuoteInput'];
        $additionalCostsInput   = $_POST['additionalCostsInput'];

        // Insert the basic data into the "quotations" table
        $objQuote->insertQuote(
            $name,
            'a',
            $payment_method,
            $company,
            $address_shipping,
            $email,
            $phone,
            $comments,
            $_SESSION['UserNumDocument'],
            $subtotalQuoteInput,
            $taxesQuoteInput,
            $totalQuoteInput,
            null,
            $_SESSION['idUser'],
            '1',
            $discountQuoteInput,
            $additionalCostsInput
        );

        //get last id
        $quo_id = $objQuote->getLastId('quotes', 'quo_id');

        foreach ($art_id as $key => $article_id) {
            $quantity           = $quantity_article[$key];
            $discountType       = $PercentajeOrPrice[$key];
            $discountedPrice    = $discountPrice[$key];

            // Insert the basic data into the "quote and articles" table
            $objQuote->insertQuoteArticle(
                $quo_id,
                $article_id,
                $quantity,
                $PriceNormal[$key],
                $discountType,
                $discountedPrice
            );
        }

        $articles   = $_POST['art_id']; //ARRAY DE ID ARTICLES
        $quantity   = $_POST['quantity_article']; //ARRAY QUANTITY OF ARTICLES
        
        if (isset($_POST['fieldName']) && isset($_POST['fieldValue'])) {
            $fieldName  = $_POST['fieldName']; //ARRAY OF FIELDS NAME
            $fieldValue = $_POST['fieldValue']; //ARRAY OF FIELDS VALUE
        } else {
            $fieldName  = null; //ARRAY OF FIELDS NAME
            $fieldValue = null; //ARRAY OF FIELDS VALUE
        }

        $objPrice               = new PricesModel();
        $objArticle             = new ArticlesModel();
        $company_model          = new CompanyModel();
        $model_payment_method   = new MethodsPayModel();
        $model_seller           = new SellersModel();

        $payment_method_object  = $model_payment_method->consultMethodsById($payment_method);
        $company_object         = $company_model->ConsultCompany($_SESSION['IdCompany']);
        $seller_object          = $model_seller->ConsultSellerByIdOfCompany($_SESSION['IdCompany']);

        $articleArray   = [
            'contact'   => [
                'name'      => $_SESSION['nameUser'],
                'phone'     => $_SESSION['PhoneUser'],
                'reference' => $_SESSION['reference']
            ],
            'customer'   => [
                'address'   => $address_shipping,
                'city'      => $company_object[0]['c_city'],
                'name'      => $company_object[0]['c_name'],
                'nit'       => $company_object[0]['c_num_nit'].'-'.$company_object[0]['c_num_ver_nit']
            ],
            'quote'     => [
                'id'                => $quo_id,
                'comments'          => $comments,
                'seller'            => $seller_object[0]['s_name'],
                'payment_method'    => $payment_method_object[0]['name'],
                'date_expired'      => $company_object[0]['c_dateQuoteValidity'],
                'name_employee'     => $_SESSION['nameUser']
            ],
            'articles'          => []
        ];

        //CONSULT DISCOUNT ARTICLE
        //CHECK IF THE COMPANY EXISTS IN THE DISCOUNT GROUPS
        $objDiscount        = new Customer_discountsModel();
        $discountCompany    = $objDiscount->consultDiscountsByColumn('c_id', $_SESSION['IdCompany']);
        $priceDiscount      = null;
        $discountPercentage = null;
        $arrayArticles      = array();
        $arrayCategories    = array();
        $arraySubcategories = array();
        $discountPercentajeOrPrice = 'No aplica';

        if (!empty($discountCompany)) {
            //CONSULT CATEGORIES,SUBCATEGORIES,ARTICLES AND DISCOUNT GROUP OF DISCOUNT
            $objGroups = new GroupsModel();
            $group = $objGroups->consultGroupById($discountCompany[0]['gp_id']);

            foreach ($discountCompany as $key) {
                $arrayArticles[] = $key['ar_id'];
                $arrayCategories[] = $key['cat_id'];
                $arraySubcategories[] = $key['sbcat_id'];
            }
            // save discount o price discount
            $priceDiscount = $discountCompany[0]['price_discount'];
            $discountPercentage = $group[0]['gp_discount_percentage'];


            // Here it checks if the discount is based on price or percentage, and assigns it to the variable $discountPercentajeOrPrice.
            if (!empty($discountPercentage)) {
                $discountPercentajeOrPrice = $discountPercentage . '%';
            }

            if (!empty($priceDiscount)) {
                $discountPercentajeOrPrice = $priceDiscount . '$';
            }
        }

        foreach ($articles as $key => $ar_id) {
            $article = $objArticle->consultArticleById($ar_id);

            $article['price']   = $price['p_value'] = $objPrice->consultPriceById($ar_id);
            $priceArticle       = 0;

            if (sizeof($article['price']) > 0) {
                $priceArticle   = $article['price'][0]['p_value'];
            }

            $discountedPrice        = $this->verifyDiscount($article[0]['ar_id'], $article[0]['cat_id'], $article[0]['sbcat_id'], $articleArray['articles'], $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $priceArticle);
            $article['pricePre']    = $priceArticle;
            $article['price']       = $discountedPrice;
            $article['discountPercentajeOrPrice'] = $discountPercentajeOrPrice;
            $article['quantity']    = $quantity[$key];

            $articleArray['articles'][] = $article;
        }
        
        //consultar la ultima cotización insertada
        $objQuote = new QuoteModel();

        $objconsultQuoteById    = $objQuote->consultQuoteById($quo_id);
        $quoDiscountTotal       = $objconsultQuoteById[0]['quo_discount_total'];
        $quoAdditionCost        = $objconsultQuoteById[0]['quo_addition_cost'];

        $pdfModel   = new PdfModel();
        $template   = $pdfModel->templateQuotePdf($articleArray);
        $idQuote    = $objQuote->getLastId('quotes', 'quo_id');
        $filePath   = $pdfModel->generatePdf($template, $idQuote, 'quotes');
        $objQuote->updateField('quotes', 'quo_id', $idQuote, 'quo_url_document', $filePath);

        if (isset($_POST['fieldName'])) {
            $fieldNames     = $_POST['fieldName'];
            $fieldValues    = $_POST['fieldValue'];

            for ($i = 0; $i <  count($fieldNames); $i++) {
                $objQuote->insertExtraAttributeQuote($fieldNames[$i], $fieldValues[$i], $quo_id);
            }
        }

        if (isset($_FILES['fieldValue'])) {
            $fileCount = count($_FILES['fieldValue']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $_FILES['fieldValue']['name'][$i];
                $fileTmpName = $_FILES['fieldValue']['tmp_name'][$i];

                // Definir la ubicación de destino para el archivo
                $destination = 'uploads/quotes/' . $quo_id . '/';

                // Verificar si la carpeta de destino existe
                if (!is_dir($destination)) {
                    // La carpeta de destino no existe, intenta crearla
                    if (!mkdir($destination, 0755, true)) {
                        // No se pudo crear la carpeta, muestra un mensaje de error y detén el proceso

                        return;
                    }
                }

                // Construir la ruta completa del archivo
                $filePath = $destination . $fileName;

                // Mover el archivo a la ubicación de destino
                if (move_uploaded_file($fileTmpName, $filePath)) {
                    // echo "El archivo $fileName se ha subido correctamente.";
                    // echo "Ruta completa del archivo: $filePath";
                    $objQuote->insertExtraAttributeQuote($fileName, $filePath, $quo_id);
                } else {
                    echo "Ocurrió un error al mover el archivo $fileName.";
                }
            }
        }



        /**
         * INTEGRACIÓN COMUNICACIÓN API REFLEX - CREACIÓN COTIZACIÓN
         */

        $objCompany     = new CompanyModel();
        $companyData    = $objCompany->consultCompanyByName($company);

        $warehouseModel = new WarehouseModel();
        $warehouseData  = $warehouseModel->consultWarehouseByCompanyId($companyData[0]['c_id']);

        $fechaActual    = new DateTime();
        $fechaActual->modify('+3 days');
        $docDueDate     = $fechaActual->format('Ymd');  // Por defecto el documento expira en 3 dias

        $documentLines  = array();

        for ($i=0; $i<sizeof($_POST['quantity_article']); $i++) {
            $quantity   = $_POST['quantity_article'][$i];

            $articleObj = new ArticlesModel();
            $article    = $articleObj->consultArticleById($_POST['art_id'][$i]);
            $ar_code    = $article[0]['ar_code'];

            $price      = $_POST['PriceNormal'][$i] <= 0 ? 1 : $_POST['PriceNormal'][$i];

            array_push($documentLines, [
                "ItemCode"          => $ar_code,
                "Quantity"          => $quantity,
                "LineTotal"         => ($price * $quantity),
                "TaxCode"           => "IVAG19",
                "WarehouseCode"     => $warehouseData[0]['wh_code'],
                "DiscountPercent"   => "0",
                "BaseType"          => "-1",
                "BaseEntry"         => "",
                "BaseLine"          => $i
            ]);
        }

        $nitCompany = isset($companyData[0]['c_num_nit']) ? str_replace('.', '', $companyData[0]['c_num_nit']) : '';

        if (strpos($nitCompany, '-') !== false) {
            $cardCode   = explode('-', $nitCompany)[0];
        } else {
            $cardCode   = $nitCompany;
        }

        $data = [
            'CardCode'      => 'C'.$cardCode,
            'CardName'      => $companyData[0]['c_name'],
            'DocDate'       => date('Ymd'),
            'TaxDate'       => date('Ymd'),
            'DocDueDate'    => $docDueDate,
            'NumAtCard'     => $quo_id,
            'Comments'      => $_POST['comments'],
            'U_ACS_PCID'    => $quo_id,
            'DocumentLines' => $documentLines
        ];

        $encodedData = json_encode($data);

        $reflex = new ReflexController();
        $reflex->createQuote($encodedData);

        redirect(generateUrl("Quote", "Quote", "ViewQuotes"));
    }

    public function AddArticlesAjax()
    {
        $idArticle  = $_POST['id_article'];
        $quantity   = $_POST['quantity_articles'];


        $objArticle = new ArticlesModel();
        $article    = $objArticle->consultArticleById($idArticle);
        $idCategory = $article[0]['cat_id'];


        $objCategory    = new CategoryModel();
        $category       = $objCategory->consultCategoryById($idCategory);
        $nameCategory   = $category[0]['cat_name'] ?? 'Sin Categoría';
        

        $objPrice   = new PricesModel();
        $price      = $objPrice->consultPriceById($idArticle);


        $objDiscount        = new Customer_discountsModel();
        $discountCompany    = $objDiscount->consultDiscountsByColumn('c_id', $_SESSION['IdCompany']);

        $priceDiscount      = null;
        $discountPercentage = null;
        $arryArticles       = array();
        $arrayCategories    = array();
        $arraySubcategories = array();
        $discountPercentajeOrPrice = 'No aplica';

        if (!empty($discountCompany)) {
            $objGroups  = new GroupsModel();
            $group      = $objGroups->consultGroupById($discountCompany[0]['gp_id']);

            foreach ($discountCompany as $key) {
                $arryArticles[]         = $key['ar_id'];
                $arrayCategories[]      = $key['cat_id'];
                $arraySubcategories[]   = $key['sbcat_id'];
            }

            $priceDiscount      = $discountCompany[0]['price_discount'];
            $discountPercentage = $group[0]['gp_discount_percentage'];

            if (!empty($discountPercentage)) {
                $discountPercentajeOrPrice = $discountPercentage . '%';
            }

            if (!empty($priceDiscount)) {
                $discountPercentajeOrPrice = $priceDiscount . '$';
            }
        }

        foreach ($article as $ar) {
            $price  = $price[0]['p_value'] ?? 0;

            $discountedPrice    = $this->verifyDiscount($ar['ar_id'], $ar['cat_id'], $ar['sbcat_id'], $arryArticles, $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $price);
            $subtotal           = $discountedPrice * $quantity;

            echo '<tr>
                    <td class="ar_id_'.$ar['ar_id'].'">' . $ar['ar_id'] . '</td>
                    <td> '. $ar['ar_name'] . '</td>
                    <td>' . $nameCategory . '</td>
                    <td>
                        <input type="number" class="form-control quantityArt" name="quantity_article[]" min="1" value="' . $quantity . '">
                        <input type="hidden"  name="art_id[]" value="' . $ar['ar_id'] . '">
                    </td>
                    <td class="price">$' . $price . '<input type="hidden" name="PriceNormal[]" value="' . $price . '"></td>
                    <td>' . $discountPercentajeOrPrice . '<input type="hidden" name="discountPercentajeOrPrice[]" value=' . $discountPercentajeOrPrice . '></td>
                    <td class="discount">$' . $discountedPrice . '<input type="hidden" name="discountPrice[]" value="' . $discountedPrice . '" ></td>
                    <td class="subtotal">$' . $subtotal . '</td>
                    <td><button class="btn btn-danger delete-row"><i class="fa-solid fa-square-xmark"></i></button></td>
                 </tr>';
        }
    }

    // verify discount of article include in the quote
    public function verifyDiscount($idArt, $cat_id_Art, $sbcat_id, $arryArticles, $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $price)
    {
        if (in_array($idArt, $arryArticles) || in_array($cat_id_Art, $arrayCategories) || in_array($sbcat_id, $arraySubcategories)) {
            // The ID has a discount
            if (!empty($discountPercentage)) {
                // Apply discount based on $discountPercentage

                $discountedPrice = $price - ($price * $discountPercentage / 100);
                return $discountedPrice;
            }

            if (!empty($priceDiscount)) {
                // Apply discount based on $priceDiscount
                $discountedPrice = $price - $priceDiscount;
                return $discountedPrice;
            }
        } else {
            // The ID does not have a discount, return the original price
            return $price;
        }
    }

    // MODAL DINAMICA QUE TRAE LOS VALORES DEPENDIENDO LOS FILTROS 
    public function consultGridArticles()
    {
        $obj = new ArticlesModel();
        $objColor = new ColorsModel();
        $articles = $obj->consultArticles();
        foreach ($articles as &$arti) {
            $color = $objColor->consultColorByID($arti['color_id']);
            $arti['color'] = $color;
        }
        $articlesForRows = $_GET['order'];
        $count = 0;

        if ($articlesForRows == 'table') {
            include_once '../app/Views/quote/quoteArticlesTable.php';
        } else {
            foreach ($articles as $art) {
                if ($count % $articlesForRows == 0) {
                    echo '<div class="row mt-3">';
                }
?>
                <div class="col-md-<?php echo 12 / $articlesForRows ?> roll-in-blurred-left cardsDiv">
                    <div class="card">
                        <img src="<?= $art['ar_img_url'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $art['ar_name'] ?></h5>
                            <p class="card-text"><b>Descripción: </b><?= $art['ar_desc'] ?></p>
                            <p class="card-text"><b>Peso: </b><?= $art['ar_measurement_value'] ?>kg</p>
                            <?php foreach ($art['color'] as $color) : ?>
                                <p class="card-text"><b>Color: </b><?= $color['color_name'] ?></p>
                            <?php endforeach; ?>
                            <p><b>Cantidad:</b>
                                <input type="number" class="mt-2 mb-2 quantityinput form form-control" name="quantity" min="1" id="">
                                <button data-url="<?= Helpers\generateUrl("Quote", "Quote", "AddArticlesAjax", [], "ajax"); ?>" value="<?= $art['ar_id'] ?>" id="addArticles" class="btn btn-outline-primary">Añadir
                                    articulo</button>
                            </p>
                        </div>
                    </div>
                </div>
<?php
                $count++;
                if ($count % $articlesForRows == 0) {
                    echo '</div>';
                }
            }
            if ($count % $articlesForRows != 0) {
                echo '</div>';
            }
        }
    }


    public function ViewModalAddFields()
    {
        include_once '../app/Views/quote/ModalAddFields.php';
    }
}
?>