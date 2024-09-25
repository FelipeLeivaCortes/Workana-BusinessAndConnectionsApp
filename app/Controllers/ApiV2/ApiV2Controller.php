<?php
namespace Controller\ApiV2;

class ApiV2Controller {
    public function getQuotes() {
        // Obtener las cotizaciones desde la base de datos o cualquier otra fuente de datos
        $quotes = 'hola';// Obtener las cotizaciones
    
        // Construir la respuesta en formato JSON
        $response = json_encode($quotes);
    
        // Establecer las cabeceras para indicar que la respuesta es JSON
        header('Content-Type: application/json');
    
        // Enviar la respuesta al cliente
        echo $response;
    }
    
}

?>