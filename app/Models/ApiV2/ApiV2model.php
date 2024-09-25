<?php
namespace Models\ApiV2;

use Models\MasterModel;
use Models\JWT\JWTModel;

class ApiV2Model extends MasterModel
{
    private $jwtModel;

    public function __construct()
    {
        $this->jwtModel = new JWTModel('WrE^Rk157%8h');
    }

    public function validateToken($token)
    {
        return $this->jwtModel->verifyToken($token);
    }

    public function prueba(){
        echo 'hola';
    }


    public function updateProduct()
    {
        // Validar el token antes de realizar la actualización del producto
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        
        if (!$this->validateToken($token)) {
            // Manejar el error de token inválido o no proporcionado
            return 'Token inválido o no proporcionado';
        }

        // Resto de la lógica para actualizar el producto

        // Ejemplo de respuesta con los datos del producto actualizado
        return 'Producto actualizado correctamente';
    }

    public function getProduct()
    {
        // Validar el token antes de obtener el producto
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        
        if (!$this->validateToken($token)) {
            // Manejar el error de token inválido o no proporcionado
            return 'Token inválido o no proporcionado';
        }

        // Resto de la lógica para obtener el producto

        // Ejemplo de respuesta con los datos del producto
        return 'Datos del producto';
    }

   
}
