<?php
require '../vendor/autoload.php';
use Models\Articles\ArticlesModel;
use Models\Company\CompanyModel;
use Models\Groups\GroupsModel;
use Models\Quote\QuoteModel;
use Models\Order\OrderModel;
use Models\JWT\JWTModel;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Comprobar si la variable de entorno JWT_SECRET_KEY está definida y no está vacía

function authenticateMiddleware() {
    $headers = apache_request_headers();
    $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;
    // Imprimir el valor del encabezado "Authorization" en los registros del servidor web
    // Esto te permitirá verificar si el encabezado está llegando correctamente
    error_log("Authorization Header: " . $token);
    if (!$token) {
        // El token no está presente, denegar acceso
        Flight::halt(401, 'No autorizado ');
    }
    // Verificar que el token comience con "Bearer "
    if (strpos($token, 'Bearer ') !== 0) {
        Flight::halt(401, 'No autorizado ');
    }

    // Extraer el token real eliminando el prefijo "Bearer "
    $token = substr($token, 7);

    $headersCopy = $headers; // Hacer una copia del arreglo $headers
    $jwtModel = new JWTModel($_ENV['JWT_SECRET_KEY']);

    $decodedToken = $jwtModel->verifyToken($token); // Pasar la copia en lugar del original
    if (!$decodedToken) {
        // El token no es válido o ha expirado, denegar acceso
        Flight::halt(401, 'No autorizado ');
    }

    // Puedes acceder al ID de usuario desde el token decodificado
    $userId = $decodedToken->user_id;

    // Puedes almacenar el ID de usuario para uso futuro si es necesario
    // Por ejemplo, puedes agregarlo al objeto de la solicitud (request object) o a la instancia de Flight::app()
    Flight::app()->userId = $userId;
}




// ROUTES OF QUOTES
Flight::route('GET /api/quotes', function(){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new QuoteModel();
    $quotes=$obj->consultQuotesClients();
    Flight::json($quotes);
});

Flight::route('GET /api/quotes/@id', function($id){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new QuoteModel;
    $quote = $obj->consultQuoteById($id);
    
    if ($quote) {
        // Consultar los artículos asociados a la cotización
        $articles = $obj->consultArticlesOfTheQuote($id);
        $quote['articles'] = $articles;

        Flight::json($quote);
    } else {
        Flight::halt(404, 'Quote not found');
    }
});


// ROUTES OF ORDERS
Flight::route('GET /api/orders', function() {
    authenticateMiddleware(); // No es necesario pasar  aquí
    $obj = new OrderModel(); 
    $orders = $obj->consultOrdersClients();
    Flight::json($orders);
});



Flight::route('GET /api/orders/@id', function($id){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new OrderModel();
    $order = $obj->consultOrderById($id);

    if ($order) {
        Flight::json($order);
    } else {
        Flight::halt(404, 'Order not found');
    }
});



// ROUTES OF ARTICLES
Flight::route('GET /api/articles', function(){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new ArticlesModel();
    $articles=$obj->consultArticles();
    Flight::json($articles);
});

Flight::route('GET /api/articles/@id', function($id){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new ArticlesModel();
    $article = $obj->consultArticleById($id);
    
    if ($article) {
        Flight::json($article);
    } else {
        Flight::halt(404, 'Article not found');
    }
});



// ROUTES COMPANIES
Flight::route('GET /api/companies', function(){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new CompanyModel();
    $companies=$obj->consultCompanies();
    Flight::json($companies);
});

Flight::route('GET /api/companies/@id', function($id){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new CompanyModel();
    $company = $obj->ConsultCompany($id);
    if ($company) {
        Flight::json($company);
    } else {
        Flight::halt(404, 'Company not found');
    }
});

//ROUTES GROUPS
Flight::route('GET /api/list_prices', function(){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new GroupsModel();
    $list_prices=$obj->consultGroups();
    Flight::json($list_prices);
});

Flight::route('GET /api/list_prices/@id', function($id){
     authenticateMiddleware(); // Agrega esta línea para proteger la ruta
    $obj= new GroupsModel();
    $list_prices=$obj->consultGroupById($id);
    Flight::json($list_prices);
});


Flight::start();

?>