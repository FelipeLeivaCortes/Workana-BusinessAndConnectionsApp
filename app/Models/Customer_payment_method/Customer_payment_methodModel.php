<?php

namespace Models\Customer_payment_method;

use Models\MasterModel;

Class Customer_payment_methodModel extends MasterModel
{


    public function insertMethodPayAndCompany($c_id,$payment_method_id){
        $sql= "INSERT INTO customer_payment_method (c_id,payment_method_id)
               VALUES(:c_id,:id_payment_method)";
               
        $params=[':c_id'=>$c_id,':id_payment_method'=>$payment_method_id];
        $this->insert($sql, $params);
    }

    public function getPaymentMethodsByCustomerId($c_id) {
        $sql = "SELECT * FROM customer_payment_method WHERE c_id = :c_id";
        $params = [':c_id' => $c_id];       
        return $this->select($sql, $params);
    }
    
    public function deletePaymentMethodByCustomerId($c_id) {
        $sql = "DELETE FROM customer_payment_method WHERE c_id = :c_id";
        $params = [':c_id' => $c_id];
        $this->delete($sql, $params);
    }
    
    

} 


?>