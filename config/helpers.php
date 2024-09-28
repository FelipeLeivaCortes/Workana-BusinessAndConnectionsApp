<?php

namespace Helpers;
session_start();
date_default_timezone_set('America/Bogota');
use Exception;

const DEFAULT_PAGE = "../public/index";

/**
 * Redirige a la URL especificada.
 *
 * @param string $url La URL a la que se redirige.
 * @throws Exception Si no se puede redirigir a la URL especificada.
 */
function redirect(string $url): void
{
    echo '<script>window.location.replace("' . $url . '");</script>';
    exit;
}

 
/**
 * Imprime la variable especificada de forma legible y detiene la ejecución del script.
 *
 * @param mixed $var La variable a imprimir.
 */
function dd($var): void
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}

/**
 * Genera la URL para el controlador y la acción especificados.
 *
 * @param string $module El módulo que contiene el controlador.
 * @param string $controller El controlador que contiene la acción.
 * @param string $action La acción que se va a ejecutar.
 * @param array $params Los parámetros adicionales que se van a incluir en la URL.
 * @param string|null $page La página que contiene la URL generada. Si no se especifica, se utiliza la página predeterminada.
 * @return string La URL generada.
 */
function generateUrl(string $module, string $controller, string $action, array $params = [], string $page = null): string
{
    $page = $page ?? DEFAULT_PAGE;
    $url = "$page.php?module=$module&controller=$controller&action=$action";

    foreach ($params as $key => $value) {
        $url .= "&$key=$value";
    }

    return $url;
}

function resolve(){
    //module:Carpetas que estan dentro del controlador
    //controlador: un archivo controller que esta dentro del modulo
    //funcion: es un metodo o funcion que está dentro del archivo controller

    // Obtenemos los valores de las variables $_GET y los sanitizamos
    $module = filter_var($_GET['module'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $controller = filter_var($_GET['controller'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $action = filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if (is_dir("../app/Controllers/$module")) {
        
        if (file_exists("../app/Controllers/$module/".$controller."Controller.php")) {
            
            include_once "../app/Controllers/$module/".$controller."Controller.php";

            $nameClass=$controller."Controller";
            $object=new $nameClass();

            if (method_exists($object,$action)) {
                $object->$action();
            }else{
                include_once '../app/Views/partials/page404.php';
                echo "La funcion o metodo especificado no existe";
            }

        }else{
            include_once '../app/Views/partials/page404.php';
            echo "El controlador especificado no existe";
        }
    }else{
        include_once '../app/Views/partials/page404.php';

         echo "El modulo especificado no existe";
    }

}

/**
 * Muestra una alerta con SweetAlert.
 *
 * @param string $title El título de la alerta.
 * @param string $text El texto de la alerta.
 * @param string $type El tipo de la alerta (success, error, warning, info).
 */
function showAlert(string $title, string $text, string $type = 'success'): void
{
    echo "<script>
        Swal.fire({
            title: '$title',
            text: '$text',
            icon: '$type',
            timer: 3000, // Duración de la alerta en milisegundos (ajusta según tus necesidades)
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    </script>";
}

function showAlertredirect(string $title, string $text, string $type, $url_redirect): void
{
    echo "<script>
        Swal.fire({
            title: '$title',
            text: '$text',
            icon: '$type',
            timer: 3000, // Duración de la alerta en milisegundos (ajusta según tus necesidades)
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: false,
        }).then((result) => {
            window.location.href = '$url_redirect';
        });
    </script>";
}

