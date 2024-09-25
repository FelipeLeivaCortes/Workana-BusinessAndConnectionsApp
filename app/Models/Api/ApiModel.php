<?php

namespace Models\Api;

use Models\MasterModel;
use Automattic\WooCommerce\Client;
use function Helpers\dd;

class ApiModel extends MasterModel
{
    
    
    private $woocommerce;

    public function __construct()
    {
        $this->woocommerce = new Client(
            'https://demo.businessandconnection.com',
            'ck_de355c975476caed78ecd0966d1f3554abeabe86',
            'cs_831d55ee898ddc8f21787421d4863ec14a7682ff',
            [
                'version' => 'wc/v3',
            ]
        );
    }
    
    public function updateProduct($productId, $data)
    {
        try {
            $response = $this->woocommerce->put('products/' . $productId, $data);
            return true;
        } catch (\Exception $e) {
            // Manejo de errores en caso de que la actualización no se haya completado correctamente
            error_log("UpdateProduct:");
            error_log(print_r($e->getMessage(), true));
            return false;
        }
    }

    public function createProduct($data)
    {
        try {
            $response = $this->woocommerce->post('products', $data);
            
            $product = $response;
            
            if ($product && isset($product->id)) {
                $productId = $product->id;
                return $productId;
            } else {
                // Manejo de errores en caso de que no se pueda obtener el ID del producto                               
                return false;
            }
        } catch (\Exception $e) {
            // Manejo de errores en caso de que no se pueda crear el producto
            error_log("CreateProduct:"); 
            error_log(print_r($e->getMessage(), true));            
            return false;
        }
    }
    

    public function deleteProduct($productId)
    {
        try {
            $response = $this->woocommerce->delete('products/' . $productId);
            return true;
        } catch (\Exception $e) {
            // Manejo de errores en caso de que no se pueda eliminar el producto
            error_log(print_r($e->getMessage(), true));
            return false;
        }
    }
    
    public function getProduct($productId)
    {
        try {
            $data = $this->woocommerce->get('products/' . $productId);
            return $data;
        } catch (\Exception $e) {
            // Manejo de errores en caso de que no se pueda obtener el producto
            error_log(print_r($e->getMessage(), true));
            return false;
        }
    }
    
    public function getProducts(){
        try {
            $data = $this->woocommerce->get('products');
            return $data;
        } catch (\Exception $e) {
            // Manejo de errores en caso de que no se pueda crear el producto
            error_log(print_r($e->getMessage(), true));
            return false;
        }
    }
  




    
}
