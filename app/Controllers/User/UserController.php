<?php
require '../vendor/autoload.php';
use Models\User\UserModel;
use Models\Mail\MailModel;
use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

class UserController
{
 
    public function consultProfile(){
        
        include '../app/Views/profile/profile.php';
    }

    public function settings(){
        
        include '../app/Views/profile/settings.php';
    }
    
    public function changePassword(){
        $obj = new UserModel();
        $userId = $_SESSION['idUser'];
        $passwordActually = $_POST['contraseña_actual'];
        $passwordNew = $_POST['nueva_contraseña'];

        // Verificar si la contraseña actual coincide con la almacenada en la base de datos
        if ($obj->verifyUserPassword($userId, $passwordActually)) {
            // Cambiar la contraseña del usuario
            $obj->updateUserPassword($userId, $passwordNew);
            // Mostrar mensaje de éxito utilizando JavaScript
            echo '<script>alert("La contraseña ha sido actualizada correctamente.");</script>';
        } else {
            // Mostrar mensaje de error utilizando JavaScript
            echo '<script>alert("La contraseña actual no coincide con la almacenada en la base de datos.");</script>';
        }  
        redirect(generateUrl("User","User","settings")); 
    }
    
    public function updatePhoto() {
        if(isset($_FILES['photo'])) {
            $fileInfo = $_FILES['photo'];
    
            $uploadDir = "uploads/UserImg/" . $_SESSION['idUser'] . "/";
    
            // Verificar si el directorio de destino existe, si no, crearlo
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
    
            // Ruta del archivo de destino
            $destination = $uploadDir . "default.png";
            
            // Desactivar el almacenamiento en caché en el navegador
            header("Cache-Control: no-cache, must-revalidate"); 
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");



            // Mover el archivo temporal a la ubicación final
            if (move_uploaded_file($fileInfo['tmp_name'], $destination)) {
                // // El archivo se movió correctamente, aquí puedes realizar otras operaciones si es necesario
                // echo "success";
            } else {
                // // Hubo un error al mover el archivo
                // echo "error";
            }
        } else {
            echo "no_image";
        }
    }
    
}






?>