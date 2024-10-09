<?php

namespace Models\Subcategory;

use Models\MasterModel;

Class SubcategoryModel extends MasterModel
{

    public function consultSubcategories()
    {   
        $sql = "SELECT * FROM subcategory";
            $params = [];
            $subcategories = $this->select($sql, $params);
        return $subcategories;
    }

    public function consultSubcategoryById($id){
        $result = $this->selectById('subcategory', 'sbcat_id ', $id);
        return $result;
    }

    public function insertSubcategroy($sbcat_name, $sbcat_desc, $cat_id){
        $sql    = "INSERT INTO subcategory (sbcat_name	, sbcat_desc, cat_id) VALUES (:name, :description, :category)";
        $params = [
            ':name'         => $sbcat_name,
            ':description'  => $sbcat_desc,
            ':category'     => $cat_id
        ];

        $this->insert($sql, $params);
    }

    public function consultSubcategoriesByCategory($cat_id){
        $sql = "SELECT * FROM subcategory WHERE cat_id = :category";
        $params = [
            ':category' =>  $cat_id
        ];
        return $this->select($sql, $params);
    }

    public function ConsultSubcategoryForName($sbcat_name){
        $sql    = "SELECT sbcat_id FROM subcategory WHERE sbcat_name = :sbcat_name";
        return $this->select($sql, [':sbcat_name' => $sbcat_name]);
    }

}

