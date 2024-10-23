<?php

namespace Models\Warehouse;

use Models\MasterModel;

Class WarehouseModel extends MasterModel
{
    public function consultWarehouses(){
        $sql    = "SELECT * FROM warehouse WHERE c_id = :c_id";

        return $this->select($sql, [':c_id' => $_SESSION['IdCompany']]);
    }

    public function consultArticles(int $wh_id)
    {
        $sql = "SELECT articles.*,stock.*
                FROM articles
                INNER JOIN stock
                ON articles.ar_id=stock.ar_id
                INNER JOIN warehouse
                ON stock.wh_id=warehouse.wh_id
                WHERE warehouse.wh_id=:wh_id";
            $params = [':wh_id'=>$wh_id];
            $articles = $this->select($sql, $params);
        return $articles;
    }
    public function consultWarehouseWithCode($wh_code)
    {
        $sql = "SELECT warehouse.wh_id
                FROM warehouse
                WHERE wh_code=:wh_code";
                
            $params = [':wh_code'=>$wh_code];

            $warehouse = $this->select($sql, $params);
        return $warehouse;
    }




    public function updateWarehouse($id, $name, $description,$wh_code, $address, $departament,$city, $responsible, $phone) {
    $sql = "UPDATE warehouse SET wh_name=:name, wh_desc=:desc,wh_code=:code, wh_address=:address, wh_departament=:departament,
            wh_city=:city, wh_responsible=:responsible, wh_phone=:phone WHERE wh_id=:id AND c_id=:c_id";
    $params = [
        ':id' => $id,
        ':name' => $name,
        ':desc' => $description,
        ':code' => $wh_code,
        ':address' => $address,
        ':departament' => $departament,
        ':city' => $city,
        ':responsible' => $responsible,
        ':phone' => $phone,
        ':c_id' => $_SESSION['IdCompany']
    ];
    $this->update($sql, $params);
    }

    public function deleteWarehouse($id,$idCompany) {
        
        
        
        
        $sql = "DELETE FROM warehouse WHERE wh_id=:id AND c_id=:c_id";
        $params = [
            ':id' => $id,
            ':c_id' => $idCompany
        ];
        $this->delete($sql, $params);
    }

    
    public function insertWarehouse($name,$description,$code,$address,$departament,$city,$responsible,$phone,$idCompany){
        $sql="INSERT INTO warehouse
        (wh_name, wh_desc,wh_code, wh_address,wh_departament, wh_city, wh_date, wh_responsible,wh_phone, c_id) 
        VALUES (:name,:desc,:code, :address,:departament, :city , NOW(), :responsible,:phone,:c_id)";
           $params = [
            ':name' => $name,
            ':desc' => $description,
            ':code' => $code,
            ':address' => $address,
            ':departament' => $departament,
            ':city' => $city,
            ':responsible'=>$responsible,
            ':phone'=>$phone,
            ':c_id'=>$idCompany
        ];
        // print_r(count ($params));
        // die;
        $this->insert($sql, $params);
    }
    public function consultWarehouseById($id)
    {   
        $result = $this->selectById('warehouse', 'Wh_id', $id);
        return $result;
    }

    
    
}

?>