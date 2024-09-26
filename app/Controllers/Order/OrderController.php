<?php
require '../vendor/autoload.php';

use Models\Order\OrderModel;
use Models\Articles\ArticlesModel;
use Models\Pdf\PdfModel;
use Models\Stock\StockModel;
use Models\Prices\PricesModel;
use Models\Category\CategoryModel;
use Models\Company\CompanyModel;
use Models\Colors\ColorsModel;
use Models\Customer_discounts\Customer_discountsModel;
use Models\Customer_payment_method\Customer_payment_methodModel;
use Models\Graphics\GraphicsModel;
use Models\Groups\GroupsModel;
use Models\Mail\MailModel;
use Models\OrderStatus\OrderStatusModel;
use Models\Template\TemplateModel;
use Models\User\UserModel;
use Models\Sellers\SellersModel;
use Models\MethodsPay\MethodsPayModel;
use Models\Quote\QuoteModel;
use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

use ThirdParty\ReflexController;

class OrderController
{
    public function modalStatusOrder()
    {
        $obj = new OrderStatusModel();
        $states = $obj->consultOrderStatus();

        $objOrder = new OrderModel();
        $order_id = $_POST['order_id'];
        $c_id = $_POST['c_id'];
        $order = $objOrder->consultOrderById($order_id);
        //  dd($order);
        include_once "../app/Views/order/ModalStatusOrder.php";
    }

    public function updateStatesOrder()
    {
        // dd($_POST);
        $order_id = $_POST['order_id'];
        $state_order = $_POST['state_order'];
        $c_id = $_POST['c_id'];
        // update state of the order
        $obj = new OrderModel();
        $obj->updateStatesOrder($order_id, $state_order);

        // update state_order_id detail_seller_order
        $obj = new OrderModel();
        $obj->updateStateOrderDetail_seller($order_id, $state_order);
        // inf company
        $objCompany = new CompanyModel();
        $company = $objCompany->ConsultCompany($c_id);
        // emails of company
        $objUser = new UserModel();
        $emails = $objUser->consultEmailsOfTheCompany($c_id);
        // states of order
        $states = ($state_order == '6') ? true : false;
        // send emails
        $mail = new MailModel();
        foreach ($emails as $e) {
            $template = TemplateModel::TemplateNotificationOrderStatus($company[0]['c_name'], $order_id, $states);
            $mail->DataEmail($template, $e, 'Notificacion de pedido');
        }
        redirect(generateUrl("Order", "Order", "ordersCompanies"));
    }

    public function ViewCreateOrder()
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

