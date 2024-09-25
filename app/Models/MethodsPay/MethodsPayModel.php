<?php

namespace Models\MethodsPay;

use Models\MasterModel;

Class MethodsPayModel extends MasterModel
{


    public function consultMethods()
    {
        $sql = "SELECT * FROM payment_methods";
        $params = [];
        $methods = $this->select($sql, $params);
        return $methods;
    }
    
    public function consultMethodsById(int $payment_method_id)
    {
        $sql = "SELECT * FROM payment_methods
                WHERE payment_method_id=:pay_id";
        $params = [':pay_id'=>$payment_method_id];
        $method= $this->select($sql, $params);
        return $method;
    }

    public function InsertPaymentMethods($name) {
        $sql = "INSERT INTO payment_methods (name) VALUES (:name)";
        $params = [':name' => $name];
        $this->insert($sql, $params);
    }
    

    // Función para verificar si un método de pago ya existe
    public function isPaymentMethodExists($name) {
        $sql = "SELECT COUNT(*) as count FROM payment_methods WHERE name = :name";
        $params = [':name' => $name];
        $result = $this->select($sql, $params);

        // Comprueba si el recuento es mayor que cero para determinar si el método de pago existe
        return $result[0]['count'] > 0;
    }
}

?>