<?php
include_once '../../../config/helpers.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Validación</title>
    <link href="../../../public/css/codeValidation.css" rel="stylesheet">
</head>
<body>
    
    <div id="backImg">
    </div>

    <div class="container">
        <h1>Validar Codigo</h1>
        <form action='' method="post">
            <div class="form-control">
                <input name="usu_contraseña" type="password" required>
                <label for="">Ingresa el codigo de verificación</label>
            </div>
            <button class="btn" type="submit">Enviar</button>
            <p class="text">No tienes cuenta?
                <a href="../Register/Register.php">Crear una cuenta</a>
            </p>
        </form>
    </div>

 
    
    <script src="../../../public/js/login.js"></script>
</body>
</html>