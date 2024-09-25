<?php
include_once '../config/helpers.php';
use function Helpers\generateUrl;
    // Evitar caché en el navegador
    header("Cache-Control: private, no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Evitar caché en proxies compartidos
    header("Cache-Control: no-store, no-cache, must-revalidate, proxy-revalidate");

    // Evitar caché en versiones antiguas de Internet Explorer
    header("Cache-Control: post-check=0, pre-check=0", false);

    // Cabecera de Vary
    header("Vary: *");

    // Cabecera de Last-Modified
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    // Cabecera de ETag
    header("ETag: " . md5(rand()));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio Sesión</title>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link href="css/login.css" rel="stylesheet">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="margintop">

    </div>
    <div id="backImg">
    </div>
    <div class="container">
        <div class="ContImgtop">
            <img src="img/Logo-Portal.png" alt="" id="imgTop">
        </div>
        <h1 class="codediv">Código de validación</h1>
        <h1 class="hide">Iniciar sesión</h1>
        <form action="<?= generateUrl("Access","Access","UserAccess",[],"ajax"); ?>" method="post" id="loginForm">
            <div class="hide">
                
                <div class="form-control">
                    <input name="u_email" id="u_email" type="text" required>
                    <label for="u_email">Correo electrónico</label>
                    <span class="error-message"></span>
                </div>
                <div class="form-control">
                    <input name="u_pass" id="u_pass" type="password" required>
                    <label for="u_pass">Contraseña</label>
                    <span class="error-message"></span>
                </div>
            </div>
            <div class="form-control codediv">
                <input name="u_code" id="u_code" type="password" required>
                <label for="u_code">Ingresa el código de verificación</label>
                <span class="error-message"></span>
            </div>
            <button id="emailCode" data-url="<?= generateUrl("Access","Access","EmailCode",[],"ajax"); ?>"
                class="btn hide" type="button">Enviar</button>
            
            
                <button class="btn codediv" type="submit">Enviar</button>
            
            <p class="text">¿No tienes cuenta?
                <a href="<?= generateUrl("Access","Access","RegisterView",[],"ajax"); ?>">Crear una cuenta</a>
            </p>
        </form>
    </div>
    <div class="marginbottom"><p>Copyright businessandconnection.com</p></div>
    <script src="js/jquery-3.6.4.min.js" defer></script>
    <!-- <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="js/login.js" defer></script>
    <script src="js/validation/validationLogin.js" defer></script>
</body>

</html>