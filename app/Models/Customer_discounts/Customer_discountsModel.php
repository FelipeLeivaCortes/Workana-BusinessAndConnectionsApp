<?php

namespace Models\Customer_discounts;

use Models\MasterModel;

Class Customer_discountsModel extends MasterModel
{
// DELETE NULL
    public function insertCustomer_discounts($c_id , $cat_id , $sbcat_id, $ar_id, $gp_id, $price_discount)
    {
        $sql = "INSERT INTO customer_discounts (c_id, cat_id, sbcat_id, ar_id, gp_id, price_discount)
                VALUES ";
    
        $params = [];
    
        $numItems = max(count($c_id ?? []), count($cat_id ?? []), count($sbcat_id ?? []), count($ar_id ?? []));
    
        for ($i = 0; $i < $numItems; $i++) {
            $c_id_val = isset($c_id[$i]) ? $c_id[$i] : null;
            $cat_id_val = isset($cat_id[$i]) ? $cat_id[$i] : null;
            $sbcat_id_val = isset($sbcat_id[$i]) ? $sbcat_id[$i] : null;
            $ar_id_val = isset($ar_id[$i]) ? $ar_id[$i] : null;
    
            $sql .= "(:c_id{$i}, :cat_id{$i}, :sbcat_id{$i}, :ar_id{$i}, :gp_id{$i}, :price_discount{$i}), ";
    
            $params["c_id{$i}"] = !empty($c_id_val) ? $c_id_val : null;
            $params["cat_id{$i}"] = !empty($cat_id_val) ? $cat_id_val : null;
            $params["sbcat_id{$i}"] = !empty($sbcat_id_val) ? $sbcat_id_val : null;
            $params["ar_id{$i}"] = !empty($ar_id_val) ? $ar_id_val : null;
            $params["gp_id{$i}"] = $gp_id;
            $params["price_discount{$i}"] = $price_discount;
        }
    
        // Eliminar la coma final de la consulta
        $sql = rtrim($sql, ", ");
    
        // Verificar si todos los arrays están vacíos
        if ($numItems === 0) {
            return;
        }
    
        // Ejecutar la consulta
        $this->insert($sql, $params);
    }
    
    public function consultDiscounts($gp_id){
        $sql = "SELECT * FROM customer_discounts
                WHERE gp_id=:gp_id";
        $params = ['gp_id'=>$gp_id];
        $discounts = $this->select($sql, $params);
        return $discounts;
    }

    public function consultDiscountsByColumn($column,$value){
        $result=$this->selectById('customer_discounts',$column,$value);
        return $result;
    }

    public function consultAttrsListPrice(int $gp_id, $attr='ar_id'){      
        
        switch ($attr) {
            case 'ar_id':
                $table='articles';
                $column='ar_name';
                break;
            case 'c_id':
                $table='company';
                $column='c_name';
                break;
            case 'cat_id':
                $table='category';
                $column='cat_name';
                break;
            case 'sbcat_id':
                $table='subcategory';
                $column='sbcat_name';
                break;  
        }        
        
        $sql = "SELECT customer_discounts.".$attr.",".$table.".".$column."
                FROM customer_discounts
                INNER JOIN ".$table."
                ON customer_discounts.".$attr."=".$table.".".$attr."
                WHERE gp_id=:gp_id";
        $params = ['gp_id'=>$gp_id];

        $attrs = $this->select($sql, $params);
        
        return $attrs;
    }
    
    
    

} 


?>