        $orderAddress = '';
        foreach ($shipping_address as $key) {
            $orderAddress .= $key['c_shippingStreet'] . ', ' . $key['c_shippingApartament'] . ', ' . $key['c_shippingCountry'] . ', ' . $key['c_shippingCity'] . ', ' . $key['c_shippingState'] . ', ' . $key['c_shippingPostalcode'];
        }
        $obj = new SellersModel();
        $seller = $obj->ConsultSellerByIdOfCompany($_SESSION['IdCompany']);
        include_once "../app/Views/order/orderCreate.php";
    }

    public function viewDetaillsOrder()
    {
        $objOrder = new OrderModel();
        $id = $_GET['order_id'];


        $order = $objOrder->consultOrderById($id);
        // dd($order);
        // get info user and company
        $ObjUser = new UserModel();
        $user = $ObjUser->getUserInfoById($order[0]['u_id']);
        $objCompany = new CompanyModel();
        $company = $objCompany->ConsultCompany($user['c_id']);


        $obj = new CompanyModel();
        $shipping_address = $obj->ConsultCompany($user['c_id']);
        $objCustomerPaymentMethods = new Customer_payment_methodModel();
        $payment_methods = $objCustomerPaymentMethods->getPaymentMethodsByCustomerId($user['c_id']);
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

        $orderAddress = '';
        foreach ($shipping_address as $key) {
            $orderAddress .= $key['c_shippingStreet'] . ', ' . $key['c_shippingApartament'] . ', ' . $key['c_shippingCountry'] . ', ' . $key['c_shippingCity'] . ', ' . $key['c_shippingState'] . ', ' . $key['c_shippingPostalcode'];
        }

        // dd($order);
        $orderAddress = '';
        foreach ($shipping_address as $key) {
            $orderAddress .= $key['c_shippingStreet'] . ', ' . $key['c_shippingApartament'] . ', ' . $key['c_shippingCountry'] . ', ' . $key['c_shippingCity'] . ', ' . $key['c_shippingState'] . ', ' . $key['c_shippingPostalcode'];
        }

        foreach ($order as &$o) {
            $o['order_articles'] = $objOrder->consultArticlesOfTheOrder($o['order_id']);
        }

        $obj = new SellersModel();
        $seller = $obj->ConsultSellerByIdOfCompany($user['c_id']);

        $articlesHmtl = '';
        foreach ($order as $ord) {


            foreach ($ord['order_articles'] as $art) {
                // dd($art['ar_id'],$art['quoart_quantity']);
                $article = $this->articlesOrderview($art['ar_id'], $art['orderart_quantity'], $user['c_id']);
                $articlesHmtl .= $article;
            }
        }
        include_once '../app/Views/order/viewDetaillsOrder.php';
    }

    public function articlesOrderview($idArticle, $quantity, $c_id)
    {
        // GET INFO ARTICLE
        $objArticle = new ArticlesModel();
        $article = $objArticle->consultArticleById($idArticle);
        $idCategory = $article[0]['cat_id'];
        //GET INFO CATEGORY
        //CONSULT DISCOUNT CATEGORY
        $objCategory = new CategoryModel();
        $category = $objCategory->consultCategoryById($idCategory);
        $nameCategory = $category[0]['cat_name'];
        //GET INFO PRICE ARTICLE
        $objPrice = new PricesModel();
        $price = $objPrice->consultPriceById($idArticle);
        //CONSULT DISCOUNT ARTICLE
        //CHECK IF THE COMPANY EXISTS IN THE DISCOUNT GROUPS
        $objDiscount = new Customer_discountsModel();
        $discountCompany = $objDiscount->consultDiscountsByColumn('c_id', $c_id);

        $priceDiscount = null;
        $discountPercentage = null;
        $arryArticles = array();
        $arrayCategories = array();
        $arraySubcategories = array();
        $discountPercentajeOrPrice = 'No aplica';

        if (!empty($discountCompany)) {
            //CONSULT CATEGORIES,SUBCATEGORIES,ARTICLES AND DISCOUNT GROUP OF DISCOUNT
            $objGroups = new GroupsModel();
            $group = $objGroups->consultGroupById($discountCompany[0]['gp_id']);
            foreach ($discountCompany as $key) {
                $arryArticles[] = $key['ar_id'];
                $arrayCategories[] = $key['cat_id'];
                $arraySubcategories[] = $key['sbcat_id'];
            }

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

        $PriceWithDiscount = 0;
        $html = '';

        foreach ($article as $ar) {
            $discountedPrice = $this->verifyDiscount($ar['ar_id'], $ar['cat_id'], $ar['sbcat_id'], $arryArticles, $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $price[0]['p_value']);
            $subtotal = $discountedPrice * $quantity;

            $html .= '<tr>
                        <td> <i class="fa-solid fa-file"></i>' . $ar['ar_name'] . '</td>
                        <td>' . $nameCategory . '</td>
                        <td>
                            <input readonly type="number" class="form-control quantityArt" name="quantity_article[]" min="1" value="' . $quantity . '">
                            <input  readonly type="hidden"  name="art_id[]" value="' . $ar['ar_id'] . '">
                        </td>
                        <td class="price">' . $price[0]['p_value'] . '<input readonly type="hidden" name="PriceNormal[]" value="' . $price[0]['p_value'] . '"></td>
                        <td>' . $discountPercentajeOrPrice . '<input readonly type="hidden" name="discountPercentajeOrPrice[]" value=' . $discountPercentajeOrPrice . '></td>
                        <td class="discount">' . $discountedPrice . '<input readonly type="hidden" name="discountPrice[]" value="' . $discountedPrice . '" ></td>
                        <td class="subtotal">$' . $subtotal . '</td>
                    </tr>';
        }

        return $html;
    }

    public function GenerateOrderSinceQuote()
    {
        $objQuote   = new QuoteModel();
        $id         = $_GET['quo_id'];
        $quote      = $objQuote->consultQuoteById($id);

        if ($quote[0]['quote_state_id'] != 1) {
            redirect(generateUrl("Quote", "Quote", "ViewQuotes"));
        } else {
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

            $orderAddress = '';
            foreach ($shipping_address as $key) {
                $orderAddress .= $key['c_shippingStreet'] . ', ' . $key['c_shippingApartament'] . ', ' . $key['c_shippingCountry'] . ', ' . $key['c_shippingCity'] . ', ' . $key['c_shippingState'] . ', ' . $key['c_shippingPostalcode'];
            }

            $orderAddress = '';
            foreach ($shipping_address as $key) {
                $orderAddress .= $key['c_shippingStreet'] . ', ' . $key['c_shippingApartament'] . ', ' . $key['c_shippingCountry'] . ', ' . $key['c_shippingCity'] . ', ' . $key['c_shippingState'] . ', ' . $key['c_shippingPostalcode'];
            }

            foreach ($quote as &$q) {
                $q['quote_articles'] = $objQuote->consultArticlesOfTheQuote($q['quo_id']);
            }

            $obj    = new SellersModel();
            $seller = $obj->ConsultSellerByIdOfCompany($_SESSION['IdCompany']);

            $articlesHmtl = '';

            foreach ($quote as $quo) {
                // dd($quo);

                foreach ($quo['quote_articles'] as $art) {
                    // dd($art['ar_id'],$art['quoart_quantity']);
                    $article = $this->articlesOrderSinceQuote($art['ar_id'], $art['quoart_quantity']);
                    $articlesHmtl .= $article;
                }
            }

            include_once '../app/Views/quote/orderSinceQuote.php';
        }
    }

    public function articlesOrderSinceQuote($idArticle, $quantity)
    {

        // GET INFO ARTICLE
        $objArticle = new ArticlesModel();

        $article = $objArticle->consultArticleById($idArticle);

        $idCategory = $article[0]['cat_id'];
        //GET INFO CATEGORY
        //CONSULT DISCOUNT CATEGORY
        $objCategory = new CategoryModel();
        $category = $objCategory->consultCategoryById($idCategory);
        $nameCategory = $category[0]['cat_name'];
        //GET INFO PRICE ARTICLE
        $objPrice = new PricesModel();
        $price = $objPrice->consultPriceById($idArticle);
        //CONSULT DISCOUNT ARTICLE
        //CHECK IF THE COMPANY EXISTS IN THE DISCOUNT GROUPS
        $objDiscount = new Customer_discountsModel();
        $discountCompany = $objDiscount->consultDiscountsByColumn('c_id', $_SESSION['IdCompany']);

        $priceDiscount = null;
        $discountPercentage = null;
        $arryArticles = array();
        $arrayCategories = array();
        $arraySubcategories = array();
        $discountPercentajeOrPrice = 'No aplica';

        if (!empty($discountCompany)) {
            //CONSULT CATEGORIES,SUBCATEGORIES,ARTICLES AND DISCOUNT GROUP OF DISCOUNT
            $objGroups = new GroupsModel();
            $group = $objGroups->consultGroupById($discountCompany[0]['gp_id']);
            foreach ($discountCompany as $key) {
                $arryArticles[] = $key['ar_id'];
                $arrayCategories[] = $key['cat_id'];
                $arraySubcategories[] = $key['sbcat_id'];
            }

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

        $PriceWithDiscount = 0;
        $html = '';

        foreach ($article as $ar) {
            $discountedPrice = $this->verifyDiscount($ar['ar_id'], $ar['cat_id'], $ar['sbcat_id'], $arryArticles, $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $price[0]['p_value']);
            $subtotal = $discountedPrice * $quantity;

            $html .= '<tr>
                        <td> <i class="fa-solid fa-file"></i>' . $ar['ar_name'] . '</td>
                        <td>' . $nameCategory . '</td>
                        <td>
                            <input type="number" class="form-control quantityArt" name="quantity_article[]" min="1" value="' . $quantity . '">
                            <input type="hidden"  name="art_id[]" value="' . $ar['ar_id'] . '">
                        </td>
                        <td class="price">' . $price[0]['p_value'] . '<input type="hidden" name="PriceNormal[]" value="' . $price[0]['p_value'] . '"></td>
                        <td>' . $discountPercentajeOrPrice . '<input type="hidden" name="discountPercentajeOrPrice[]" value=' . $discountPercentajeOrPrice . '></td>
                        <td class="discount">' . $discountedPrice . '<input type="hidden" name="discountPrice[]" value="' . $discountedPrice . '" ></td>
                        <td class="subtotal">$' . $subtotal . '</td>
                        <td><button class="btn btn-danger delete-row"><i class="fa-solid fa-square-xmark"></i></button></td>
                    </tr>';
        }

        return $html;
    }

    public function ordersCompanies()
    {
        $obj = new OrderModel();
        $orders = $obj->consultOrdersClients();
        include_once '../app/Views/order/ordersConsultCompanies.php';
    }

    public function ViewOrders()
    {
        $obj = new OrderModel();
        $orders = $obj->consultOrders();
        include_once "../app/Views/order/orderConsult.php";
    }

    public function CreateOrder()
    {
        $objArticles = new ArticlesModel();
        $objColor = new ColorsModel();
        $articles = $objArticles->consultArticles();
        foreach ($articles as &$arti) {
            $color = $objColor->consultColorByID($arti['color_id']);
            $arti['color'] = $color;
        }
        include_once "../app/Views/order/orderModal.php";
    }

    /**
     * Esta función se encarga de generar una nueva órden de venta.
     */
    public function pdfOrder()
    {
        $objOrder                   = new OrderModel();
        $objSellerOrder             = new OrderModel();
        $name                       = $_POST['name'];
        $company                    = $_POST['company'];
        $email                      = $_POST['email'];
        $phone                      = $_POST['phone'];
        $payment_method             = $_POST['payment_method'];
        $address_shipping           = $_POST['address_shipping'];
        $comments                   = $_POST['comments'];
        $subtotalOrderInput         = $_POST['subtotalOrderInput'];
        $taxesOrderInput            = $_POST['taxesOrderInput'];
        $totalOrderInput            = $_POST['totalOrderInput'];
        $quantity_article           = $_POST['quantity_article'];
        $PriceNormal                = $_POST['PriceNormal'];
        $art_id                     = $_POST['art_id'];
        $PercentajeOrPrice          = $_POST['discountPercentajeOrPrice'];
        $discountPrice              = $_POST['discountPrice'];
        $id_seller                  = isset($_POST['s_id']) ? $_POST['s_id'] : 1;
        $discountOrderInput         = $_POST['discountOrderInput'] ?? 0;
        $additionalCostsOrderInput  = $_POST['additionalCostsOrderInput'] ?? 0;

        // Insert the basic data into the "orders" table
        $objOrder->insertOrder(
            $name,
            'a',
            $payment_method,
            $company,
            $address_shipping,
            $email,
            $phone,
            $comments,
            $_SESSION['UserNumDocument'],
            $subtotalOrderInput,
            $taxesOrderInput,
            $totalOrderInput,
            null,
            $_SESSION['idUser'],
            null,
            $id_seller,
            $discountOrderInput,
            $additionalCostsOrderInput
        );

        //get last id
        $order_id = $objOrder->getLastId('order', 'order_id');

        //Insertar detail_seller_order
        $objSellerOrder->insertDetailSellerOrder(
            $order_id,
            $id_seller,
            $_SESSION['idUser'],
            $totalOrderInput,
            null
        );

        foreach ($art_id as $key => $article_id) {
            $quantity = $quantity_article[$key];
            $discountType = $PercentajeOrPrice[$key];
            $discountedPrice = $discountPrice[$key];
            // Insert the basic data into the "Order and articles" table
            $objOrder->insertOrderArticle($order_id, $article_id, $quantity, $PriceNormal[$key], $discountType, $discountedPrice);
        }

        $articles = $_POST['art_id']; //ARRAY DE ID ARTICLES
        $quantity = $_POST['quantity_article']; //ARRAY QUANTITY OF ARTICLES
        if (isset($_POST['fieldName']) && isset($_POST['fieldValue'])) {
            $fieldName = $_POST['fieldName']; //ARRAY OF FIELDS NAME
            $fieldValue = $_POST['fieldValue']; //ARRAY OF FIELDS VALUE
        } else {
            $fieldName = NULL; //ARRAY OF FIELDS NAME
            $fieldValue = NULL; //ARRAY OF FIELDS VALUE
        }
        //DATA OF  ARTICLE
        $objArticle = new ArticlesModel();
        //PRICE OF ARTICLE
        $objPrice = new PricesModel();
        $articleArray = array();
        //CONSULT DISCOUNT ARTICLE
        //CHECK IF THE COMPANY EXISTS IN THE DISCOUNT GROUPS
        $objDiscount = new Customer_discountsModel();
        $discountCompany = $objDiscount->consultDiscountsByColumn('c_id', $_SESSION['IdCompany']);
        $priceDiscount = null;
        $discountPercentage = null;
        $arrayArticles = array();
        $arrayCategories = array();
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
            $article['price'] = $price['p_value'] = $objPrice->consultPriceById($ar_id);


            $discountedPrice = $this->verifyDiscount($article[0]['ar_id'], $article[0]['cat_id'], $article[0]['sbcat_id'], $arrayArticles, $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $article['price'][0]['p_value']);
            $article['pricePre'] = $article['price'][0]['p_value'];
            $article['price'] = $discountedPrice;
            $article['discountPercentajeOrPrice'] = $discountPercentajeOrPrice;
            $article['quantity'] = $quantity[$key];
            $articleArray[] = $article;
        }

        //consultar la ultima orden insertada
        $objOrder = new OrderModel();

        $objconsultOrderyId = $objOrder->consultOrderById($order_id);
        $orderDiscountTotal = $objconsultOrderyId[0]['order_discount_total'];
        $orderAdditionCost  = $objconsultOrderyId[0]['order_addition_cost'];

        $template   = PdfModel::templateOrderPdf($articleArray, $fieldName, $fieldValue, $orderDiscountTotal, $orderAdditionCost);
        $pdfModel   = new PdfModel();
        $idOrder    = $objOrder->getLastId('order', 'order_id');
        $filePath   = $pdfModel->generatePdf($template, $idOrder, 'orders');

        $objOrder->updateField('`order`', 'order_id', $idOrder, 'order_url_document', $filePath);

        if (isset($_POST['fieldName'])) {
            $fieldNames = $_POST['fieldName'];
            $fieldValues = $_POST['fieldValue'];
            for ($i = 0; $i <  count($fieldNames); $i++) {
                $objOrder->insertExtraAttributeOrder($fieldNames[$i], $fieldValues[$i], $order_id);
            }
        }

        if (isset($_FILES['fieldValue'])) {
            $fileCount = count($_FILES['fieldValue']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $_FILES['fieldValue']['name'][$i];
                $fileTmpName = $_FILES['fieldValue']['tmp_name'][$i];

                // Definir la ubicación de destino para el archivo
                $destination = 'uploads/Orders/' . $order_id . '/';

                // Verificar si la carpeta de destino existe
                if (!is_dir($destination)) {
                    // La carpeta de destino no existe, intenta crearla
                    if (!mkdir($destination, 0755, true)) {
                        // No se pudo crear la carpeta, muestra un mensaje de error y detén el proceso
                        echo "No se pudo crear la carpeta de destino.";
                        return;
                    }
                }

                // Construir la ruta completa del archivo
                $filePath = $destination . $fileName;

                // Mover el archivo a la ubicación de destino
                if (move_uploaded_file($fileTmpName, $filePath)) {
                    echo "El archivo $fileName se ha subido correctamente.";
                    echo "Ruta completa del archivo: $filePath";
                    $objOrder->insertExtraAttributeOrder($fileName, $filePath, $order_id);
                } else {
                    echo "Ocurrió un error al mover el archivo $fileName.";
                }
            }
        }

        // UPDATE GRAPHICS COMPANY ORDERS
        $objGraphic = new GraphicsModel();
        $_SESSION['LimitCredit'] = $objGraphic->ConsultLimitCredit($_SESSION['IdCompany']);



        /**
         * INTEGRACIÓN COMUNICACIÓN API REFLEX
         */

         $objCompany     = new CompanyModel();
         $companyData    = $objCompany->consultCompanyByName($company);
 
         $fechaActual    = new DateTime();
         $fechaActual->modify('+3 days');
         $docDueDate     = $fechaActual->format('Ymd');  // Por defecto el documento expira en 3 dias
 
         $documentLines  = array();
 
         for ($i=0; $i<sizeof($_POST['quantity_article']); $i++) {
             array_push($documentLines, [
                 "ItemCode"          => $_POST['art_id'][$i],
                 "Quantity"          => $_POST['quantity_article'][$i],
                 "LineTotal"         => $_POST['PriceNormal'][$i],
                 "TaxCode"           => "IVA",
                 "WarehouseCode"     => "10",
                 "DiscountPercent"   => "0",
                 "BaseType"          => "-1",
                 "BaseEntry"         => "",
                 "BaseLine"          => ""
             ]);
         }
         
         $data = [
             'CardCode'      => 'C'.$companyData[0]['c_num_nit'],
             'CardName'      => $companyData[0]['c_name'],
             'DocDate'       => date('Ymd'),
             'TaxDate'       => date('Ymd'),
             'DocDueDate'    => $docDueDate,
             'NumAtCard'     => $order_id,
             'Comments'      => $_POST['comments'],
             'U_ACS_PCID'    => $order_id,
             'DocumentLines' => $documentLines
         ];
 
         $encodedData = json_encode($data);
 
         $reflex = new ReflexController();
         $reflex->createOrder($encodedData);



        redirect(generateUrl("Order", "Order", "ViewOrders"));
    }

    // MODAL DINAMICA QUE TRAE LOS VALORES DEPENDIENDO LOS FILTROS 
    public function AddArticlesAjax()
    {
        $idArticle = $_POST['id_article'];
        $quantity = $_POST['quantity_articles'];

        if (intval($quantity) < 1 ) {
            return false;
        }


        // GET INFO ARTICLE
        $objArticle = new ArticlesModel();
        $article = $objArticle->consultArticleById($idArticle);
        $idCategory = $article[0]['cat_id'];
        //GET INFO CATEGORY
        //CONSULT DISCOUNT CATEGORY
        $objCategory = new CategoryModel();
        $category = $objCategory->consultCategoryById($idCategory);
        $nameCategory = $category[0]['cat_name'];
        //GET INFO PRICE ARTICLE
        $objPrice = new PricesModel();
        $price = $objPrice->consultPriceById($idArticle);
        //CONSULT DISCOUNT ARTICLE
        //CHECK IF THE COMPANY EXISTS IN THE DISCOUNT GROUPS
        $objDiscount = new Customer_discountsModel();
        $discountCompany = $objDiscount->consultDiscountsByColumn('c_id', $_SESSION['IdCompany']);

        $priceDiscount = null;
        $discountPercentage = null;
        $arryArticles = array();
        $arrayCategories = array();
        $arraySubcategories = array();
        $discountPercentajeOrPrice = 'No aplica';

        if (!empty($discountCompany)) {
            //CONSULT CATEGORIES,SUBCATEGORIES,ARTICLES AND DISCOUNT GROUP OF DISCOUNT
            $objGroups = new GroupsModel();
            $group = $objGroups->consultGroupById($discountCompany[0]['gp_id']);
            foreach ($discountCompany as $key) {
                $arryArticles[] = $key['ar_id'];
                $arrayCategories[] = $key['cat_id'];
                $arraySubcategories[] = $key['sbcat_id'];
            }

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

        $PriceWithDiscount = 0;
        foreach ($article as $ar) {
            $discountedPrice = $this->verifyDiscount($ar['ar_id'], $ar['cat_id'], $ar['sbcat_id'], $arryArticles, $arrayCategories, $arraySubcategories, $priceDiscount, $discountPercentage, $price[0]['p_value']);
            $subtotal = $discountedPrice * $quantity;

            echo '<tr>
                    <td class="ar_id_' . $ar['ar_id'] . '">' . $ar['ar_id'] . '</td>
                    <td><i class="fa-solid fa-file"></i>' . $ar['ar_name'] . '</td>
                    <td>' . $nameCategory . '</td>
                    <td>
                        <input type="number" class="form-control quantityArt" name="quantity_article[]" min="1" value="' . $quantity . '">
                        <input type="hidden"  name="art_id[]" value="' . $ar['ar_id'] . '">
                    </td>
                    <td class="price">' . $price[0]['p_value'] . '<input type="hidden" name="PriceNormal[]" value="' . $price[0]['p_value'] . '"></td>
                    <td>' . $discountPercentajeOrPrice . '<input type="hidden" name="discountPercentajeOrPrice[]" value=' . $discountPercentajeOrPrice . '></td>
                    <td class="discount">' . $discountedPrice . '<input type="hidden" name="discountPrice[]" value="' . $discountedPrice . '" ></td>
                    <td class="subtotal">$' . $subtotal . '</td>
                    <td><button class="btn btn-danger delete-row"><i class="fa-solid fa-square-xmark"></i></button></td>
                 </tr>';
        }
    }
    // verify discount of article include in the order
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
            include_once '../app/Views/order/orderArticlesTable.php';
        } else {
            foreach ($articles as $art) {
                if ($count % $articlesForRows == 0) {
                    echo '<div class="row mt-3">';
                }
?>
                <div class="col-md-<?php echo 12 / $articlesForRows; ?> col-sm-6 col-12 mb-3 cardsDiv">
                    <div class="card h-100">
                        <img src="<?= $art['ar_img_url'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $art['ar_name'] ?></h5>
                            <p class="card-text"><b>Descripción: </b><?= $art['ar_desc'] ?></p>
                            <p class="card-text"><b>Peso: </b><?= $art['ar_measurement_value'] ?>kg</p>
                            <?php foreach ($art['color'] as $color) : ?>
                                <p class="card-text"><b>Color: </b><?= $color['color_name'] ?></p>
                            <?php endforeach; ?>
                            <p><b>Cantidad:</b>
                                <input type="number" class="mt-2 mb-2 quantityinput form-control" name="quantity" min="1" id="">
                                <button data-url="<?= Helpers\generateUrl("Order", "Order", "AddArticlesAjax", [], "ajax"); ?>" value="<?= $art['ar_id'] ?>" id="addArticles" class="btn btn-outline-primary">Añadir artículo
                                </button>
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
        include_once '../app/Views/order/ModalAddFields.php';
    }
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
}

?>