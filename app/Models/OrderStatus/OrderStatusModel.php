<?php

namespace Models\OrderStatus;

require '../vendor/autoload.php';

use Models\MasterModel;


class OrderStatusModel extends MasterModel
{

    public function consultOrderStatus(){
        $sql = "SELECT * FROM order_states";
        $params = [];
        $result = $this->select($sql, $params); 
        return $result;
    }

    
}

?>