<?php

namespace Models\Groups;

use Models\MasterModel;


Class GroupsModel extends MasterModel
{

    public function consultGroups()
    {
        $sql = "SELECT * FROM group_discounts";
        $params = [];
        $groups = $this->select($sql, $params);
        return $groups;
    }
    public function consultGroupById($id){
        $result=$this->selectById('group_discounts','gp_id',$id);
        return $result;
    }

    public function deleteCustomer_discountsByGp_id($gp_id) {
        $sql = "DELETE FROM customer_discounts
                WHERE gp_id = :gp_id";
        $params = [':gp_id' => $gp_id];
        
        // Debes ejecutar la consulta para eliminar los registros
        $affectedRows = $this->delete($sql, $params);
        
        // Puedes devolver la cantidad de registros afectados o cualquier otra información necesaria
        return $affectedRows;
    }
    public function deleteListpriceGp_id($gp_id){
        $sql = "DELETE FROM group_discounts
                WHERE gp_id = :gp_id";
        $params = [':gp_id' => $gp_id];
        
        // Debes ejecutar la consulta para eliminar los registros
        $affectedRows = $this->delete($sql, $params);  
        // Puedes devolver la cantidad de registros afectados o cualquier otra información necesaria
        return $affectedRows;
    }
    
    
    public function insertGroup($name, $discount, $coupon,$gp_date_end_discount)
    {
        $sql = "INSERT INTO group_discounts (gp_name, gp_discount_percentage, gp_coupon,gp_date_end_discount)
                VALUES (:name, :discount, :coupon,:gp_date_end_discount)";
        $params = [
            'name' => $name,
            'discount' => $discount,
            'coupon' => $coupon,
            'gp_date_end_discount'=>$gp_date_end_discount
            
        ];
        $this->insert($sql, $params);
    }
    public function updateGroup($groupId, $name, $discount, $coupon,$gp_date_end_discount)
    {
        $sql = "UPDATE group_discounts
                SET gp_name = :name,
                    gp_discount_percentage = :discount,
                    gp_coupon = :coupon,
                    gp_date_end_discount=:gp_date_end_discount

                WHERE gp_id = :groupId";
        
        $params = [
            'groupId' => $groupId,
            'name' => $name,
            'discount' => $discount,
            'coupon' => $coupon,
            'gp_date_end_discount'=>$gp_date_end_discount
        ];

        $this->update($sql, $params);
    }

    

    
} 


?>