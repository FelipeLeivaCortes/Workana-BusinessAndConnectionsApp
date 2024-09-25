<?php
namespace Models\Category;
use Models\MasterModel;

class CategoryModel extends MasterModel
{
    public function consultCategoryById($id)
    {   
        $result = $this->selectById('category', 'cat_id', $id);
        return $result;
    }
    
    public function consultCategories()
    {
        $sql = "SELECT * FROM category";
            $params = [];
            $categories = $this->select($sql, $params);
        return $categories;
    }

    public function InsertCategory($cat_name,$cat_desc=null){
        $sql="INSERT INTO category (cat_name,cat_desc)
        VALUES(:name,:desc)";
        $params=[':name'=>$cat_name,
                ':desc'=>$cat_desc];
        $this->insert($sql, $params);
    }

    public function consultCategoryForName($cat_name){
        $sql = "SELECT cat_id 
                FROM category
                WHERE cat_name=:cat_name";
        $params = [':cat_name'=>$cat_name];
        $Idcategory = $this->select($sql, $params);
        return $Idcategory;
    }

    public function UpdateCategory($cat_id, $cat_name, $cat_desc = null)
    {
        $sql = "UPDATE category SET cat_name = :name, cat_desc = :desc WHERE cat_id = :id";
        $params = [':name' => $cat_name, ':desc' => $cat_desc, ':id' => $cat_id];
        $this->update($sql, $params);
    }

    public function DeleteCategory($cat_id)
    {
        $sql = "DELETE FROM category WHERE cat_id = :id";
        $params = [':id' => $cat_id];
        $this->delete($sql, $params);
    }


}



?>